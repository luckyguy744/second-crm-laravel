<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
// use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

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
use App\kyc;
use App\lang;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        // Using Closure based composers...
        
        View::composer('*', function ($view) {   
                 
            $user = Auth::User();
            $adm = Session::get('adm');
            $settings = site_settings::find(1);
            $lang = lang::all();

            if(Route::currentRouteName() != 'homelogin')
            {
                homeLogin();
            }
            
            if(!empty($user))
            {
                Session::forget('adm');
                $adm = null;
                
                $myInv = investment::where('user_id', $user->id)->orderby('id', 'asc')->get();
                $actInv = investment::where('user_id', $user->id)->where('status', 'Active')->orderby('id', 'desc')->paginate(10);
                $refs = User::where('referal', $user->username)->orderby('id', 'desc')->get();
                $wd = withdrawal::where('user_id', $user->id)->orderby('id', 'asc')->get();
                $logs = activities::where('user_id', $user->id)->orderby('id', 'desc')->take(20)->paginate(5);
                $mybanks = banks::where('user_id', $user->id)->where('Account_name', '!=', 'BTC')->orderby('id', 'desc')->get();
                $my_wallets = banks::where('user_id', $user->id)->where('Account_name', 'BTC')->orderby('id', 'desc')->get();
                // $settings = site_settings::find(1); 
                $kyc = kyc::where('user_id', $user->id)->get();               
                $view->with([
                    'user' => $user, 
                    'myInv' => $myInv, 
                    'actInv' => $actInv, 
                    'refs' => $refs, 
                    'wd' => $wd, 
                    'logs' => $logs, 
                    'mybanks' => $mybanks, 
                    'my_wallets' => $my_wallets, 
                    'settings' => $settings, 
                    'lang' => $lang,
                    'kyc' => $kyc
                ]); 

            }
            elseif (!empty($adm))
            {
                Session::put('adm', $adm);
                $user = null;
                
                $inv = investment::orderby('id', 'desc')->get();
                $deposits = deposits::orderby('id', 'desc')->get();
                $users = User::orderby('id', 'desc')->get();
                $wd = withdrawal::orderby('id', 'desc')->paginate(20);
                $today_wd = withdrawal::where('created_at','like','%'.date('Y-m-d').'%')->orderby('id', 'desc')->get();
                $today_dep = deposits::where('created_at','like','%'.date('Y-m-d').'%')->orderby('id', 'desc')->get();
                $today_inv = investment::where('date_invested', date('Y-m-d'))->orderby('id', 'desc')->get();
                $cap = $cap2 = $dep = $dep2 = $wd_bal = $sum_cap = 0; 
                $logs =  adminLog::orderby('id', 'desc')->take(5)->get();
                $kyc = kyc::paginate(20); 

                $view->with([
                    'inv' => $inv, 
                    'deposits' => $deposits, 
                    'users' => $users, 
                    'wd' => $wd, 
                    'today_wd' => $today_wd, 
                    'today_dep' => $today_dep, 
                    'today_inv' => $today_inv, 
                    'settings' => $settings,
                    'logs' => $logs,
                    'cap' => $cap,
                    'cap2' => $cap2,
                    'dep' => $dep,
                    'dep2' => $dep2,
                    'wd_bal' => $wd_bal,
                    'sum_cap' => $sum_cap,
                    'adm' => Session::get('adm'),
                    'lang' => $lang,
                    'kyc' => $kyc
                ]); 
                
            }
            elseif(empty($user) && empty($adm))
            {
                $view->with([
                    'settings' => $settings,
                    'lang' => $lang,                       
                ]); 
            }
            else
            {
                $view->with([
                    'settings' => $settings,
                    'lang' => $lang,                     
                ]); 
            }
            
        });
    }
}
