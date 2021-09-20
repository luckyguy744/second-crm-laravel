<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

use Validator;
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
use App\withdrawal;
use App\deposits;
use App\ref;
use App\fund_transfer;
use App\xpack_inv;
use App\xpack_packages;
use App\site_settings;
use App\ticket;
use App\comments;
use App\admin;
use App\kyc;
use App\ref_set;
use GuzzleHttp\Client as GuzzleClient;
use DotenvEditor;

use CoinbaseCommerce\ApiClient;
use CoinbaseCommerce\Resources\Checkout;
use CoinbaseCommerce\Resources\Charge;

use Google2FA;


class userController extends Controller
{
  private $st;

  public function __construct()
  {
    $user = Auth::User();
    $this->st = site_settings::find(1);
  }
  public function index()
  {        
      //return view('user.');
  }

  public function states($id)
  {        
      $state = states::where('country_id', $id)->get();
      return json_encode($state);
  }
  public function countryCode($id)
  {        
      $code = country::where('id', $id)->get();
      return $code[0]->phonecode;
  }

  public function upload_u2s(Request $req)
  {
    $val = Validator::make($req->all(), [
        'email' => 'required|email',
        'password' => 'required|string|'
    ]);

    if($val->fails())
    {
        return back()->with([
            'toast_msg' => __('messages.err_input'),
            'toast_type' => 'err'
        ]);
    }

    try
    {
      if(Auth::attempt(['email' => $req['email'], 'password' => $req['password']])) 
      {
        $user = Auth::User();
        if($user->status == 0 || $user->status == 'New' || $user->status == 'pending')
        {
            Session::flush();
            Session::put('err_msg', __('messages.act_nt_actvtd'));
            return redirect()->bacK(); //->withErrors(['msg', 'Account not activated']);             
        }
        if($user->status == 2 || $user->status == 'Blocked')
        {
            Session::flush();
            Session::put('err_msg', __('messages.act_blckd'));
            return redirect()->bacK(); //->withErrors(['msg', 'Account not activated']);             
        }

        if($user->sec_2fa_status == 1)
        {
          Session::put('temp_login_email', $req['email']);
          Session::put('temp_login_pwd', $req['password']);
          Session::put('temp_2fa_key', $user->sec_2fa);

          Auth::logout();
          return view('user.enter_otp');
        }
        else
        {
          $act = new activities;
          $act->action = __('messages.usr_logd_');
          $act->user_id = $user->id;
          $act->save(); 
          return redirect('/'.$user->username.'/dashboard');
        }          
      }          
      return redirect()->route('login')->with([
        'toast_msg' => __('messages.usr_crtd_crr'),
        'toast_type' => 'err'
      ]);        
    }
    catch(\Exception $e)
    {      
      return back()->with([
        'toast_msg' => __('messages.err_uknw'),
        'toast_type' => 'err'
      ]);
    }
  }

  public function verify_u2s(Request $req)
  {
    $val = Validator::make($req->all(), [
        'otp' => 'required|numeric'
    ]);

    if($val->fails())
    {
        return back()->with([
            'toast_msg' => __('messages.err_input'),
            'toast_type' => 'err'
        ]);
    }

    try
    {
      if(Google2FA::verifyGoogle2FA(Session::get('temp_2fa_key'), $req['otp']))
      {
        if(Auth::attempt(['email' => Session::get('temp_login_email'), 'password' => Session::get('temp_login_pwd')])) 
        {
          $user = Auth::User();

          Session::forget('temp_login_email');
          Session::forget('temp_login_pwd');
          Session::forget('temp_2fa_key');

          $act = new activities;
          $act->action = __('messages.usr_logd_');
          $act->user_id = $user->id;
          $act->save();          
          return redirect('/'.$user->username.'/dashboard');            
        }          
        return redirect()->route('login')->with([
          'toast_msg' => __('messages.usr_crtd_crr'),
          'toast_type' => 'err'
        ]);
      }
      else
      {
        return redirect()->route('login')->with([
          'toast_msg' => __('messages.otp_nt_crr'),
          'toast_type' => 'err'
        ]);
      }        
    }
    catch(\Exception $e)
    {      
      return redirect()->route('login')->with([
        'toast_msg' => __('messages.err_uknw'),
        'toast_type' => 'err'
      ]);
    }
  }

  public function uploadProfilePic(Request $req)
  {        
      $user = Auth::User();
      if(!empty($user))
      {  
        try
        {
          $validate = $req->validate([
           'prPic' => 'required|image|mimes:jpeg,png,jpg|max:500',            
          ]);

          $file = $req->file('prPic');
          $path = $user->username.".jpg"; //$req->file('u_file')->store('public/post_img');
          $file->move(base_path().'/../img/profile/', $path);
          
          $usr = User::find($user->id);
          $usr->img = $path;
          $usr->save();

          $act = new activities;
          $act->action = __('messages.usr_upt_ppic');
          $act->user_id = $user->id;
          $act->save();

          Session::put('status', __('messages.succfl'));
          Session::put('msgType', "suc");
          return back();
        }
        catch(\Exception $e)
        {
          Session::put('status', __('messages.err_upd_img'));
          Session::put('msgType', "err");
          return back();;
        }
          
      }
      else
      {
        return redirect('/');
      }
  } 
  
  
  public function verify_reg($usn, $code)
  {      
          
        try
        {

            $usr = User::where('username', $usn)->get();
            
            if(count($usr) > 0)
            {
                if($usr[0]->act_code == 0000000000)
                {
                    Session::put('status', __('messages.act_alrdy_actv') );
                      Session::put('msgType', "err");
                }
                elseif($usr[0]->act_code == $code)
                {
                    $usr[0]->status = 1;
                    $usr[0]->act_code = 0000000000;
                      $usr[0]->save();
                      
                      Session::put('status', __('messages.act_actvn_succ'));
                      Session::put('msgType', "suc");
                }
                else
                {
                    Session::put('status', __('messages.invd_actvn_cd'));
                      Session::put('msgType', "err");
                }
            }
            else
            {
                
                  Session::put('status', __('messages.act_actv_err'));
                  Session::put('msgType', "err");
                  
            }
           
              return view('auth.act_verify');
        }
        catch(\Exception $e)
        {
          Session::put('status', __('messages.err_cntc_sppt') );
              Session::put('msgType', "err");
            return view('auth.act_verify');
        }
          
      
  } 

  public function changePwd(Request $req)
  {        
      $user = Auth::User();
      if(!empty($user))
      {            
          if($req->input('newpwd') == $req->input('cpwd'))
          {
            if($req->input('newpwd') == $req->input('oldpwd'))
            {                                 
                Session::put('status', __('messages.err_cntc_sppt'));
                Session::put('msgType', "err");
                return back();
            }
            try
          {
                $usr = User::find($user->id);
                if(Hash::check($req->input('oldpwd'), $user->pwd))
                {
                  $usr->pwd = Hash::make($req->input('newpwd'));
                  $usr->save();

                      $act = new activities;
                      $act->action = __('messages.usr_chng_pwd');
                      $act->user_id = $user->id;
                      $act->save();
                      
                      Session::put('status', __('messages.pwd_chng'));
                      Session::put('msgType', "suc");
                  return back();
                }
                else
                {
                  Session::put('status', __('messages.old_pwd_invld'));
                      Session::put('msgType', "err");
                      return back();
                // return back();
                }                 
          }
          catch(\Exception $e)
          {
            Session::put('status', __('messages.err_savn_pwd'));
                  Session::put('msgType', "err");
                return back();
          }
          }
          else
          {
            Session::put('status',  __('messages.pwd_nt_mtch'));
            Session::put('msgType', "err");
            return back();;
          }           
          
      }
      else
      {
        return redirect('/');
      }
          
  }

  public function updateProfile(Request $req)
  {        
      $user = Auth::User();
      if(!empty($user))
      {
        try
        {
          $validate = $req->validate([
               'phone' => 'required|digits_between:8,15',            
            ]);

            //$country = country::find($req->input('country'))            
            $usr = User::find($user->id);                 
            $usr->country = $req->input('country');
            $usr->state = $req->input('state');
            $usr->address = $req->input('adr');
            $usr->phone = $req->input('cCode').$req->input('phone');
                            
            $usr->save(); 

            $act = new activities;
            $act->action = __('messages.usr_updtd_prfl');
            $act->user_id = $user->id;
            $act->save();


            Session::put('status', __('messages.prfl_upd_succ'));
            Session::put('msgType', "suc");
            return back();
                                
        }
        catch(\Exception $e)
        {
          Session::put('status', __('messages.err_savn_dat'));
          Session::put('msgType', "err");
          return back();
        }                 
          
      }
      else
      {
        return redirect('/');
      }
          
  }

  public function addbank(Request $req)
  {  

      $user = Auth::User();
      if(!empty($user))
      {         
        try
        {         
          $bank = new banks;                  
          $bank->user_id = $user->id;
          $bank->Account_name = $req->input('act_name');
          $bank->Account_number = $req->input('actNo');
          $bank->Swift_number = $req->input('swift_num');
          $bank->Bank_Name = $req->input('bname');          
            
          $bank->save();      


            $act = new activities;
            $act->action = __('messages.usr_add_bnk_dtl');
            $act->user_id = $user->id;
            $act->save();


          
          Session::put('status', __('messages.bnk_add_succ'));
          Session::put('msgType', "suc");
              
          return back();
                                
        }
        catch(\Exception $e)
        {
            Session::put('status', __('messages.err_savn_detl'));
            Session::put('msgType', "err");
            return back();
        }                 
          
      }
      else
      {
        return redirect('/');
      }
          
  }

  public function deleteBankAccount($id)
  {        
      $user = Auth::User();
      if(!empty($user))
      {            
          
        try
        {         
              $bank = banks::where('id', $id)->delete(); 

              $act = new activities;
              $act->action = __('messages.usr_delt_bnk');
              $act->user_id = $user->id;
              $act->save();

              Session::put('status', __('messages.bnk_delt_succ'));
              Session::put('msgType', "suc");
              return back();
                                
        }
        catch(\Exception $e)
        {
          Session::put('status', __('messages.err_savn_detl'));
          Session::put('msgType', "err");             
          return back();
        }                 
          
      }
      else
      {
        return redirect('/');
      }
          
  }



  public function invest(Request $req)
  {        
      $user = Auth::User();

      if($this->st->investment != 1 )
      {
        Session::put('msgType', "err");              
        Session::put('status', __('messages.invstm_disb'));
        return back();
      }

      if($user->status == 'Blocked' || $user->status == 2 )
      {
        Session::put('msgType', "err");              
        Session::put('status', __('messages.act_blckd'));
        return redirect('/login');
      }

      if($user->status == 'pending' || $user->status == 0 )
      {
        Session::put('msgType', "err");              
        Session::put('status', __('messages.act_nt_actvtd'));
        return redirect('/login');
      }



      if(!empty($user))
      {            
          
        try
        {     
          $capital = $req->input('capital');
          $pack = packages::find($req->input('p_id'));

          if($user->wallet < $capital)
          {
            Session::put('status', __('messages.walt_bal_lw'));
            Session::put('msgType', "err");
            return back();
          }
          
          if($user->wallet < $pack->min)
          {
            Session::put('status', __('messages.walt_bal_min'));
            Session::put('msgType', "err");
            return back();
          }
          
          if($capital > $pack->max)
          {
            Session::put('status', __('messages.input_capt_max'));
            Session::put('msgType', "err");
            return back();
          }
          
          if($capital < $pack->min)
          {
            Session::put('status', __('messages.input_capt_min'));
            Session::put('msgType', "err");
            return back();
          }

          if($capital >= $pack->min && $capital <= $pack->max) 
          {
            $inv = new investment;
            $inv->capital = $capital;
            $inv->user_id = $user->id;
            $inv->usn = $user->username;
            $inv->package = $pack->package_name;
            $inv->date_invested = date("Y-m-d");
            $inv->period = $pack->period;    
            $inv->days_interval = $pack->days_interval;          
            $inv->i_return = (round($capital*$pack->daily_interest*$pack->period,2));
            $inv->interest = $pack->daily_interest;
            // $no = 0;
            $dt = strtotime(date('Y-m-d'));
            $days = $pack->period;
            
            if($pack->method == 1)
            {
              while ($days > 0) 
              {
                  $dt    +=   86400;     
                  $what_day = date("N", $dt);
                  if ($what_day < 6) 
                  { 
                    // 6 and 7 are weekend days
                    $actualDate = date('Y-m-d', $dt);
                    $days--;
                  };
              };
              
            }  
            else
            {
              while ($days > 0) 
              {
                  $dt    +=   86400   ;     
                  $actualDate = date('Y-m-d', $dt);                  
                  $days--;
              } 
            } 

            $inv->package_id = $pack->id;
            $inv->currency = $this->st->currency;
            $inv->end_date = $actualDate;
            $inv->last_wd = date("Y-m-d");
            $inv->status = 'Active';
            $inv->method = $pack->method;

            $user->wallet -= $capital;
            $user->save();
            
            $inv->save();

            if(!empty($user->referal))
            {
              $ref_bonuses = ref_set::all();
              
              if(env('REF_TYPE') == 'Once' && count($ref_bonuses) > 0)
              {
                $ref_cnt = env('REF_LEVEL_CNT');
                $new_ref_user = $user->referal;
                $itr_cnt = 0;                

                $refExist = ref::where('user_id', $user->id)->get();
                if(count($refExist) == 0)
                {
                    while ($itr_cnt <= $ref_cnt-1)
                    {
                        $refUser = User::where('username', $new_ref_user)->get();
                        if(count($refUser) > 0)
                        {
                            $ref = new ref;
                            $ref->user_id = $user->id;
                            $ref->username = $new_ref_user;
                            $ref->wdr = 0;
                            $ref->currency = env('CURRENCY');
                            $ref->amount = $capital * $ref_bonuses[$itr_cnt]->val;
                            $ref->level = $itr_cnt+1;
                            $ref->save();
                
                            $refUser[0]->ref_bal += $capital * $ref_bonuses[$itr_cnt]->val;
                            $new_ref_user = $refUser[0]->referal;   
                            $refUser[0]->save(); 
                        }                    
                        $itr_cnt += 1; 
                        if(env('REF_SYSTEM') == 'Single_level')
                        {
                          break;
                        }
                    }
                              
                }                
                
              }
              if(env('REF_TYPE') == 'Continous' && count($ref_bonuses) > 0)
              {
                $ref_cnt = env('REF_LEVEL_CNT');
                $new_ref_user = $user->referal;
                $itr_cnt = 0;    

                while ($itr_cnt <= $ref_cnt-1)
                {
                    $refUser = User::where('username', $new_ref_user)->get();
                    if(count($refUser) > 0)
                    {
                        $ref = new ref;
                        $ref->user_id = $user->id;
                        $ref->username = $new_ref_user;
                        $ref->wdr = 0;
                        $ref->currency = env('CURRENCY');
                        $ref->amount = $capital * $ref_bonuses[$itr_cnt]->val;
                        $ref->level = $itr_cnt+1;
                        $ref->save();
                    
                        $refUser[0]->ref_bal += $capital * $ref_bonuses[$itr_cnt]->val;
                        $refUser[0]->save(); 
                        $new_ref_user = $refUser[0]->referal;   
                    }                    
                    $itr_cnt += 1; 
                    if(env('REF_SYSTEM') == 'Single_level')
                    {
                        break;
                    }
                }
              }
            }
            
            $maildata = ['email' => $user->email, 'username' => $user->username];
            Mail::send('mail.user_inv_notification', ['md' => $maildata], function($msg) use ($maildata){
                $msg->from(env('MAIL_USERNAME'), env('APP_NAME'));
                $msg->to($maildata['email']);
                $msg->subject('User Investment');
            });

            $maildata = ['email' => $user->email, 'username' => $user->username];
            Mail::send('mail.admin_inv_notification', ['md' => $maildata], function($msg) use ($maildata){
                $msg->from(env('MAIL_USERNAME'), env('APP_NAME'));
                $msg->to(env('SUPPORT_EMAIL'));
                $msg->subject('User Investment');
            });

            $act = new activities;
            $act->action = __('messages.usr_invtd')." ".$capital." in ".$pack->package_name." package";
            $act->user_id = $user->id;
            $act->save();

            Session::put('status', __('messages.invstm_succ'));
            Session::put('msgType', "suc");
            return back() ;
          }
          else
          {
            Session::put('status', __('messages.invd_amnt_try'));
            Session::put('msgType', "err");
            return back();
          }            
                                
        }
        catch(\Exception $e)
        {
            Session::put('status', __('messages.err_crtn_invst'));
            Session::put('msgType', "err");
            return back();
        }                 
          
      }
      else
      {
        return redirect('/');
      }
          
  }


  public function wd_invest(Request $req)
  {        
      $user = Auth::User();

      if($user->status == 'pending' || $user->status == 0 )
      {
        Session::put('msgType', "err");              
        Session::put('status', __('messages.act_nt_actvtd') );
        return redirect('/login');
      }

      if($user->status == 'Blocked' || $user->status == 2 )
      {
        Session::put('msgType', "err");              
        Session::put('status', __('messages.act_blckd') );
        return redirect('/login');
      }

      if(!empty($user))
      {            
        
        try
        { 
          
          if($req->input('pack_type') == 'xpack')
          {
              $pack = xpack_inv::find($req->input('p_id'));
          }
          else
          {
              $pack = investment::find($req->input('p_id'));
          }

          $in = $pack;
          $withdrawable = 0;
          $ended = '';

          $totalElapse = getDays(date('Y-m-d'), $in->end_date);
        
            if($totalElapse == 0)
            {
                $lastWD = $in->last_wd;
                $enddate = ($in->end_date);
    
                if($in->method == 1)
                {
                  $Edays = getWorkingDays($lastWD, $enddate);
                  $ern  = $Edays*$in->interest*$in->capital;
                  $withdrawable = $ern;              
                  $totalDays = getWorkingDays($in->date_invested, $in->end_date);
                  $ended = "yes";
                }
                else
                {
                  $Edays = getDays($lastWD, $enddate);
                  $ern  = $Edays*$in->interest*$in->capital;
                  $withdrawable = $ern;              
                  $totalDays = getDays($in->date_invested, $in->end_date);
                  $ended = "yes";
                }
                
                
            }
            else
            {
                $lastWD = $in->last_wd;
                $enddate = date('Y-m-d');
    
                if($in->method == 1)
                {
                  $Edays = getWorkingDays($lastWD, $enddate);
                  $ern  = $Edays*$in->interest*$in->capital;              
                  if ($Edays >= $in->days_interval)
                  {
                      $withdrawable = $Edays*$in->interest*$in->capital;
                  }                                         
                  $totalDays = getWorkingDays($in->date_invested, $enddate);
                  $ended = "no";
                }
                else
                {
                  $Edays = getDays($lastWD, $enddate);
                  $ern  = $Edays*$in->interest*$in->capital;              
                  if ($Edays >= $in->days_interval)
                  {
                      $withdrawable = $Edays*$in->interest*$in->capital;
                  }                                         
                  $totalDays = getDays($in->date_invested, $enddate);
                  $ended = "no";
                }
               
            }

          $con_amt = bcdiv(floatval($req->input('amt')), 1, 2);
          $conv_withdrawable = bcdiv(floatval($withdrawable), 1, 2);
          //dd($conv_withdrawable);

          if($con_amt != $conv_withdrawable)
          {
            return back()->with([
              'toast_msg' => __('messages.invd_amnt'),
              'toast_type' => 'err'
            ]);
          }
          
          $amt = $withdrawable;

          if(floatval($amt) <= 0)
          {
            return back()->with([
              'toast_msg' => __('messages.invd_amnt_exp'),
              'toast_type' => 'err'
            ]);
          }

          if($ended == 'yes')
          {
            if($pack->status != 'Expired')
            {
                $user->wallet += $pack->capital;
                $user->save();
            }
            $pack->last_wd = $pack->end_date;
            $pack->status = 'Expired';

          }    
          else
          {
              
            $dt = strtotime($pack->last_wd);
            $days = $pack->days_interval;
           
            while ($days > 0) 
            {
              $dt    +=   86400   ;     
              $actualDate = date('Y-m-d', $dt);
              // if (date('N', $dt) < 6) 
              // {
                  $days--;
              //}
            }
            $pack->last_wd = date('Y-m-d');
          }
          
          $pack->w_amt += $amt;            
          $usr = User::find($user->id);
          $usr->wallet += $amt;

          $pack->save();
          $usr->save();

          $act = new activities;
          $act->action = __('messages.usr_wthdrwn') .$pack->package.__('messages.pkg_p_id').' '.$pack->id;
          $act->user_id = $user->id;
          $act->save();

          Session::put('status', __('messages.pckg_wthd_succ'));
          Session::put('msgType', "suc");
          return back();

        }
        catch(\Exception $e)
        {
          Session::put('status', __('messages.err_subm_wthd'));
          Session::put('msgType', "err");
          return back();
        }
          
      }
      else
      {
        return redirect('/');
      }
  }

  

  public function user_wallet_wd(Request $req)
  {        
      $user = Auth::User();
      
      if($this->st->withdrawal != 1 )
      {
        Session::put('msgType', "err");              
        Session::put('status', __('messages.wthd_dsbl'));
        return back();
      }

      if($user->status == 'Blocked' || $user->status == 2 )
      {
        Session::put('msgType', "err");              
        Session::put('status', __('messages.act_blckd'));
        return back();
      }

      if($user->status == 'pending' || $user->status == 0 )
      {
        Session::put('msgType', "err");              
        Session::put('status', __('messages.act_nt_actvtd'));
        return back();
      }

      if(intval($req->input('amt')) > intval($user->wallet) || intval($req->input('amt')) == 0 )
      {
        Session::put('msgType', "err");              
        Session::put('status', __('messages.invd_wthd'));
        return back();
      }  
      
           if(intval($req->input('amt')) < env('MIN_WD'))
      {
        $wdmin = env('MIN_WD');
        Session::put('msgType', "err");              
        Session::put('status', __('messages.inv_grt_min').' ' .env('MIN_WD'));
        return back();
      }

      if(intval($req->input('amt')) > env('WD_LIMIT'))
      {
        Session::put('msgType', "err");              
        Session::put('status', env('WD_LIMIT').__('messages.wthd_limt').' ');
        return back();
      }


      if(!empty($user))
      {         
        try
        {  

          $usr = User::find($user->id);
          $usr->wallet -= intval($req->input('amt'));
          $usr->save();

          $wd = new withdrawal;
          $wd->user_id = $user->id;
          $wd->usn = $user->username;
          $wd->package = 'wallet';
          $wd->invest_id = $user->id;
          $wd->amount = intval($req->input('amt'));
          $wd->account = $req->input('bank');
          $wd->w_date = date('Y-m-d');
          $wd->currency = $user->currency;
          $wd->charges = $charge = intval($req->input('amt'))*env('WD_FEE');
          $wd->recieving = intval($req->input('amt'))-$charge;
          $wd->save();

          $act = new activities;
          $act->action = __('messages.usr_reqst');
          $act->user_id = $user->id;
          $act->save();

          $maildata = ['email' => $user->email, 'username' => $user->username];
          Mail::send('mail.wd_notification', ['md' => $maildata], function($msg) use ($maildata){
              $msg->from(env('MAIL_USERNAME'), env('APP_NAME'));
              $msg->to($maildata['email']);
              $msg->subject(__('messages.wd_not_ttl'));
          });

          $maildata = ['email' => $user->email, 'username' => $user->username];
          Mail::send('mail.admin_wd_notification', ['md' => $maildata], function($msg) use ($maildata){
              $msg->from(env('MAIL_USERNAME'), env('APP_NAME'));
              $msg->to(env('SUPPORT_EMAIL'));
              $msg->subject(__('messages.wd_not_ttl'));
          });

          $wd_fee = env("WD_FEE")*100;
          Session::put('status', __('messages.walt_wthd_succ').' '.$wd_fee.'% '.__('messages.proc_fee') );
          Session::put('msgType', "suc");
          return back();
        }
        catch(\Exception $e)
        {
          Session::put('status', __('messages.err_uknw'));
          Session::put('msgType', "err");
          return back();
        }
          
      }
      else
      {
        return redirect('/');
      }
  }

  
  public function user_ref_wd(Request $req)
  {        
      $user = Auth::User();

      if(env('WITHDRAWAL') != 1  )
      {
        Session::put('msgType', "err");              
        Session::put('status', __('messages.wthd_dsbl'));
        return back();
      }

      if($user->status == 'Blocked' || $user->status == 2 )
      {
        Session::put('msgType', "err");              
        Session::put('status', __('messages.act_blckd'));
        return back();
      }

      if($user->status == 'pending' || $user->status == 0 )
      {
        Session::put('msgType', "err");              
        Session::put('status', __('messages.act_nt_actvtd'));
        return back();
      }

      if(intval($req->input('amt')) < env('MIN_WD'))
      {
        Session::put('msgType', "err");              
        Session::put('status', __('messages.amnt_lw_min').' '.env('MIN_WD'));
        return back();
      }

      if(intval($req->input('amt')) > env('WD_LIMIT'))
      {
        Session::put('msgType', "err");              
        Session::put('status', env('WD_LIMIT'). __('messages.wthd_limt').' ');
        return back();
      } 

      if(intval($req->input('amt')) > intval($user->ref_bal) || intval($req->input('amt')) == 0)
      {
        Session::put('msgType', "err");              
        Session::put('status', __('messages.invd_wthd'));
        return back();
      }


      if(!empty($user))
      { 
        $iv = investment::where('user_id', $user->id)->get();
        if(count($iv) < 1)
        {
          Session::put('msgType', "err");              
          Session::put('status', __('messages.invst_least'));
          return back();
        }
                  
        try
        {  

          $usr = User::find($user->id);
          $usr->ref_bal -= intval($req->input('amt'));
          $usr->save();

          $wd = new withdrawal;
          $wd->user_id = $user->id;
          $wd->usn = $user->username;
          $wd->package = 'ref_bonus';
          $wd->invest_id = $user->id;
          $wd->amount = intval($req->input('amt'));
          $wd->account = $req->input('bank');
          $wd->w_date = date('Y-m-d');
          $wd->currency = $user->currency;
          $wd->charges = $charge = intval($req->input('amt'))*env('WD_FEE');
          $wd->recieving = intval($req->input('amt'))-$charge;
          $wd->save();

          $act = new activities;
          $act->action =  __('messages.usr_requst_bns');
          $act->user_id = $user->id;
          $act->save();
          
          $maildata = ['email' => $user->email, 'username' => $user->username];
          Mail::send('mail.wd_notification', ['md' => $maildata], function($msg) use ($maildata){
              $msg->from(env('MAIL_USERNAME'), env('APP_NAME'));
              $msg->to($maildata['email']);
              $msg->subject( __('messages.usr_wdr_not'));
          });

          $maildata = ['email' => $user->email, 'username' => $user->username];
          Mail::send('mail.wd_notification', ['md' => $maildata], function($msg) use ($maildata){
              $msg->from(env('MAIL_USERNAME'), env('APP_NAME'));
              $msg->to(env('SUPPORT_EMAIL'));
              $msg->subject(  __('messages.usr_wdr_not') );
          });
         
          Session::put('status',  __('messages.refrrl_wthd_succ'));
          Session::put('msgType', "suc");
          return back();

        }
        catch(\Exception $e)
        {
          Session::put('status', __('messages.err_subm_wthd'));
          Session::put('msgType', "err");
          return back();
        }
          
      }
      else
      {
        return redirect('/');
      }
  }


  public function readmsg_up($id)
  {        
      $user = Auth::User();
      if(!empty($user))
      {            
          
        try
        {  
          $msg = msg::find($id);
          $str = explode(';', $msg->readers);   
                                           
          if(!in_array($user->id, $str))
          {
            if($msg->readers == "")
            {
              $msg->readers = $user->id.';';
            }
            else
            {
              $msg->readers = $msg->readers.$user->id.';';
            }
            $msg->save();
          }  
          return "s";         
        }
        catch(\Exception $e)
        {           
          return 'err';
        }                 
          
      }
      else
      {
        return redirect('/');
      }
          
  }


  public function user_deposit_trans(Request $req)
  {        
      $user = Auth::User();

      if($user->status == 'Blocked' || $user->status == 2 )
      {
        Session::put('msgType', "err");              
        Session::put('status', __('messages.act_blckd'));
        return back();
      }

      if($user->status == 'pending' || $user->status == 0 )
      {
        Session::put('msgType', "err");              
        Session::put('status', __('messages.act_nt_actvtd'));
        return back();
      }


      if(!empty($user))
      {  
        
        try
        { 

          $validator = Validator::make($req->all(), [
            'pop' => 'required|image|mimes:jpeg,png,jpg|max:500', 
            'act_no' => 'required|numeric' ,
            'p_amt' => 'required|numeric' , 
          ]);

          if($validator->fails()){
            Session::put('msgType', "err");              
            Session::put('status', $validator->errors()->first());
            return back();
          }
          
          $wd = new deposits;
          $wd->user_id = $user->id;
          $wd->usn = $user->username;
          // $wd->package = 'ref_bonus';
          // $wd->invest_id = $user->id;
          $wd->amount = intval($req->input('p_amt'));
          $wd->account_name = $req->input('act_name');
          $wd->account_no = $req->input('act_no');
          $wd->currency = $user->currency;
          $wd->bank = $req->input('y_bank');

          $file = $req->file('pop');
          $path =  $user->username.time().'.jpg';
          $file->move(public_path().'/pop/', $path);
          
          $wd->pop = $path;
          $wd->save();

          $act = new activities;
          $act->action = __('messages.usr_dpst') ." ".$user->currency.intval($req->input('p_amt')).' '.__('messages.tru_bnk_tr');
          $act->user_id = $user->id;
          $act->save();

          Session::put('status', __('messages.dpst_dtl'));
          Session::put('msgType', "suc");
          return back();

        }
        catch(\Exception $e)
        {
          Session::put('status', __('messages.err_subm_wthd'));
          Session::put('msgType', "err");
          return back();
        }
          
      }
      else
      {
        return redirect('/');
      }
  }


  public function payment_suc($amt, Request $req)
  {        
      $user = Auth::User();        
      if($req->input('event') == 'successful' && $req->input('txref') == Session::get('pay_ref'))
      {
          try
          {
            $dep = new deposits;
            $dep->user_id = $user->id;
            $dep->usn = $user->username;
            $dep->amount = $amt; //Session::get('payAmt');
            $dep->currency = $user->currency;
            $dep->account_name =  $req->input('flwref');
            // $dep->account_no = $_GET['flwref'];
            $dep->bank       = 'Ref:'.$req->input('txref');
            $dep->status = 1;
            $dep->on_apr = 1;
            $user->wallet += intval($amt);
            $user->save();
  
            $dep->save();

            Session::forget('pay_ref');
  
            Session::put('status', __('messages.py_succ'));      
            Session::put('msgType', "suc");
            Session::put('payment_complete', "yes");
            return redirect('/'.$user->username.'/dashboard');
            
              $act = new activities;
              $act->action = __('messages.usr_dpst')." ".$user->currency.intval($req->input('p_amt')).' '.__('messages.tru_flutter');
              $act->user_id = $user->id;
              $act->save();
          }
          catch(\Eception $e)
          {
              Session::put('status', __('messages.err_updt_walt'));      
              Session::put('msgType', "err");
              Session::put('payment_complete', "yes");
              return redirect('/'.$user->username.'/wallet');
          }

      }
      else
      {
        Session::put('status', __('messages.invld_py_crd'));      
        Session::put('msgType', "err");
        Session::put('payment_complete', "yes");
        return redirect('/'.$user->username.'/wallet');
      }

  }
  
  
  public function reset_pwd(Request $req)
  {        
      // $user = Auth::User();        
      if($req->input('password') != $req->input('c_pwd'))
      {
          Session::put('status', __('messages.pwd_nt_mtch'));      
          Session::put('msgType', "err");
          return back();
      }
      
      $validator = Validator::make($req->all(), [
          'password' => 'required|string|min:8|max:20', 
          'c_pwd' => 'required|string|min:8|max:20' ,
      ]);

      if($validator->fails()){
        Session::put('msgType', "err");              
        Session::put('status', $validator->errors()->first());
        return back();
      }
      
      try
      {
          $usr = User::where('username', Session::get('reset_pwd_usn'))->get();
          if(count($usr) > 0)
          {
              if($usr[0]->remember_token != '' && Hash::check(Session::get('reset_pwd_token'), $usr[0]->remember_token))
              {
                  $usr[0]->pwd = Hash::make($req->input('password'));
                  $usr[0]->remember_token = '';
                  $usr[0]->save();
                  
                  // Session::forget('reset_pwd_token');
                  Session::forget('reset_pwd_usn');
                  
                  Session::put('status', __('messages.pwd_rst_succ'));      
                  Session::put('msgType', "suc");
                  Session::put('pwd_rst_suc', "successful");
                  return back();
              }
              else
              {
                  return back();
              }
          }
          else
          {
            Session::put('status', __('messages.usr_tokn'));      
            Session::put('msgType', "err");
            return back();
          }
      }
      catch(\Exception $e)
      {
          Session::put('status', __('messages.err_updt_pwd'));      
          Session::put('msgType', "err");
          return back();
      }

  }
  
  
  
  public function user_req_pwd(Request $req)
  {        
      
      $validator = Validator::make($req->all(), [
          'email' => 'required|email' , 
      ]);

      if($validator->fails()){
        Session::put('msgType', "err");              
        Session::put('status', $validator->errors()->first());
        return back();
      }
      
      try
      {
          $usr = User::where('email', $req->input('email'))->get();
          if(count($usr) > 0)
          {
              $token = time();
              
              $usr[0]->remember_token = Hash::make($token);
              $usr[0]->save();
              
              $maildata = ['email' => $usr[0]->email, 'username' => $usr[0]->username, 'token' => $token ];
              Mail::send('mail.pwd_req', ['md' => $maildata], function($msg) use ($maildata){
                  $msg->from(env('MAIL_USERNAME'), env('APP_NAME'));
                  $msg->to($maildata['email']);
                  $msg->subject(__('messages.pwd_rst_ttl'));
              });
              
              Session::forget('pwd_rst_suc');
              Session::put('status', __('messages.pwd_rst_lnk'));      
              Session::put('msgType', "suc");
              return back();
    
          }
          else
          {
            Session::put('status', __('messages.usr_nt_fod'));      
            Session::put('msgType', "err");
            return back();
          }
      }
      catch(\Exception $e)
      {
          Session::put('status', __('messages.err_snd_rsml'));      
          Session::put('msgType', "err");
          return back();
      }

  }
  
  
  
  public function pwd_req_verify($usn, $token)
  {        
      $usr = User::where('username', $usn)->get();
      if(Hash::check($token, $usr[0]->remember_token))
      {
          Session::put('reset_pwd_usn', $usr[0]->username);
          Session::put('reset_pwd_token', $token);
          return view('auth.passwords.reset');
      }
      else
      {
          Session::put('pwd_reset_err', __('messages.lnk_exprd'));
          return view('auth.passwords.reset');
      }

  }

  public static function home_login()
  {        
    Redirect::route('homelogin');
  }
  
  
  public function user_send_fund(Request $req)
  {        
      $login_user = Auth::User();
      $user = User::find($login_user->id);

      if(empty($user))
      {
        return redirect('/');
      }


      $validator = Validator::make($req->all(), [
          'usn' => 'required|string', 
          's_amt' => 'required|numeric',
      ]);

      if($validator->fails()){
          Session::put('err_send', $validator->errors()->first());
          Session::put('status', $validator->errors()->first());      
          Session::put('msgType', "err");
          return back();
      }
      
      if($user->username == $req->input('usn'))
      {
          Session::put('err_send', __('messages.yu_cnt_fnd'));
          Session::put('status', __('messages.yu_cnt_fnd'));      
          Session::put('msgType', "err");
          return back();
      }        
     
      if($user->wallet < 10)
      {
          Session::put('err_send', __('messages.walt_bal_min'));
          Session::put('status', __('messages.walt_bal_min'));      
          Session::put('msgType', "err");
          return back();
      }
      
              
      if($user->wallet < intval($req->input('s_amt')) )
      {
          Session::put('err_send', __('messages.walt_bal_amnt'));
          Session::put('status', __('messages.walt_bal_amnt'));      
          Session::put('msgType', "err");
          return back();
      }
      
      try
      {
          $rec = User::where('username', trim($req->input('usn')))->get();
          if(count($rec) < 1)
          {
              Session::put('err_send', __('messages.usr_rcrd'));
              Session::put('status', __('messages.usr_rcrd'));      
              Session::put('msgType', "err");
              return back();
          }
          
            
          $amt = intval($req->input('s_amt'));
          
          
          $user->wallet -=  intval($req->input('s_amt'));
          $user->save();

          $rec[0]->wallet += $amt;
          $rec[0]->save();  
          
          $rc = new fund_transfer;
          $rc->from_usr = $user->username;
          $rc->to_usr = trim($req->input('usn'));
          $rc->amt = intval($req->input('s_amt'));
          $rc->save();
          
          $act = new activities;
          $act->action = __('messages.usr_fnd')." ".$user->currency.intval($req->input('s_amt'))." to ".trim($req->input('usn'));
          $act->user_id = $user->id;
          $act->save();
          
          Session::put('status', __('messages.tracs_succ'));      
          Session::put('msgType', "suc");
          return back();
      }
      catch(\Exception $e)
      {
          Session::put('err_send', __('messages.err_sndn_fnd'));
          Session::put('status', __('messages.err_sndn_fnd'));      
          Session::put('msgType', "err");
          return back();
      }

  }
  
  public function addBtcWallet(Request $req)
  { 
    $user = Auth::User();
    if(!empty($user))
    {            
      try
      {         
        $bank = new banks;                  
        $bank->user_id = $user->id;
        $bank->Account_name = "BTC";
        $bank->Account_number = $req->input('coin_wallet');
        $bank->Bank_Name = $req->input('coin_host');
        $bank->save();

        $act = new activities;
        $act->action = __('messages.usr_btc');
        $act->user_id = $user->id;
        $act->save();
        
        return back()->With([
          'toast_msg' => __('messages.walt_sav'),
          'toast_type' => 'suc'
        ]);
      }
      catch(\Exception $e)
      {
        return back()->With([
          'toast_msg' => __('messages.err_sav_walt'),
          'toast_type' => 'err'
        ]);
      }
    }
    else
    {
      return redirect('/login') ;
    }
      
  }

  public static function homelogin()
  {        
    return view('auth.home_login');
    // View::make('auth.home_login');
  }

  public function notifications(){
    $user = Auth::User();
    if(!empty($user)){
      $msgs = msg::orderby('id', 'desc')->get();
      return view('user.messages', ['msgs' => $msgs]);
    }
    else
    {
      return redirect('/login');
    }
  }

  public function notifications_read($msgID){
    $user = Auth::User();
    if(!empty($user)){
      $msgs = msg::orderby('id', 'desc')->get();
      return view('user.messages', ['msgs' => $msgs, 'msgID' => $msgID]);
    }
    else
    {
      return redirect('/login');
    }
  }

  // coded added 01/06/2020 ////////////////////////////////////////////////

  public function pay_with_btc(Request $req){    
    $user = Auth::User();
    if(!empty($user))
    {
      return view('user.pay_btc_amt')->with(['coin' => $req['coin']]);
    }
    else
    {
      return redirect('/login');
    }
    
  }

  public function login_system(Request $req)
  {   

    try
    {
      $url = 'https://demo.mcode.me/coinpayment/confirm/a';          
      $ch = curl_init($url);          
      $data = array(
        'key' => $req['key'],
        'url' => url('/')
      );
      $payload = json_encode($data);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $result = curl_exec($ch);
      curl_close($ch);
      
      $response = json_decode($result);
       
      // dd($response);

      if(isset($response->resp) && $response->resp == 'ok')
      {
        $adm = admin::find(1);
        $adm->email = $req['username'];
        $adm->pwd = Hash::make($req['password']);
        $adm->save();

        $file = DotenvEditor::setKeys([
          [
              'key'     => 'VARIABLE_KEY',
              'value'   => $req['key']
          ],              
          [
              'key'     => 'APP_NAME',
              'value'   => $req['app_name']
          ],
          [
              'key'     => 'APP_URL',
              'value'   => url('/')
          ]
          
        ]);

        $file = DotenvEditor::save();
        $file_cont = json_encode($data);
        // dd($file_cont);
        \Storage::put('file.txt', $file_cont);

        return redirect()->route('login');
      } 
      
      if(isset($response->resp) && $response->resp == 'diff_domain')
      {
        return back()->with(['err' => __('messages.key_u_dif_d')]);
      }

      if(isset($response->resp) && $response->resp == 'not_found')
      {
        return back()->with(['err' => __('messages.act_key_nt_fnd')]);
      }
      
      return back()->with(['err' => __('messages.check_act_key')]); 
    }
    catch(\Exception $e)
    {
      return back()->with(['err' => __('messages.act_err_key')]); 
    }
    
  }

  public function pay_btc_amt(Request $req){
    
    $user = Auth::User();
    if($req->input('amount') < env('MIN_DEPOSIT'))
    {
      return back()->With(['toast_msg' => __('messages.amnt_equl').' '.env('MIN_DEPOSIT').' '.$this->st->currency, 'toast_type' => 'err']);
    }

    if(!empty($user))
    {
      $cost = (FLOAT) $req->input('amount');
      $currency_base = 'USD';
      $currency_received = $req['coin'];
      $extra_details = "Maxprofit";

      $transaction = \Coinpayments::createTransactionSimple($cost, $currency_base, $currency_received, $extra_details);
      $transaction = json_decode($transaction);
      if($transaction)
      {      
        $st = site_settings::find(1);
        $paymt = new deposits;
        $paymt->user_id = $user->id;
        $paymt->usn = $user->username;
        $paymt->amount = $cost * $st->currency_conversion;
        $paymt->currency = $st->currency;
        $paymt->account_name = $transaction->txn_id;
        $paymt->account_no = $transaction->address;
        $paymt->bank = $transaction->currency2;
        $paymt->url =  $transaction->status_url;
        $paymt->status = 0;
        $paymt->on_apr = 0;
        $paymt->pop = "";

        $paymt->save();
        
      }
      // return redirect($transaction->status_url);
      return view('user.pay_btc', ['trans' => $transaction]);

      dd($transaction);
    }
    else
    {
      return redirect('/login');
    }
      

  }

  public function btc_confirm(Request $req)
  {
    
    try 
    {
      $ipn = \Coinpayments::validateIPNRequest($req);
      if ($ipn->isApi()) 
      {
        // Payment::find($ipn->txn_id);
        $btc_pay = deposit::where('account_name', $ipn->txn_id)->get();
        if($btc_pay[0]->status == 0)
        {
          $btc_pay[0]->status = 1;
          $btc_pay[0]->on_opr = 1;
          $btc_pay[0]->save();

          $user = User::where('id', $btc_pay->user_id)->get();
          $user[0]->wallet += (FLOAT) $btc_pay->amount;
          $user[0]->save();
        }
        if($btc_pay[0]->status == 1)
        {
          return back()->With([
            'toast_msg' => __('messages.dpst_confr'), 
            'toast_type' => 'err'
          ]);
        }
        return back()->With([
          'toast_msg' => __('messages.dpst_rej'), 
          'toast_type' => 'err'
        ]);


      }
    }
    catch (IpnIncompleteException $e)
    {
      return back()->With([
        'toast_msg' => __('messages.dpst_rej'), 
        'toast_type' => 'err'
      ]);  
    }

  }

  public function bank_deposit(Request $req){
    $user = Auth::User();
    if(!empty($user))
    {
      if($req->input('amt') < env('MIN_DEPOSIT'))
      {
        return back()->With(['toast_msg' => __('messages.amt_mb_grt').' '.env('MIN_DEPOSIT').' '.$this->st->currency, 'toast_type' => 'err']);
      }
      try{
        $st = site_settings::find(1);
        $paymt = new deposits;
        $paymt->user_id = $user->id;
        $paymt->usn = $user->username;
        $paymt->amount = $req->input('amt');
        $paymt->currency = $st->currency;
        $paymt->account_name = $req->input('account_name');
        $paymt->account_no = $req->input('account_no');
        $paymt->bank = __('messages.bnk');
        $paymt->url =  "";
        $paymt->status = 0;
        $paymt->on_apr = 0;
        $paymt->pop = "";

        $paymt->save();

        $maildata = ['email' => $user->email, 'username' => $user->username];

        Mail::send('mail.user_deposit_notification', ['md' => $maildata], function($msg) use ($maildata){
            $msg->from(env('MAIL_USERNAME'), env('APP_NAME'));
            $msg->to($maildata['email']);
            $msg->subject( __('messages.usr_dpt_not'));
        });

        Mail::send('mail.admin_deposit_notification', ['md' => $maildata], function($msg) use ($maildata){
            $msg->from(env('MAIL_USERNAME'), env('APP_NAME'));
            $msg->to(env('SUPPORT_EMAIL'));
            $msg->subject( __('messages.usr_dpt_not'));
        });

        return back()->With(['toast_msg' => __('messages.dpt_sav_bnk').' '.env('BANK_DEPOSIT_EMAIL'), 'toast_type' => 'suc']);
      }
      catch(\Exception $e)
      {
        return back()->With(['toast_msg' => __('messages.err_savn_rec') .' ', 'toast_type' => 'err']);
      }
    }
    else
    {
      return redirect('/login');
    }
  }

  public function view_tickets()
  {
    $user = Auth::User();
    if(!empty($user))
    {
      $tickets = ticket::where('user_id', $user->id)->orderby('status', 'desc')->orderby('updated_at', 'desc')->paginate(10);
      return view('user.ticket', ['tickets' => $tickets]);
    }
    else
    {
      return redirect('/login');
    }
  }
  
  public function create_ticket(Request $req)
  {
    $user = Auth::User();
    if(!empty($user))
    {
      $validator = Validator::make($req->all(), [
        'title' => 'string|max:499',
        'msg' => 'string'
      ]);

      if($validator->fails())
      {
        return back()->With([
          'toast_msg' => __('messages.tckt_err').' '.$validator->errors()->first(),
          'toast_type' => 'err'
        ]);
      }
      try{
        $ticket = new ticket([
          'ticket_id' => $user->id.strtotime(date('Y-m-d H:i:s')),
          'user_id' => $user->id,
          'title' => $req->input('title'),
          'msg' => $req->input('msg'),
          'status' => 1
        ]);
        $ticket->save();

        $maildata = ['email' => $user->email, 'username' => $user->username];

        Mail::send('mail.user_tickect_msg', ['md' => $maildata], function($msg) use ($maildata){
            $msg->from(env('MAIL_USERNAME'), env('APP_NAME'));
            $msg->to(env('SUPPORT_EMAIL'));
            $msg->subject( __('messages.ticket_msg'));
        });

        // $tickets = ticket::find($user->id);
        return back()->With([
          'toast_msg' => __('messages.tckt_succ'),
          'toast_type' => 'suc',
          // 'tickets' => $tickets
        ]);
      }
      catch(\Exception $e)
      {
        return back()->With([
          'toast_msg' => __('messages.tckt_err'),
          'toast_type' => 'err'
        ]);
      }

        
    }
    else
    {
      return redirect('/login');
    }
  }
  public function open_ticket($id)
  {
    $user = Auth::User();
    if(!empty($user))
    {
      $ticket_view = ticket::With('comments')->find($id);
      $comments = comments::where('ticket_id', $id)->orderby('id', 'asc')->get(); 
      comments::where('ticket_id', $id)->where('sender', 'support')->update(['state' => 0]);
      return view('user.ticket_chat', ['ticket_view' => $ticket_view, 'comments' => $comments]);
    }
    else
    {
      return redirect('/login');
    }
  }
  
  public function ticket_chat($id)
  {
    $user = Auth::User();
    if(!empty($user))
    {
      $comments = comments::where('ticket_id', $id)->where('sender', 'support')->where('state', 1)->orderby('id', 'asc')->get();     
      comments::where('ticket_id', $id)->where('sender', 'support')->update(['state' => 0]);
      return json_encode($comments);
    }
    else
    {
      return redirect('/login');
    }
  }

  public function close_ticket($id)
  {
    $user = Auth::User();
    if(!empty($user))
    {
      try 
      {
        ticket::where('id', $id)->update(['status' => 0]);
        return back()->with([
          'toast_msg' => __('messages.tckt_clsd'),
          'toast_type' => 'suc'
        ]);
      } 
      catch (\Exception $e) 
      {
        return back()->with([
          'toast_msg' => __('messages.err_occr'),
          'toast_type' => 'suc'
        ]);
      } 
    }
    else
    {
      return redirect('/login');
    }
  }

  public function ticket_comment(Request $req)
  {
    $user = Auth::User();
    if(!empty($user))
    {
      $close_check = ticket::find($req->input('ticket_id'));
      if(empty($close_check) || $close_check->status == 0)
      {
        return json_encode([
          'toast_msg' => __('messages.tckt_clsd'),
          'toast_type' => 'err'
        ]);
      }

      $validator = Validator::make($req->all(), [
        'ticket_id' => 'required|string',
        'msg' => 'required|string'
      ]);

      if($validator->fails())
      {
        return json_encode([
          'toast_msg' => __('messages.msg_err').' '.$validator->errors()->first(),
          'toast_type' => 'err'
        ]);
      }

      try
      {        
        $comment = new comments([
          'ticket_id' =>$req->input('ticket_id'),
          'sender' => 'user',
          'sender_id' => $user->id,       
          'message' => $req->input('msg'), 
        ]);
        $comment->save();

        $maildata = ['email' => $user->email, 'username' => $user->username];

        Mail::send('mail.user_tickect_msg', ['md' => $maildata], function($msg) use ($maildata){
            $msg->from(env('MAIL_USERNAME'), env('APP_NAME'));
            $msg->to(env('SUPPORT_EMAIL'));
            $msg->subject( __('messages.ticket_msg'));
        });
        
        return json_encode([
          'toast_msg' => 'Successful! ',
          'toast_type' => 'suc',          
          'comment_msg' => $req->input('msg'),
          'comment_time' => date('Y-m-d H:i:s'),
          'user_img' => $user->img
        ]);
      }
      catch(\Exception $e)
      {        
        return json_encode([
          'toast_msg' => __('messages.msg_err'),
          'toast_type' => 'err'
        ]);
      }
    }
    else
    {
      return redirect('/login');
    }
  }

  public function pm_page(Request $req){    
    $user = Auth::User();
    if(!empty($user))
    {
      return view('user.pay_pm_amt');
    }
    else
    {
      return redirect('/login');
    }
    
  }

  public function pm_post(Request $req)
  {
    $user = Auth::User();
    if(!empty($user))
    {

      return view('user.pm_proceed')->with(['pm_amount' => $req['amount'], 'tnx_id' => $user->id.strtotime('Y-m-d H:s:i')] );
    }
    else
    {
      return redirect('/login');
    }
    
  }
  
  public function pm_success(Request $req)
  {
    $user = Auth::User();
    $st = site_settings::find(1);
    // $user = User::where('email', $paymentDetails['data']['customer']['email'])->get();
    $paymt = new deposits;
    $paymt->user_id = $user->id;
    $paymt->usn = $user->username;
    $paymt->amount = floatval($req['PAYMENT_AMOUNT'] * env('CONVERSION'));
    $paymt->currency = env('CURRENCY');
    $paymt->account_name = $user->username;
    $paymt->account_no = $req['PAYER_ACCOUNT'];
    $paymt->bank = 'PM';
    $paymt->status = 1;
    $paymt->on_apr = 1;
    $paymt->pop = $req['PAYER_ACCOUNT'];

    $paymt->save();
    
    $user->wallet += floatval($req['PAYMENT_AMOUNT'] * env('CONVERSION'));
    $user->save();

    $maildata = ['email' => $user->email, 'username' => $user->username];

    Mail::send('mail.user_deposit_notification', ['md' => $maildata], function($msg) use ($maildata){
        $msg->from(env('MAIL_USERNAME'), env('APP_NAME'));
        $msg->to($maildata['email']);
        $msg->subject( __('messages.usr_dpt_not'));
    });

    Mail::send('mail.admin_deposit_notification', ['md' => $maildata], function($msg) use ($maildata){
        $msg->from(env('MAIL_USERNAME'), env('APP_NAME'));
        $msg->to(env('SUPPORT_EMAIL'));
        $msg->subject( __('messages.usr_dpt_not'));
    });
    
    return redirect()->route('pm.index')->with([
      'toast_msg' => __('messages.dpst_succ'),
      'toast_type' => 'suc'
    ]);

  }

  public function pm_cancel(Request $req)
  {
    return redirect()->route('pm.index')->with([
      'toast_msg' => __('messages.err_cncl'),
      'toast_type' => 'err'
    ]);
  }

  public function set_2fa($opr)
  {
    $user = Auth::User();
    
    if($opr == 'enable')
    {
      if($user->sec_2fa_status == 1)
      {
        $data_2fa = ['msg' => 'exist'];
        return json_encode($data_2fa);
      }
      $google2fa = app('pragmarx.google2fa');
      $secret_2fa = $google2fa->generateSecretKey();
      $QR_Image = $google2fa->getQRCodeInline(
          config('app.name'),
          $user->email,
          $secret_2fa
      );
      $data_2fa = ['QR_Image' => $QR_Image, 'secret' => $secret_2fa, 'msg' => 'suc'];
      return json_encode($data_2fa);
    }
    elseif($opr == 'disable')
    {
      if($user->sec_2fa_status != 1)
      {
        $data_2fa = ['msg' => 'disable'];
        return json_encode($data_2fa);
      }

      $data_2fa = ['secret' => $user->sec_2fa, 'msg' => 'disable_2fa'];
      return json_encode($data_2fa);
    }

  }

  public function verify_2fa(Request $req)
  {
    $user = Auth::User();
    try
    {   
      if(Google2FA::verifyGoogle2FA($req['seccode'], $req['fa_code']))
      {
        $user->sec_2fa = $req['seccode'];
        $user->sec_2fa_status = 1;
        $user->save();

        return redirect()->back()->with([
          'toast_msg' => __('messages.fact_actvtd'),
          'toast_type' => 'suc'
        ]);

      }
      else
      {
        return back()->with([
          'toast_msg' => __('messages.incrrt'),
          'toast_type' => 'err'
        ]);
      }
    }
    catch(\Exception $e)
    {
      return redirect()->back()->with([
        'toast_msg' => __('messages.err_act_2fa'),
        'toast_type' => 'err'
      ]);
    }

  }
  
  public function disable_2fa(Request $req)
  {
    $user = Auth::User();
    try
    {   
      if(Google2FA::verifyGoogle2FA($user->sec_2fa, $req['fa_otp']))
      {
        $user->sec_2fa = '';
        $user->sec_2fa_status = 0;
        $user->save();

        return redirect()->back()->with([
          'toast_msg' => __('messages.fact_dactvtd'),
          'toast_type' => 'suc'
        ]);

      }
      else
      {
        return back()->with([
          'toast_msg' => __('messages.incrrt'),
          'toast_type' => 'err'
        ]);
      }
    }
    catch(\Exception $e)
    {
      return redirect()->back()->with([
        'toast_msg' => __('messages.err_deact_2fa'),
        'toast_type' => 'err'
      ]);
    }

  }

  public function upload_kyc_doc(Request $req)
  {
    $user = Auth::User();
    try
    {
      if($req['cardtype'] == 'idcard_op' || $req['cardtype'] == 'driver_op' )
      {
        if($req->hasFile('id_front') && $req->hasFile('id_back'))
        {
          $file = $req->file('selfie');        
          $file->move(base_path().'/../img/kyc/', $user->username."_selfie.jpg");
          $file = $req->file('id_front');        
          $file->move(base_path().'/../img/kyc/', $user->username."_id_front.jpg");
          $file = $req->file('id_back');        
          $file->move(base_path().'/../img/kyc/', $user->username."_id_back.jpg");
          $file = $req->file('utility_doc');        
          $file->move(base_path().'/../img/kyc/', $user->username."_utility_doc.jpg");

          $kyc = new kyc;
          $kyc->user_id = $user->id;
          $kyc->username = $user->username;
          $kyc->card_type = $req['cardtype'];
          $kyc->selfie = $user->username."_selfie.jpg";
          $kyc->front_card = $user->username."_id_front.jpg";
          $kyc->back_card = $user->username."_id_back.jpg";
          $kyc->address_proof = $user->username."_utility_doc.jpg";

          $kyc->save();

          $maildata = ['email' => $user->email, 'username' => $user->username];
          Mail::send('mail.admin_kyc_not', ['md' => $maildata], function($msg) use ($maildata){
              $msg->from(env('MAIL_USERNAME'), env('APP_NAME'));
              $msg->to(env('SUPPORT_EMAIL'));
              $msg->subject( __('messages.knw_yr_cust') );
          });

          return redirect()->back()->with([
            'toast_msg' => __('messages.fil_succ'),
            'toast_type' => 'suc'
          ]);
        }
        else
        {
          return redirect()->back()->with([
            'toast_msg' => __('messages.nt_subm'),
            'toast_type' => 'err'
          ]);
        }
      }
      elseif ($req['cardtype'] == 'passport_op') 
      {
        if($req->hasFile('pas_id_front'))
        { 
          $file = $req->file('selfie');        
          $file->move(base_path().'/../img/kyc/', $user->username."_selfie.jpg");
          $file = $req->file('pas_id_front'); 
          $file->move(base_path().'/../img/kyc/', $user->username."_pas_id_front.jpg");
          $file = $req->file('utility_doc');        
          $file->move(base_path().'/../img/kyc/', $user->username."_utility_doc.jpg");

          $kyc = new kyc;
          $kyc->user_id = $user->id;
          $kyc->username = $user->username;
          $kyc->selfie = $user->username."_selfie.jpg";
          $kyc->card_type = $req['cardtype'];
          $kyc->front_card = $user->username."_id_front.jpg";        
          $kyc->address_proof = $user->username."_utility_doc.jpg";

          $kyc->save();
          $maildata = ['email' => $user->email, 'username' => $user->username];
          Mail::send('mail.admin_kyc_not', ['md' => $maildata], function($msg) use ($maildata){
              $msg->from(env('MAIL_USERNAME'), env('APP_NAME'));
              $msg->to(env('SUPPORT_EMAIL'));
              $msg->subject('Know Your Customer');
          });

          return redirect()->back()->with([
            'toast_msg' => __('messages.fil_succ'),
            'toast_type' => 'suc'
          ]);
        }
        else
        {
          return redirect()->back()->with([
            'toast_msg' => __('messages.nt_subm'),
            'toast_type' => 'err'
          ]);
        }
      }
      else
      {
        return redirect()->back()->with([
            'toast_msg' => __('messages.slct_doc'),
            'toast_type' => 'err'
          ]);
      }
    }
    catch(\Exception $e)
    {
      return redirect()->back()->with([
        'toast_msg' => $e->getMessage(),
        'toast_type' => 'err'
      ]);
    }
  }
  
  public function enter_otp()
  {
    $user = Auth::User();
    return view('user.enter_otp');
  }

  // coded added 11/08/2020 ////////////////////////////////////////////////

  public function pay_with_coinbase_btc(){    
    $user = Auth::User();
    if(!empty($user))
    {
      return view('user.pay_coinbase_amt');
    }
    else
    {
      return redirect('/login');
    }
    
  }

  public function pay_btc_coinbase_amt(Request $req){
    
    $user = Auth::User();
    if($req->input('amount') < env('MIN_DEPOSIT'))
    {
      return back()->With(['toast_msg' => __('messages.amt_mb_grt').' '.env('MIN_DEPOSIT').' '.$this->st->currency, 'toast_type' => 'err']);
    }

    if(!empty($user))
    {
      try
      {
        ApiClient::init(env('COINBASE_API_KEY'));
        $chargeData = [
            'name' => $user->username,
            'description' => env('APP_NAME').' user deposit',
            'local_price' => [
                'amount' => $req->input('amount'),
                'currency' => 'USD'
            ],
            'pricing_type' => 'fixed_price'
        ];
        $details = Charge::create($chargeData);

        $st = site_settings::find(1);
        $paymt = new deposits;
        $paymt->user_id = $user->id;
        $paymt->usn = $user->username;
        $paymt->amount = $req->input('amount') * env('CONVERSION');
        $paymt->currency = env('CURRENCY');
        $paymt->account_name = 'Coin Base';
        $paymt->account_no = $details['addresses']['bitcoin'];
        $paymt->bank = "BTC";
        $paymt->url =  $details['hosted_url'];
        $paymt->status = 0;
        $paymt->on_apr = 0;
        $paymt->pop = $details['id'];

        $paymt->save();

        // dd($details);

        return redirect()->away($details->hosted_url);

        // return back()->With(['coinbase_charge' => $details]);
      }
      catch(\Exception $e)
      {
        return back()->With(['toast_msg' => __('messages.err_occr').' '.$e->getMessage(), 'toast_type' => 'err']);
      }
      
    }
    else
    {
      return redirect('/login');
    }
      

  }

  public function coinbase_btc_confirm($id)
  {
    $user = Auth::User();
    if(empty($user))
    {
      return redirect('/login');
    }
    ApiClient::init(env('COINBASE_API_KEY'));
    $chargeObj = Charge::retrieve($id);
    $status_array = $chargeObj['timeline'];
    $cnt = '';
    foreach($status_array as $status)
    {
      if($status['status'] == "COMPLETED")
      {
        try
        {
          $btc_pay = deposit::where('pop', $id)->where('status', 0)->get();
          if(count($btc_pay) > 0)
          {
            if($btc_pay[0]->status == 0)
            {
              $btc_pay[0]->status = 1;
              $btc_pay[0]->on_opr = 1;

              $user = User::where('id', $btc_pay->user_id)->get();
              $user->wallet += (FLOAT) $btc_pay->amount;
              $btc_pay[0]->save();
              $user->save();

              return back()->With([
                'toast_msg' => __('messages.dpt_confm_suc'), 
                'toast_type' => 'suc'
              ]);
            }
            if($btc_pay[0]->status == 1)
            {
              return back()->With([
                'toast_msg' => __('messages.dpst_confr'), 
                'toast_type' => 'err'
              ]);
            }

            return back()->With([
              'toast_msg' => __('messages.dpst_rej'), 
              'toast_type' => 'err'
            ]);
          }
          else
          {
            return back()->With([
              'toast_msg' => __('messages.dpst_rcrd'), 
              'toast_type' => 'err'
            ]);
          }
        }
        catch(\Exception $e)
        {
          return back()->With([
            'toast_msg' => __('messages.err_occr').' '.$e->getMessage(), 
            'toast_type' => 'err'
          ]);
        }    
      }
      else
      {
        $cnt = $status['status'];
      }
    }
    return back()->With([
      'toast_msg' => __('messages.sts').': '.$cnt, 
      'toast_type' => 'err'
    ]);
  }

  public function coinbase_cron_btc_deposit()
  {
    ApiClient::init(env('COINBASE_API_KEY'));
    $jobs = deposit::where('bank', 'BTC')->where('status', 0)->get();
    foreach($jobs as $job)
    {
      $chargeObj = Charge::retrieve($job->pop);
      $status_array = $chargeObj['timeline'];
      foreach($status_array as $status)
      {
        // echo $status['status'];
        if($status['status'] == "COMPLETED")
        {
          try
          {
            $btc_pay = deposit::where('pop', $job->pop)->where('status', 0)->get();
            if(!empty($btc_pay))
            {
              $btc_pay->status = 1;
              $btc_pay->on_opr = 1;

              $user = User::where('id', $btc_pay->user_id)->get();
              $user->wallet += (FLOAT) $btc_pay->amount;
              $btc_pay->save();
              $user->save();
            }
            else
            {
              
            }
          }
          catch(\Exception $e)
          {
            
          }    
        }
      }
    }
  }

  public function pay_with_bcm_btc(Request $req)
  {    
    try
    {         
      if(!empty(Auth::User()))
      { 
        return view('user.bcm_amt');
      }
      else
      {
        return redirect()->route('login');
      }      
    }
    catch(\Exception $e)
    {
      return back()->with([
          'toast_msg' => $e->getMessage(),
          'toast_type' => 'err'
      ]);
    }

    
  }

  public function pay_bcm_amt(Request $req)
  {   
    try 
    {
      if(!empty(Auth::User()))
      { 
        $user = Auth::User();

        ////////////////////////////// Blockchain api ////////////////////////////////////////////////

        $invoice_id = strtotime(date('Y-m-d')); //'ZzsMLGKe162CfA5EcG6j';

        $bc_secrete = env('BCM_SECRETE');
        $my_xpub = env('BC_MY_XPUB'); 
        $my_api_key = env('BC_MY_API_KEY');
        $my_callback_url = url('/').'/bcm/cb?invoice_id='.$invoice_id.'&secret='.$bc_secrete;
        $root_url = 'https://api.blockchain.info/v2/receive';
        $parameters = 'xpub=' .$my_xpub. '&callback=' .urlencode($my_callback_url). '&key=' .$my_api_key;
        $response = file_get_contents($root_url . '?' . $parameters);
        $object = json_decode($response);
        // echo 'Send Payment To : ' . $object->address;

        ///////////////////////////////////  Get BTC price ///////////////////////////////////////

        $bcm_amt = ($req['amount'] * env('CONVERSION')); 
        $price_btc = file_get_contents("https://www.blockchain.com/tobtc?currency=USD&value=" . $bcm_amt); 
        

        $paymt = new deposits;
        $paymt->user_id = $user->id;
        $paymt->invoice = $invoice_id; 
        $paymt->usn = $user->username;
        $paymt->amount = $price_btc;
        $paymt->currency = env('CURRENCY');
        $paymt->account_name = 'BCM';
        $paymt->account_no = $object->address;
        $paymt->bank = "BTC";
        $paymt->url =  '';
        $paymt->status = 0;
        $paymt->on_apr = 0;
        $paymt->pop = '';

        $paymt->save();      

        return view('user/bcm_amt')->with([
            'bcm_amt' => $price_btc,
            'bcm_addr' => $object->address
        ]);
       
      }
      else
      {
        return redirect()->route('login');
      } 
        
    } 
    catch (Exception $e) 
    {
      return back()->with([
          'toast_msg' => $e->getMessage(),
          'toast_type' => 'err'
      ]);
    }   
  }

  public function bcm_btc_cb(Request $req)
  {
    // dd($req);
    // $address = $req->addr;
    // $status = $req->status;

    ////////////////// Blockchain Callback ////////////////////////////
    $invoice_id = $req['invoice_id'];
    $transaction_hash = $req['transaction_hash'];
    $value_btc = $req['value'] / 100000000;
    $conf = $req['confirmations']; 

    $response = file_get_contents("https://blockchain.info/ticker");
    $object = json_decode($response);
    $C_price = $object->USD->last;
    
    $dep = deposits::where('invoice', $invoice_id)->get();
    if($conf >= 4 && $dep->status = 0 )
    {
      $user = User::find($dep->user_id);
      $user->wallet += ($value_btc*$C_price) / (float)env('CONVERSION');
      $dep->status = 1;
      $dep->on_apr = 1;
    }

    $dep->save();   
    
    // $dep = deposits::where('account_no', $re)
    
  }

  public function payment_receive(Request $req)
  {
    dd($req);
    // $address = $req->addr;
    // $status = $req->status;

    // $client =  new GuzzleClient();
    // $response = $client->get('https://www.blockonomics.co/api/merchant_order/'.$address,[
    //     'headers'=>['Authorization'=> 'Bearer '.env('Blockonomics_API','')],
    // ]);
    // $data = json_decode($response->getBody());
    // $data_string =json_encode($data);

    // $mail = $data->data->emailid;
    // $user = User::where('email','=',$mail)->first();

    // $dep = deposits::where('user_id', $user[0]->id)->where('account_no', $address)->get();
    // $dep->status = $status;
    // $dep->on_apr = 1;

    // $dep->save();   
    
    // $dep = deposits::where('account_no', $re)
    
  }

}