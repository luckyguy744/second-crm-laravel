<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;

use Auth;
use App\activities;
use Session;
use User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/user/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function redirectTo()
    {
        $user = Auth::User();

        $act = new activities;
        $act->action = "User logged in to account";
        $act->user_id = $user->id;
        $act->save();

        

        if($user->status == 0 || $user->status == 'New' || $user->status == 'pending')
        {
            Session::flush();
            Session::put('err_msg', 'Account not activated');
            return '/login'; //->withErrors(['msg', 'Account not activated']);             
        }
        if($user->status == 2 || $user->status == 'Blocked')
        {
            Session::flush();
            Session::put('err_msg', 'Account Blocked! Please contact support.');
            return '/login'; //->withErrors(['msg', 'Account not activated']);             
        }
        
        try
        {

            $maildata = ['email' => $user->email, 'username' => $user->username];
            Mail::send('mail.loginNotification', ['md' => $maildata], function($msg) use ($maildata){
                $msg->from(env('MAIL_USERNAME'), $this->st->site_title);
                $msg->to($maildata['email']);
                $msg->subject('User Account login');
            });
        }
        catch(\Exception $e)
        {
            
        }

        // $user = Auth::User();
        // if($user->sec_2fa_status == 1)
        // {
        //     return redirect()->route('user.login2fa');
        // }

        return '/'.$user->username.'/dashboard';
    
    }


}
