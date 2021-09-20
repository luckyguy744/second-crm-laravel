<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\states;
use App\country;
use Session;
use Hash;
use File;
use Auth;
use App\User;
use App\banks;
use App\activities;
use App\packages;
use App\investment;
use App\msg;
use App\admin;
use App\deposits;
use App\withdrawal;
use App\adminLog;
use App\xpack_inv;
use Validator;
use App\site_settings;

use PayPal\Rest\ApiContext;

use PayPal\Auth\OAuthTokenCredential;

use PayPal\Api\Amount;

use PayPal\Api\Details;

use PayPal\Api\Item;

use PayPal\Api\ItemList;

use PayPal\Api\Payer;

use PayPal\Api\Payment;

use PayPal\Api\RedirectUrls;

use PayPal\Api\ExecutePayment;

use PayPal\Api\PaymentExecution;

use PayPal\Api\Transaction;

class PaypalController extends HomeController

{

    private $_api_context;
    private $md;
    private $st;

    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()
    {

        parent::__construct();

        

        /** setup PayPal api context **/
        $this->st = site_settings::find(1);

        $paypal_conf = \Config::get('paypal');

        $this->_api_context = new ApiContext(new OAuthTokenCredential($this->st->paypal_ID, $this->st->paypal_secret));
        $paypal_conf['settings']['mode'] = $this->st->paypal_mode;
        $this->_api_context->setConfig($paypal_conf['settings']);
        
    }

    /**

     * Show the application paywith paypalpage.

     *

     * @return \Illuminate\Http\Response

     */

    public function payWithPaypal()
    {
    	$user = Auth::User();
    	if( empty($user) )
    	{
    		return redirect('/');
    	}

    	$paypal_conf = \Config::get('paypal');
    	$settings = site_settings::find(1);
        return view('user.paypal', ['settings' => $settings]);
    }

    /**

     * Store a details of payment with paypal.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function postPaymentWithpaypal(Request $request)
    {

    	$user = Auth::User();
    	if(empty($user) )
    	{
    		return redirect('/');
    	}

        if($request->input('amount') < env('MIN_DEPOSIT'))
        {
            return back()->With(['toast_msg' => __('messages.amt_mb_grt').env('MIN_DEPOSIT').' '.$this->st->currency, 'toast_type' => 'err']);
        }

    	$st = site_settings::find(1);
    	$amt = $request->get('amount') / $st->currency_conversion;

    	Session::put('amt', $amt);

        $payer = new Payer();

        $payer->setPaymentMethod('paypal');

        $item_1 = new Item();

        $item_1->setName('Item 1') /** item name **/

            ->setCurrency('USD')

            ->setQuantity(1)

            ->setPrice($amt); /** unit price **/

        $item_list = new ItemList();

        $item_list->setItems(array($item_1));

        $amount = new Amount();

        $amount->setCurrency('USD')

            ->setTotal($amt);

        $transaction = new Transaction();

        $transaction->setAmount($amount)

            ->setItemList($item_list)

            ->setDescription('MaxProfit Deposit');

        $redirect_urls = new RedirectUrls();

        $redirect_urls->setReturnUrl(URL::route('payment.status')) /** Specify return URL **/

            ->setCancelUrl(URL::route('payment.status'));

        $payment = new Payment();

        $payment->setIntent('Sale')

            ->setPayer($payer)

            ->setRedirectUrls($redirect_urls)

            ->setTransactions(array($transaction));

            /** dd($payment->create($this->_api_context));exit; **/

        try {

            $payment->create($this->_api_context);

        } catch (\PayPal\Exception\PPConnectionException $ex) {

            if (\Config::get('app.debug')) {

                Session::put('error','Connection timeout');

                return Redirect::route('addmoney.paywithpaypal');

                /** echo "Exception: " . $ex->getMessage() . PHP_EOL; **/

                /** $err_data = json_decode($ex->getData(), true); **/

                /** exit; **/

            } else {

                Session::put('error', __('messages.some_err') );

                return Redirect::route('addmoney.paywithpaypal');

                /** die('Some error occur, sorry for inconvenient'); **/

            }

        }

        foreach($payment->getLinks() as $link) {

            if($link->getRel() == 'approval_url') {

                $redirect_url = $link->getHref();

                break;

            }

        }

        /** add payment ID to session **/

        Session::put('paypal_payment_id', $payment->getId());

        if(isset($redirect_url)) {

            /** redirect to paypal **/

            return Redirect::away($redirect_url);

        }

        Session::put('error', __('messages.err_uknw') );

        return Redirect::route('addmoney.paywithpaypal');

    }

    public function getPaymentStatus(Request $req)
    {

    	$user = Auth::User();
    	if(empty($user) )
    	{
    		return redirect('/');
    	}
        /** Get the payment ID before session clear **/

        $payment_id = Session::get('paypal_payment_id');

        /** clear the session payment ID **/

        Session::forget('paypal_payment_id');

        if (empty($req->input('PayerID')) || empty($req->input('token'))) {
        // 	$toast_msg = '[{"msg":"Payer ID or token not found","type":"err"}]';            
        //     Session::put('toast_msg', $toast_msg);
            return Redirect::route('addmoney.paywithpaypal')->With(['toast_msg' => __('messages.pyr_id_not_fnd'), 'toast_type' => 'err']);
        }

        $payment = Payment::get($payment_id, $this->_api_context);

        /** PaymentExecution object includes information necessary **/

        /** to execute a PayPal account payment. **/

        /** The payer_id is added to the request query parameters **/

        /** when the user is redirected from paypal back to your site **/

        $execution = new PaymentExecution();

        $execution->setPayerId($req->input('PayerID'));

        /**Execute the payment **/

        $result = $payment->execute($execution, $this->_api_context);

        /** dd($result);exit; /** DEBUG RESULT, remove it later **/

        // dd($result);

        if ($result->getState() == 'approved') { 

            /** it's all right **/
            $st = site_settings::find(1);
            $pyer = $result->getPayer();

            $paymt = new deposits;
            $paymt->user_id = $user->id;
            $paymt->usn = $user->username;
            $paymt->amount = Session::get('amt') * $st->currency_conversion;
            $paymt->currency = $st->currency;
            $paymt->account_name = $pyer->payer_info->email;
            $paymt->account_no = $payment_id;
            $paymt->bank = 'Paypal';
            $paymt->status = 1;
            $paymt->on_apr = 1;
            $paymt->pop = $result->getPayer();

            $paymt->save();
            $user->wallet += Session::get('amt') * $st->currency_conversion;
            $user->save();

            $maildata = ['email' => $user->email, 'username' => $user->username];

            Mail::send('mail.user_deposit_notification', ['md' => $maildata], function($msg) use ($maildata){
                $msg->from(env('MAIL_USERNAME'), env('APP_NAME'));
                $msg->to($maildata['email']);
                $msg->subject( __('messages.usr_dpt_not') );
            });

            Mail::send('mail.admin_deposit_notification', ['md' => $maildata], function($msg) use ($maildata){
                $msg->from(env('MAIL_USERNAME'), env('APP_NAME'));
                $msg->to(env('SUPPORT_EMAIL'));
                $msg->subject( __('messages.usr_dpt_not') );
            });

            /** Here Write your database logic like that insert record or value in database if you want **/
           	// $toast_msg = '[{"msg":"Payment succesfull","type":"suc"}]';            
            // Session::put('toast_msg', $toast_msg);            
            return Redirect::route('addmoney.paywithpaypal')->With(['toast_msg' => __('messages.paymt_suc') , 'toast_type' => 'suc']);

        }
        // $toast_msg = '[{"msg":"Payment not succesfull!","type":"err"}]';        
        // Session::put('toast_msg', $toast_msg);
       
        return Redirect::route('addmoney.paywithpaypal')->With(['toast_msg' => __('messages.pymt_nt_suc'), 'toast_type' => 'err']);
    }

}