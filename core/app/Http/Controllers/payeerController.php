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

// use App\Http\Requests;
// use App\Http\Controllers\Controller;
use Paystack;

class payeerController extends Controller
{
    private $st;
   
    public function __construct()
    {
        // parent::__construct();
        $this->st = site_settings::find(1);
            
    }

    public function pay_page()
    {
        return view('user.payeer_amt');
    }
    
    public function pm_post(Request $req)
    {
        if((FLOAT)$req->input('amount') == 0 || (FLOAT)$req->input('amount') < (FLOAT)env('MIN_DEPOSIT'))
        {
            return back()->With([
              'toast_msg' => __('messages.amt_low') ,
              'toast_type' => 'err'
            ]);
        }
        if((FLOAT)$req->input('amount') > (FLOAT)env('MAX_DEPOSIT'))
        {
            return back()->With([
              'toast_msg' => __('messages.amt_hi_than').  ' '.env('CURRENCY').env('MAX_DEPOSIT').' '.__('messages.max_dep_restr'),
              'toast_type' => 'err'
            ]);
        }
        try
        {
            // $req->input('amount') = $req->input('amount') * 100;
            return Paystack::getAuthorizationUrl()->redirectNow();
        }
        catch(\Exception $e)
        {
            return back()->With([
              'toast_msg' => __('messages.err_uknw'),
              'toast_type' => 'err'
            ]);
        }
        
    }

   
    public function createPayment(Request $req)
    {
        if((FLOAT)$req->input('amount') == 0 || (FLOAT)$req->input('amount') < (FLOAT)env('MIN_DEPOSIT'))
        {
            return back()->With([
              'toast_msg' => __('messages.amt_low'),
              'toast_type' => 'err'
            ]);
        }
        if((FLOAT)$req->input('amount') > (FLOAT)env('MAX_DEPOSIT'))
        {
            return back()->With([
              'toast_msg' => __('messages.amt_hi_than').' '.env('CURRENCY').env('MAX_DEPOSIT').' '.__('messages.max_dep_restr'),
              'toast_type' => 'err'
            ]);
        }

        try
        {
            $user = Auth::user();
            // $user = $usr->id;
            $m_shop =  env('PAYEER_MID');
            $m_orderid = strtotime(date('Y-m-d H:i:s'));
            $m_amount = number_format($req['amount'], 2, '.', '');
            $m_curr = 'USD';
            $m_desc = base64_encode('Maxprofit Deposit');
            $m_key = env('PAYEER_KEY');;

            $arHash = array(
                $m_shop,
                $m_orderid,
                $m_amount,
                $m_curr,
                $m_desc,
                $m_key
            );

            $paymt = new deposits;
            $paymt->user_id = $user->id;
            $paymt->usn = $user->username;
            $paymt->amount = $req['amount'];
            $paymt->currency = env('CURRENCY');
            $paymt->account_name = $user->username;
            $paymt->account_no = $m_orderid ;
            $paymt->bank = 'Payeer';
            $paymt->status = 0;
            $paymt->on_apr = 0;
            $paymt->pop = $m_orderid;

            $paymt->save();

            Session::put('payeer_on', 'yes');
            $sign = strtoupper(hash('sha256', implode(':', $arHash)));
            return redirect()->away("https://payeer.com/merchant/?m_shop=$m_shop&m_orderid=$m_orderid&m_amount=$m_amount&m_curr=$m_curr&m_desc=$m_desc&m_sign=$sign");
        }
        catch(\Exception $e)
        {
            return back()->with([
              'toast_msg' => __('messages.err_uknw'),
              'toast_type' => 'err'
            ]);
        }
    }

    public function success(Request $req)
    {
        $m_key = env('PAYEER_KEY');
        $m_shop = $req['m_shop'];
        $m_orderid = $req['m_orderid'];
        $m_amount = $req['m_amount'];
        $m_curr = $req['m_curr'];
        $m_desc = $req['m_desc'];
        $checksum = $req['m_sign'];
        // $user = Payment::select('user_id')->where('uid', '=', $m_orderid)->first();

        if (isset($req['m_operation_id']) && isset($checksum)) {

            $arHash = array($m_shop, $m_orderid, $m_amount, $m_curr, $m_desc, $m_key);
            $sign_hash = strtoupper(hash('sha256', implode(':', $arHash)));

            if ($checksum == $sign_hash && $req['m_status'] == 'success') {
                
                try 
                {
                    $paymt = deposits::where('account_no', $m_orderid)->where('bank', 'Payeer')->get();                    
                    $paymt[0]->status = 1;
                    $paymt[0]->on_apr = 1;                            
                                        
                    $user = User::find($paymt[0]->user_id);
                    $user->wallet += floatval(($m_amount)/100) * env('CONVERSION');

                    $paymt[0]->save();
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
                    
                    return redirect()->route('wallet', $user->username)->with([
                      'toast_msg' => __('messages.dpst_succ') ,
                      'toast_type' => 'suc'
                    ]);
                   
                } 
                catch (\Exception $e) 
                {
                    return redirect()->route('wallet')->with([
                      'toast_msg' => __('messages.dpt_err'),
                      'toast_type' => 'err'
                    ]);
                }
                
            }
        }
    }

    public function fail(Request $req)
    {
        // dd($req);
    }

}