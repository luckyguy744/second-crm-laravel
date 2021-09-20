<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
// use Illuminate\Support\Facades\File;

use DotenvEditor;

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
use App\ref_set;
use App\ticket;
use App\comments;
use App\lang;

class adminController extends Controller
{
    private $data_files = [];
    private $settings;
    // private  $locale=App::getLocale();

    public function __construct()
    {
        // parent::__construct();
        $this->settings = site_settings::find(1);
    }

    public function load_data()
    {
        $adm = Session::get('adm');
        $inv = investment::orderby('id', 'desc')->get();
        $deposits = deposits::orderby('id', 'desc')->get();
        $users = User::orderby('id', 'desc')->get();
        $wd = withdrawal::orderby('id', 'desc')->get();
        $today_wd = withdrawal::where('created_at', 'like', '%' . date('Y-m-d') . '%')->orderby('id', 'desc')->get();
        $today_dep = deposits::where('created_at', 'like', '%' . date('Y-m-d') . '%')->orderby('id', 'desc')->get();
        $today_inv = investment::where('date_invested', date('Y-m-d'))->orderby('id', 'desc')->get();
        $logs =  adminLog::orderby('id', 'desc')->get();
        $settings = site_settings::find(1);
        $this->data_files = [$adm, $inv, $deposits, $users, $wd, $today_wd, $today_dep, $today_inv, $logs, $settings];
        return $this->data_files;
    }
    public function index()
    {
        //return view('user.');
    }
    public function backLogin()
    {
        return view('admin.login', ['settings' => $this->settings]);
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

    public function adm_login(Request $req)
    {
        $adm = admin::where('email', $req->input('email'))->get();
        if (count($adm) > 0) {
            if ($adm[0]->status == 0) {
                Session::put('err2', __('messages.act_nt_actvtd'));
                return back();
            }
            if (Hash::check($req->input('password'), $adm[0]->pwd)) {
                $adm = admin::find($adm[0]->id);
                Session::put('adm', $adm);
                Auth::logout();
                $act = new adminLog;
                $act->admin = $adm->email;
                $act->action = __('messages.logd_syst');
                $act->save();

                return redirect()->route('adm_dash');
                // return 's';
            } else {
                Session::put('err2', __('messages.logn_ncrrt'));
                return back();
            }
        } else {
            Session::put('err2', __('messages.logn_usn_crrt'));
            return back();
        }
    }


    public function getMonthlyIvCart()
    {
        $cap = 0;
        $nm;
        $sm = array();
        for ($i = 1; $i <= 12; $i++) {
            $cap = 0;
            if (strlen($i) == 1) {
                $nm = '0' . $i;
            } else {
                $nm = $i;
            }
            $mIvs = investment::where('date_invested', 'like', '%' . date('Y') . '-' . $nm . '%')->get();
            if (count($mIvs) > 0) {
                foreach ($mIvs as $m) {
                    $cap = $cap + intval($m->capital);
                }
            } else {
                $cap = 0;
            }

            array_push($sm, intval($cap));
        }

        return json_encode($sm);
    }

    public function updateUserProfile(Request $req)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {

            $adm = Session::get('adm');

            try {
                $validate = $req->validate([
                    'phone' => 'required|digits_between:10,15',
                ]);

                //$country = country::find($req->input('country'))
                $usr = User::find($req->input('uid'));
                $usr->country = $req->input('country');
                $usr->state = $req->input('state');
                $usr->address = $req->input('adr');
                $usr->phone = $req->input('cCode') . $req->input('phone');
                $usr->currency = $this->settings->currency;


                $usr->save();

                $act = new adminLog;
                $act->admin = $adm->email;
                $act->action = __('messages.updt_usr_prfl') . $req->input('uid');
                $act->save();

                Session::put('status', __('messages.suc_msg'));
                Session::put('msgType', "suc");
                return back();
            } catch (\Exception $e) {
                Session::put('status', __('messages.err_sav_dat'));
                Session::put('msgType', "err");
                return back();
            }
        } else {
            return redirect('/');
        }
    }

    public function changeUserPwd(Request $req)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {

            if ($req->input('newpwd') != $req->input('cpwd')) {
                Session::put('status', __('messages.pwd_dnt_mtch'));
                Session::put('msgType', "err");
                return back();
            }

            try {
                $usr = User::find($req->input('uid'));

                $usr->pwd = Hash::make($req->input('newpwd'));
                $usr->save();

                $adm = Session::get('adm');
                $act = new adminLog;
                $act->admin = $adm->email;
                $act->action =  __('messages.chng_usr_pwd') . $req->input('uid');
                $act->save();

                Session::put('status', __('messages.suc_msg'));
                Session::put('msgType', "suc");
                return back();
            } catch (\Exception $e) {
                Session::put('status',  __('messages.err_savn_pwd'));
                Session::put('msgType', "err");
                return back();
            }
        } else {
            return redirect('/');
        }
    }


    public function blockUser($id)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {

            try {
                $usr = User::find($id);
                $usr->status = 2;
                $usr->save();

                $adm = Session::get('adm');
                $act = new adminLog;
                $act->admin = $adm->email;
                $act->action = __('messages.blckd_usr_act') . $id;
                $act->save();

                Session::put('status', __('messages.suc_msg'));
                Session::put('msgType', "suc");
                return back();
            } catch (\Exception $e) {
                Session::put('status', __('messages.err_updt_rec'));
                Session::put('msgType', "err");
                return back();
            }
        } else {
            return redirect('/');
        }
    }

    public function activateUser($id)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {

            try {
                $usr = User::find($id);
                $usr->status = 1;
                $usr->save();

                $adm = Session::get('adm');
                $act = new adminLog;
                $act->admin = $adm->email;
                $act->action = __('messages.actvt_usr_act') . $id;
                $act->save();

                Session::put('status', __('messages.suc_msg'));
                Session::put('msgType', "suc");
                return back();
            } catch (\Exception $e) {
                Session::put('status', __('messages.err_updt_rec'));
                Session::put('msgType', "err");
                return back();
            }
        } else {
            return redirect('/');
        }
    }

    public function deleteUser($id)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {

            try {
                $usr = User::where('id', $id)->delete();

                $adm = Session::get('adm');
                $act = new adminLog;
                $act->admin = $adm->email;
                $act->action = "Delete User account. User_id: " . $id;
                $act->save();

                Session::put('status', __('messages.suc_msg'));
                Session::put('msgType', "suc");
                return redirect('/admin/manage/users'); //

            } catch (\Exception $e) {
                Session::put('status', __('messages.err_updt_rec'));
                Session::put('msgType', "err");
                return back();
            }
        } else {
            return redirect('/');
        }
    }


    public function searchInv(Request $req)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {
            Session::put('val', $req->input('search_val'));
            return back();
        } else {
            return redirect('/');
        }
    }

    public function searchXInv(Request $req)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {
            Session::put('val', $req->input('search_val'));
            return back();
        } else {
            return redirect('/');
        }
    }


    public function pauseInv($id)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {

            try {
                $usr = investment::find($id);
                $usr->status = 'Paused';
                $usr->save();

                $adm = Session::get('adm');
                $act = new adminLog;
                $act->admin = $adm->email;
                $act->action = __('messages.paus_usr_Invstm') . $id;
                $act->save();

                Session::put('status', __('messages.suc_msg'));
                Session::put('msgType', "suc");
                return back(); //

            } catch (\Exception $e) {
                Session::put('status', __('messages.err_updt_rec'));
                Session::put('msgType', "err");
                return back();
            }
        } else {
            return redirect('/');
        }
    }

    public function activateInv($id)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {

            try {
                $usr = investment::find($id);
                $usr->status = 'Active';
                $usr->save();

                $adm = Session::get('adm');
                $act = new adminLog;
                $act->admin = $adm->email;
                $act->action = __('messages.actvt_usr_invstm') . $id;
                $act->save();

                Session::put('status', __('messages.suc_msg'));
                Session::put('msgType', "suc");
                return back(); //

            } catch (\Exception $e) {
                Session::put('status', __('messages.err_updt_rec'));
                Session::put('msgType', "err");
                return back();
            }
        } else {
            return redirect('/');
        }
    }

    public function deleteInv($id)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {

            try {
                $inv = investment::find($id);

                $inv_user = User::find($inv->user_id);
                $amt = $inv->capital;

                if ($inv->w_amt == 0) {
                    $inv_user->wallet += $amt;
                    $inv_user->save();
                }

                investment::where('id', $id)->delete();

                $adm = Session::get('adm');
                $act = new adminLog;
                $act->admin = $adm->email;
                $act->action = __('messages.del_u_ivt') . $id;
                $act->save();

                Session::put('status', __('messages.suc_msg'));
                Session::put('msgType', "suc");
                return back();
            } catch (\Exception $e) {
                Session::put('status', __('messages.err_updt_rec'));
                Session::put('msgType', "err");
                return back();
            }
        } else {
            return redirect('/');
        }
    }

    public function xpauseInv($id)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {

            try {
                $usr = xpack_inv::find($id);
                $usr->status = 'Paused';
                $usr->save();

                $adm = Session::get('adm');
                $act = new adminLog;
                $act->admin = $adm->email;
                $act->action = __('messages.paus_usr_Invstm') . $id;
                $act->save();

                Session::put('status', __('messages.suc_msg'));
                Session::put('msgType', "suc");
                return back(); //

            } catch (\Exception $e) {
                Session::put('status', __('messages.err_updt_rec'));
                Session::put('msgType', "err");
                return back();
            }
        } else {
            return redirect('/');
        }
    }

    public function xactivateInv($id)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {

            try {
                $usr = xpack_inv::find($id);
                $usr->status = 'Active';
                $usr->save();

                $adm = Session::get('adm');
                $act = new adminLog;
                $act->admin = $adm->email;
                $act->action = __('messages.actvt_usr_invstm') . $id;
                $act->save();

                Session::put('status', __('messages.suc_msg'));
                Session::put('msgType', "suc");
                return back(); //

            } catch (\Exception $e) {
                Session::put('status', __('messages.err_updt_rec'));
                Session::put('msgType', "err");
                return back();
            }
        } else {
            return redirect('/');
        }
    }

    public function xdeleteInv($id)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {

            try {
                $inv = xpack_inv::find($id);

                $inv_user = User::find($inv->user_id);
                $amt = $inv->capital;

                if ($inv->w_amt == 0) {
                    $inv_user->wallet += $amt;
                    $inv_user->save();
                }

                xpack_inv::where('id', $id)->delete();

                $adm = Session::get('adm');
                $act = new adminLog;
                $act->admin = $adm->email;
                $act->action = __('messages.del_u_ivt') . $id;
                $act->save();

                Session::put('status', __('messages.suc_msg'));
                Session::put('msgType', "suc");
                return back();
            } catch (\Exception $e) {
                Session::put('status', __('messages.err_updt_rec'));
                Session::put('msgType', "err");
                return back();
            }
        } else {
            return redirect('/');
        }
    }

    public function searchDep(Request $req)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {
            Session::put('val', $req->input('search_val'));
            return back();
        } else {
            return redirect('/');
        }
    }

    public function searchWD(Request $req)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {
            Session::put('val', $req->input('search_val'));
            return back();
        } else {
            return redirect('/');
        }
    }


    public function searchadminUser(Request $req)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {
            Session::put('val', $req->input('search_val'));
            return back();
        } else {
            return redirect('/');
        }
    }



    public function admSearch(Request $req)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {
            Session::put('val', $req->input('search_val'));
            return back();
        } else {
            return redirect('/');
        }
    }


    public function rejectDep($id)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {

            try {
                $usr = deposits::find($id);

                $dep_user = User::find($usr->user_id);
                $amt = $usr->amount;

                if ($usr->on_apr == 1) {
                    $dep_user->wallet -= $amt;
                    $dep_user->save();
                }

                $usr->on_apr = 0;
                $usr->status = 2;
                $usr->save();

                $adm = Session::get('adm');
                $act = new adminLog;
                $act->admin = $adm->email;
                $act->action = __('messages.rej_usr_dpst') . $id;
                $act->save();

                Session::put('status', __('messages.suc_msg'));
                Session::put('msgType', "suc");
                return back(); //

            } catch (\Exception $e) {
                Session::put('status', __('messages.err_updt_rec'));
                Session::put('msgType', "err");
                return back();
            }
        } else {
            return redirect('/');
        }
    }

    public function approveDep($id)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {

            try {
                $usr = deposits::find($id);
                if ($usr->status == 1) {
                    return back()->with([
                        'toast_msg' => __('messages.dpst_apprv'),
                        'toast_type' => 'err'
                    ]);
                }

                $dep_user = User::find($usr->user_id);
                $amt = $usr->amount;

                if ($usr->on_apr == 0) {
                    $dep_user->wallet += $amt;
                    $dep_user->save();
                }
                $usr->status = 1;
                $usr->on_apr = 1;
                $usr->save();

                $adm = Session::get('adm');
                $act = new adminLog;
                $act->admin = $adm->email;
                $act->action = __('messages.apprv_usr_dpst') . $id;
                $act->save();

                return back()->with([
                    'toast_msg' => __('messages.dpst_succfly'),
                    'toast_type' => 'suc'
                ]);
            } catch (\Exception $e) {
                return back()->with([
                    'toast_msg' => __('messages.err_updt_rec'),
                    'toast_type' => 'err'
                ]);
                return back();
            }
        } else {
            return redirect('/');
        }
    }

    public function deleteDep($id)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {

            try {

                $usr = deposits::find($id);

                $dep_user = User::find($usr->user_id);
                $amt = $usr->amount;

                if ($usr->on_apr == 1) {
                    $dep_user->wallet -= $amt;
                    $dep_user->save();
                }

                deposits::where('id', $id)->delete();


                $adm = Session::get('adm');
                $act = new adminLog;
                $act->admin = $adm->email;
                $act->action = __('messages.del') . ' ' . $dep_user->username . __('messages.del_amt_log') . ' ' . $amt;
                $act->save();

                Session::put('status', __('messages.suc_msg'));
                Session::put('msgType', "suc");
                return back();
            } catch (\Exception $e) {
                Session::put('status', __('messages.err_del_rec'));
                Session::put('msgType', "err");
                return back();
            }
        } else {
            return redirect('/');
        }
    }

    public function rejectWD($id)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {

            try {
                $usr = withdrawal::find($id);

                if ($usr->status == 'Rejected') {
                    return back()->with([
                        'toast_msg' => __('messages.wthdrwl_rej'),
                        'toast_type' => 'err'
                    ]);
                }

                $usr->status = 'Rejected';

                $user = User::find($usr->user_id);
                $user->wallet += $usr->amount;
                $user->save();

                $usr->save();

                $adm = Session::get('adm');
                $act = new adminLog;
                $act->admin = $adm->email;
                $act->action = __('messages.rej_usr_wthdrwl') . $id;
                $act->save();

                return back()->with([
                    'toast_msg' => __('messages.wthdrwl_rej_succf'),
                    'toast_type' => 'suc'
                ]);
            } catch (\Exception $e) {
                return back()->with([
                    'toast_msg' => __('messages.err_updt_rec'),
                    'toast_type' => 'err'
                ]);
            }
        } else {
            return redirect('/');
        }
    }

    public function approveWD($id)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {

            try {
                $usr = withdrawal::find($id);
                if ($usr->status == 'Approved') {
                    return back()->with([
                        'toast_msg' => __('messages.wthdrwl_apprv'),
                        'toast_type' => 'err'
                    ]);
                }

                if ($usr->status == 'Rejected') {
                    return back()->with([
                        'toast_msg' => __('messages.wthdrwl_alrej'),
                        'toast_type' => 'err'
                    ]);
                }

                $userID = $usr->user_id;
                $wd_id = $usr->id;
                $wd_act = $usr->account;
                $wd_amt = $usr->amount;
                $wd_currency = $usr->currency;
                $usr->status = __('messages.apprv');
                $usr->save();

                $adm = Session::get('adm');
                $act = new adminLog;
                $act->admin = $adm->email;
                $act->action =  __('messages.apprv_wthdrwl_id') . $id;
                $act->save();

                $user_act = User::find($userID);

                $maildata = ['email' => $user_act->email, 'wd_id' => $wd_id, 'act' => $wd_act, 'amt' => $wd_amt, 'currency' => $wd_currency];
                Mail::send('mail.admin_approve_wd', ['md' => $maildata], function ($msg) use ($maildata) {
                    $msg->from(env('MAIL_USERNAME'), env('APP_NAME'));
                    $msg->to($maildata['email']);
                    $msg->subject(__('messages.wd_approval'));
                });
                return back()->with([
                    'toast_msg' => __('messages.apprv_succf'),
                    'toast_type' => 'suc'
                ]);
            } catch (\Exception $e) {
                return back()->with([
                    'toast_msg' => __('messages.err_updt_rec'),
                    'toast_type' => 'err'
                ]);
            }
        } else {
            return redirect('/');
        }
    }

    public function deleteWD($id)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {

            try {
                withdrawal::where('id', $id)->delete();

                $adm = Session::get('adm');
                $act = new adminLog;
                $act->admin = $adm->email;
                $act->action = __('messages.del_wthdrwl_id') . $id;
                $act->save();

                return back()->with([
                    'toast_msg' => __('messages.suc_msg'),
                    'toast_type' => 'suc'
                ]);
            } catch (\Exception $e) {
                return back()->with([
                    'toast_msg' => __('messages.err_del_rec'),
                    'toast_type' => 'err'
                ]);
            }
        } else {
            return redirect('/');
        }
    }

    ///////////////////////////////////////////  pack edit//////////////////////////////////////////////////

    public function editPack(Request $req)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {
            try {
                $pack = packages::find($req->input('p_id'));
                $pack->min = $req->input('min');
                $pack->currency = $this->settings->currency;
                $pack->max = $req->input('max');
                $pack->daily_interest = ($req->input('interest') / 100) / $pack->period;
                // $pack->withdrwal_fee = ($req->input('fee'))/100;
                $pack->save();

                $adm = Session::get('adm');
                $act = new adminLog;
                $act->admin = $adm->email;
                $act->action = __('messages.edt_packg') . $req->input('p_id');
                $act->save();

                return back()->with([
                    'toast_msg' => 'Successful!',
                    'toast_type' => 'suc'
                ]);
            } catch (\Exception $e) {
                return back()->with([
                    'toast_msg' => __('messages.err_savn_rec'),
                    'toast_type' => 'err'
                ]);
            }
        } else {
            return redirect('/');
        }
    }


    public function admin_ban_user($id)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {

            $adm = Session::get('adm');
            try {
                $usr = admin::find($id);
                if ($usr->id == $adm->id) {
                    Session::put('status',  __('messages.yu_cnt_act'));
                    Session::put('msgType', "err");
                    return back();
                }

                if ($usr->role >= $adm->role && $adm->id != 1) {
                    Session::put('status', __('messages.err_updt_rec'));
                    Session::put('msgType', "err");
                    return back();
                } else {
                    $usr->status = '0';
                    $usr->save();
                }


                $act = new adminLog;
                $act->admin = $adm->email;
                $act->action =  __('messages.blckd_adm') . $id;
                $act->save();

                Session::put('status', __('messages.suc_msg'));
                Session::put('msgType', "suc");
                return back(); //

            } catch (\Exception $e) {
                Session::put('status', __('messages.err_updt_rec'));
                Session::put('msgType', "err");
                return back();
            }
        } else {
            return redirect('/');
        }
    }

    public function admin_activate_user($id)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {
            $adm = Session::get('adm');
            try {
                $usr = admin::find($id);
                if ($usr->id == $adm->id) {
                    Session::put('status', __('messages.yu_cnt_act'));
                    Session::put('msgType', "err");
                    // return $usr->id.' '.$adm->id;
                    return back();
                }

                if ($usr->role >= $adm->role && $adm->id != 1) {
                    Session::put('status', __('messages.err_updt_rec'));
                    Session::put('msgType', "err");
                    return back();
                } else {
                    $usr->status = '1';
                    $usr->save();
                }


                $act = new adminLog;
                $act->admin = $adm->email;
                $act->action = __('messages.actvtd_adm') . $id;
                $act->save();

                Session::put('status', __('messages.suc_msg'));
                Session::put('msgType', "suc");
                return back(); //

            } catch (\Exception $e) {
                Session::put('status', __('messages.err_updt_rec'));
                Session::put('msgType', "err");
                return back();
            }
        } else {
            return redirect('/');
        }
    }

    public function dadmin_delete_user($id)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {

            $adm = Session::get('adm');
            try {
                $usr = admin::find($id);
                if ($usr->id == $adm->id) {
                    Session::put('status', __('messages.yu_cnt_del'));
                    Session::put('msgType', "err");
                    return back();
                }

                if ($usr->role >= $adm->role && $adm->author != 0 && $usr->author != $adm->id) {
                    Session::put('status', __('messages.err_updt_rec'));
                    Session::put('msgType', "err");
                    return back();
                } else {
                    admin::where('id', $id)->delete();

                    $act = new adminLog;
                    $act->admin = $adm->email;
                    $act->action = __('messages.err_updt_rec') . $id;
                    $act->save();

                    Session::put('status', __('messages.suc_msg'));
                    Session::put('msgType', "suc");
                    return back(); //
                }
            } catch (\Exception $e) {
                Session::put('status', __('messages.err_updt_rec'));
                Session::put('msgType', "err");
                return back();
            }
        } else {
            return redirect('/');
        }
    }


    public function admAddnew(Request $req)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {
            try {
                $adm = Session::get('adm');
                // $usr = admin::find($id);
                if ($adm->role < $req->input('role')) {
                    Session::put('status', __('messages.yu_cnt_perf'));
                    Session::put('msgType', "err");
                    return back();
                }

                if ($adm->role == 1) {
                    Session::put('status', __('messages.yu_cnt_perf'));
                    Session::put('msgType', "err");
                    return back();
                }


                $pack = new admin;
                $pack->name = $req->input('Name');
                $pack->email = $req->input('email');
                $pack->pwd = Hash::make($req->input('pwd'));
                $pack->role = $req->input('role');
                $pack->author = $adm->id;
                $pack->status = 1;
                $pack->save();

                $act = new adminLog;
                $act->admin = $adm->email;
                $act->action = __('messages.crt_adm') . $req->input('email');
                $act->save();

                Session::put('status', __('messages.suc_msg'));
                Session::put('msgType', "suc");
                return back();
            } catch (\Exception $e) {
                Session::put('status', __('messages.err_savn_rec'));
                Session::put('msgType', "err");
                return back();
            }
        } else {
            return redirect('/');
        }
    }

    function editMsg($id)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {
            $msg = msg::find($id);
            return json_encode($msg);
        } else {
            return redirect('/');
        }
    }

    public function admSendMsg(Request $req)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {
            $adm = Session::get('adm');
            $validator = Validator::make($req->all(), [
                'subject' => 'required|min:5|max:50|string',
                'msg' => 'required|string'
            ]);

            if ($validator->fails()) {
                return back()->With([
                    'toast_msg' => __('messages.msg_err') . ' ' . $validator->errors()->first(),
                    'toast_type' => 'err'
                ]);
            }

            try {
                if (empty($req->input('msg_state'))) {
                    $msg = new msg;
                    $msg->message = $req->input('msg');
                    $msg->subject = $req->input('subject');
                    if (!empty($req->input('msg_users'))) {
                        $msg->users = $req->input('msg_users') . ';';
                    }

                    $msg->save();

                    $act = new adminLog;
                    $act->admin = $adm->email;
                    $act->action =  __('messages.adm_snt_notf');
                    $act->save();
                } else {
                    $msg = msg::find($req->input('msg_state'));
                    $msg->message = $req->input('msg');
                    $msg->subject = $req->input('subject');
                    $msg->readers = '';
                    if (!empty($req->input('msg_users'))) {
                        $msg->users = $req->input('msg_users');
                    } else {
                        $msg->users = NULL;
                    }
                    $msg->save();

                    $act = new adminLog;
                    $act->admin = $adm->email;
                    $act->action =  __('messages.adm_updt');
                    $act->save();
                }
                return back()->With([
                    'toast_msg' => __('messages.snt_succf'),
                    'toast_type' => 'suc'
                ]);
            } catch (\Exception $e) {
                return back()->With([
                    'toast_msg' => __('messages.err_savn_msg') . $e->getMessage(),
                    'toast_type' => 'err'
                ]);
            }
        } else {
            return redirect('/login');
        }
    }

    public function admChangePwd(Request $req)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {
            try {
                $adm = Session::get('adm');

                if ($req->input('newpwd') != $req->input('cpwd')) {
                    Session::put('status', __('messages.nw_pwd_try'));
                    Session::put('msgType', "err");
                    return back();
                }

                if (Hash::check($req->input('oldpwd'),  $adm->pwd)) {
                    $ad = admin::find($adm->id);
                    $ad->pwd = Hash::make($req->input('newpwd'));
                    $ad->save();

                    $act = new adminLog;
                    $act->admin = $adm->email;
                    $act->action = __('messages.adm_chng_pwd');
                    $act->save();

                    Session::put('status', __('messages.suc_msg'));
                    Session::put('msgType', "suc");
                    return back();
                }
                else
                {
                    Session::put('status', __('messages.err_savn_msg'));
                    Session::put('msgType', "err");
                    return back();
                }
            } catch (\Exception $e) {
                Session::put('status', __('messages.err_savn_msg'));
                Session::put('msgType', "err");
                return back();
            }
        } else {
            return redirect('/');
        }
    }


    public function admSearchByMonth(Request $req)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {
            $val = $req->input('search_val');
            $musers = User::where('created_at', 'like', '%' . $val . '%')->where('status', 1)->orderby('created_at', 'asc')->get();
            $mInv = investment::where('date_invested', 'like', '%' . $val . '%')->where('status', 'active')->orderby('date_invested', 'asc')->get();
            $mDep = deposits::where('created_at', 'like', '%' . $val . '%')->where('status', 1)->orderby('created_at', 'asc')->get();
            $mWd = Withdrawal::where('w_date', 'like', '%' . $val . '%')->orderby('w_date', 'asc')->get();


            $musersDate = $mInvDate = $mDepDate = $mWdDate = [];
            $musersVal = $mInvVal = $mDepVal = $mWdVal = [];
            $iCount = $dCount = $wCount = 0;
            $pt = "";
            $cnt = 0;
            $sum_cap = 0;

            foreach ($musers as $in) {
                if ($pt != date('Y-m-d', strtotime($in->created_at))) {
                    $sum_cap = 0;
                    $pt = date('Y-m-d', strtotime($in->created_at));
                    $musersDate[$cnt] = date('d/m/y', strtotime($in->created_at));
                    $m_count = withdrawal::where('created_at', 'like', '%' . $pt . '%')->get();
                    // foreach ($m_count as $n)
                    // {
                    //     $sum_cap += $n->amount;
                    // }
                    $musersVal[$cnt] = count($m_count);
                    $sum_cap = 0;
                    $cnt += 1;
                }
            }
            $pt = "";
            $cnt = 0;
            $sum_cap = 0;
            foreach ($mInv as $in) {
                if ($pt != date('Y-m-d', strtotime($in->created_at))) {
                    $pt = date('Y-m-d', strtotime($in->created_at));
                    $mInvDate[$cnt] = date('d/m/y', strtotime($in->created_at));
                    $m_count = withdrawal::where('created_at', 'like', '%' . $pt . '%')->get();
                    foreach ($m_count as $n) {
                        $sum_cap += $n->amount;
                    }
                    $mInvVal[$cnt] = $sum_cap;
                    $sum_cap = 0;
                    $cnt += 1;
                }
                $iCount += $in->capital;
            }
            $pt = "";
            $cnt = 0;
            $sum_cap = 0;
            foreach ($mDep as $in) {
                if ($pt != date('Y-m-d', strtotime($in->created_at))) {
                    $pt = date('Y-m-d', strtotime($in->created_at));
                    $mDepDate[$cnt] = date('d/m/y', strtotime($in->created_at));
                    $m_count = withdrawal::where('created_at', 'like', '%' . $pt . '%')->get();
                    foreach ($m_count as $n) {
                        $sum_cap += $n->amount;
                    }
                    $mDepVal[$cnt] = $sum_cap;
                    $cnt += 1;
                    $sum_cap = 0;
                }
                $dCount += $in->amount;
            }
            $pt = "";
            $cnt = 0;
            $sum_cap = 0;
            foreach ($mWd as $in) {
                if ($pt != date('Y-m-d', strtotime($in->created_at))) {
                    $pt = date('Y-m-d', strtotime($in->created_at));
                    $mWdDate[$cnt] = date('d/m/y', strtotime($in->created_at));
                    $m_count = withdrawal::where('created_at', 'like', '%' . $pt . '%')->get();
                    foreach ($m_count as $n) {
                        $sum_cap += $n->amount;
                    }
                    $mWdVal[$cnt] = $sum_cap;
                    $cnt += 1;
                    $sum_cap = 0;
                }
                $wCount += $in->amount;
            }
            $search_mt = date("M-Y", strtotime(trim($req->input('search_val'))));
            $rst = [$musersDate, $mInvDate, $mDepDate, $mWdDate, $musersVal, $mInvVal, $mDepVal, $mWdVal, count($musers), $iCount, $dCount, $wCount, $search_mt];
            return json_encode($rst);
        } else {
            return redirect('/');
        }
    }

    public function switch_pack($id)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {
            $adm = Session::get('adm');
            if ($adm->role == 3 || $adm->role == 2) {
                $pack = packages::find($id);
                if (!empty($pack)) {
                    if ($pack->status == 0) {
                        $pack->status = 1;
                    } else {
                        $pack->status = 0;
                    }
                    $pack->save();
                    return 's';
                }
            } else {
                return (__('messages.user_cn_updt'));
            }
        } else {
            return redirect('/');
        }
    }

    function editMsgDel($id)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {
            $msg = msg::where('id', $id)->delete();
            return json_encode('["rst" => "' . __('messages.suc_msg') . '" ]');
        } else {
            return redirect('/');
        }
    }

    function site_settings()
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {
            $data = $this->load_data();
            return view('admin.settings', [
                'settings' => $data[9], 'adm' => $data[0], 'logs' => $data[8], 'users' => $data[3], 'inv' => $data[1],
                'deposits' => $data[2],
            ]);
        } else {
            return redirect('/');
        }
    }

    function adminViewProfileSettings()
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {
            $data = $this->load_data();
            return view('admin.profile', [
                'settings' => $data[9], 'adm' => $data[0], 'logs' => $data[8], 'users' => $data[3], 'inv' => $data[1],
                'deposits' => $data[2],
            ]);
        } else {
            return redirect('/');
        }
    }

    function adminUpdatSettings(Request $req)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {
            ref_set::truncate();

            if ($req->has('1')) {
                for ($i = 1; $i <= $req['referal_levels']; $i++) {
                    $ref_set = new ref_set();
                    $ref_set->name = $i;
                    $ref_set->val = $req[$i] / 100;

                    $ref_set->save();
                }
            }

            $val = validator::make($req->all(), [
                'siteTitle' => 'required|max:20',
                'siteDescr' => 'required|max:70',
                'hcolor' => 'required|min:7|max:7',
                'fcolor' => 'required|min:7|max:7',
                'cur' => 'required|string',
                'cur_conv' => 'required|numeric',
            ]);
            if ($val->fails()) {
                $toast_msg = ['msg' => $val->errors()->first(), 'type' => 'err'];
                return json_encode($toast_msg);
            }
            try {
                $settings = site_settings::find(1);

                $settings->site_title = $req->input('siteTitle');
                $settings->site_descr = $req->input('siteDescr');
                $settings->header_color = $req->input('hcolor');
                $settings->footer_color = $req->input('fcolor');
                $settings->deposit = is_null($req->input('wallet')) ? 0 : $req->input('wallet');
                $settings->withdrawal = is_null($req->input('wd')) ? 0 : $req->input('wd');
                $settings->investment = is_null($req->input('inv')) ? 0 : $req->input('inv');
                $settings->user_reg = is_null($req->input('reg')) ? 0 : $req->input('reg');
                $settings->paypal_ID =  $req->input('paypal_ID');
                $settings->paypal_secret = $req->input('paypal_secret');
                $settings->paypal_mode = $req->input('paypal_mode');
                $settings->stripe_key = $req->input('stripe_key');
                $settings->stripe_secret = $req->input('stripe_secret');
                // $settings->stripe_mode = $req->input('stripe_mode');
                $settings->currency = $req->input('cur');
                $settings->currency_conversion = $req->input('cur_conv');
                $settings->chat_widget = $req->input('chat_widget');
                $settings->user_transfer = is_null($req->input('user_trans')) ? 0 : $req->input('user_trans');



                if ($req->hasFile('siteLogo')) {
                    $val = validator::make($req->all(), [
                        'siteLogo' => 'image|mimes:png|max:500',
                    ]);
                    if ($val->fails()) {
                        $toast_msg = ['msg' => $val->errors()->first(), 'type' => 'err'];
                        return json_encode($toast_msg);
                    }
                    $file = $req->file('siteLogo');
                    $path = "logo.png"; //$req->file('u_file')->store('public/post_img');
                    $file->move('img/', $path);
                    $settings->site_logo = $path;
                }

                ///// Environment ////////////////////////////////////////////////////////////////

                $file = DotenvEditor::setKeys([
                    //// paypal ///////////////////////////////////////////////////////////////
                    [
                        'key'     => 'PAYPAL_CLIENT_ID',
                        'value'   => $req->input('paypal_ID')
                    ],
                    [
                        'key'     => 'PAYPAL_SECRET',
                        'value'   => $req->input('paypal_secret')
                    ],
                    [
                        'key'     => 'PAYPAL_MODE',
                        'value'   => $req->input('paypal_mode')
                    ],
                    [
                        'key'     => 'SWITCH_PAYPAL',
                        'value'   => is_null($req->input('switch_paypal')) ? 0 : $req->input('switch_paypal')
                    ],

                    //// Stripe ///////////////////////////////////////////////////////////////
                    [
                        'key'     => 'STRIPE_KEY',
                        'value'   => $req->input('stripe_key')
                    ],
                    [
                        'key'     => 'STRIPE_SECRET',
                        'value'   => $req->input('stripe_secret')
                    ],
                    [
                        'key'     => 'SWITCH_STRIPE',
                        'value'   => is_null($req->input('switch_stripe')) ? 0 : $req->input('switch_stripe')
                    ],

                    //// Coinpayment BTC ///////////////////////////////////////////////////////////////
                    [
                        'key'     => 'COINPAYMENTS_DB_PREFIX',
                        'value'   => 'cp_'
                    ],
                    [
                        'key'     => 'COINPAYMENTS_MERCHANT_ID',
                        'value'   => $req->input('cp_m_id')
                    ],
                    [
                        'key'     => 'COINPAYMENTS_PUBLIC_KEY',
                        'value'   => $req->input('cp_p_key')
                    ],
                    [
                        'key'     => 'COINPAYMENTS_PRIVATE_KEY',
                        'value'   => $req->input('cp_pr_key')
                    ],
                    [
                        'key'     => 'COINPAYMENTS_IPN_SECRET',
                        'value'   => $req->input('cp_ipn_secret')
                    ],
                    [
                        'key'     => 'COINPAYMENTS_IPN_URL',
                        'value'   => $req->input('cp_ipn_url')
                    ],
                    [
                        'key'     => 'SWITCH_BTC',
                        'value'   => is_null($req->input('switch_BTC')) ? 0 : $req->input('switch_BTC')
                    ],
                    [
                        'key'     => 'SWITCH_ETH',
                        'value'   => is_null($req->input('switch_ETH')) ? 0 : $req->input('switch_ETH')
                    ],

                    //// Bank deposit switch ////////////////////////////////////////////////////////////
                    [
                        'key'     => 'BANK_NAME',
                        'value'   => $req->input('bank_name')
                    ],
                    [
                        'key'     => 'ACCOUNT_NUMBER',
                        'value'   => $req->input('act_no')
                    ],
                    [
                        'key'     => 'ACCOUNT_NAME',
                        'value'   => $req->input('act_name')
                    ],
                    [
                        'key'     => 'ROUTE_IBAN_NUMBER',
                        'value'   => $req->input('route_iban')
                    ],
                    [
                        'key'     => 'BANK_DEPOSIT_EMAIL',
                        'value'   => $req->input('dep_email')
                    ],
                    [
                        'key'     => 'BANK_DEPOSIT_SWITCH',
                        'value'   => is_null($req->input('switch_bank_deposit')) ? 0 : $req->input('switch_bank_deposit')
                    ],

                    //// Min deposit ////////////////////////////////////////////////////////////
                    [
                        'key'     => 'MIN_DEPOSIT',
                        'value'   => $req->input('min_dep')
                    ],
                    [
                        'key'     => 'MAX_DEPOSIT',
                        'value'   => $req->input('max_dep')
                    ],

                    //// Referal bonus ////////////////////////////////////////////////////////////

                    [
                        'key'     => 'REF_TYPE',
                        'value'   => $req->input('referal_type')
                    ],
                    [
                        'key'     => 'REF_SYSTEM',
                        'value'   => $req->input('referal_system')
                    ],
                    [
                        'key'     => 'REF_LEVEL_CNT',
                        'value'   => intval($req->input('referal_levels'))
                    ],

                    //// Mail Settings ////////////////////////////////////////////////////////////
                    [
                        'key'     => 'MAIL_DRIVER',
                        'value'   => 'smtp'
                    ],
                    [
                        'key'     => 'MAIL_HOST',
                        'value'   => $req->input('m_host')
                    ],
                    [
                        'key'     => 'MAIL_PORT',
                        'value'   => $req->input('m_port')
                    ],
                    [
                        'key'     => 'MAIL_SENDER',
                        'value'   => $req->input('m_sender')
                    ],
                    [
                        'key'     => 'MAIL_USERNAME',
                        'value'   => $req->input('m_user')
                    ],
                    [
                        'key'     => 'MAIL_PASSWORD',
                        'value'   => $req->input('m_pwd')
                    ],
                    [
                        'key'     => 'SUPPORT_EMAIL',
                        'value'   => $req->input('supEmail')
                    ],
                    [
                        'key'     => 'MAIL_ENCRYPTION',
                        'value'   => $req->input('m_enc')
                    ],
                    [
                        'key'     => 'WD_LIMIT',
                        'value'   => $req->input('wd_limit')
                    ],
                    [
                        'key'     => 'WD_FEE',
                        'value'   => $req->input('wd_fee') / 100
                    ],
                    [
                        'key'     => 'WITHDRAWAL',
                        'value'   =>  is_null($req->input('wd')) ? 0 : $req->input('wd')
                    ],
                    [
                        'key'     => 'MIN_WD',
                        'value'   => $req->input('min_wd')
                    ],
                    [
                        'key'     => 'CURRENCY',
                        'value'   => $req->input('cur')
                    ],
                    [
                        'key'     => 'CONVERSION',
                        'value'   => $req->input('cur_conv')
                    ],
                    ///////// Paystack ////////////////////////////////////////////////////////////////////
                    [
                        'key'     => 'PAYSTACK_PUBLIC_KEY',
                        'value'   => $req->input('paystack_pub_key')
                    ],
                    [
                        'key'     => 'PAYSTACK_SECRET_KEY',
                        'value'   => $req->input('paystack_secret')
                    ],
                    [
                        'key'     => 'MERCHANT_EMAIL',
                        'value'   => $req->input('paystack_email')
                    ],
                    [
                        'key'     => 'PAYSTACK_SWITCH',
                        'value'   => is_null($req->input('paystack_switch')) ? 0 : $req->input('paystack_switch')
                    ],

                    /////////////// PM ////////////////////////////////////////////////////////////////////
                    [
                        'key'     => 'PM_ACCOUNT',
                        'value'   => $req->input('pm_id')
                    ],
                    [
                        'key'     => 'PM_COMPANY',
                        'value'   => $req->input('pm_name')
                    ],
                    [
                        'key'     => 'PM_SWITCH',
                        'value'   => is_null($req->input('pm_switch')) ? 0 : $req->input('pm_switch')
                    ],

                    /////////////// Payeer ////////////////////////////////////////////////////////////////////
                    [
                        'key'     => 'PAYEER_MID',
                        'value'   => $req->input('payeer_id')
                    ],
                    [
                        'key'     => 'PAYEER_KEY',
                        'value'   => $req->input('payeer_key')
                    ],
                    [
                        'key'     => 'PAYEER_SWITCH',
                        'value'   => is_null($req->input('payeer_switch')) ? 0 : $req->input('payeer_switch')
                    ],

                    /////////////// Coinbase ////////////////////////////////////////////////////////////////////
                    [
                        'key'     => 'COINBASE_SWITCH',
                        'value'   => is_null($req->input('coinbase_switch')) ? 0 : $req->input('coinbase_switch')
                    ],
                    [
                        'key'     => 'COINBASE_API_KEY',
                        'value'   => $req->input('coinbase_key')
                    ],
                    [
                        'key'     => 'COINBASE_WEBHOOK_SECRETE',
                        'value'   => $req->input('coinbase_seceret')
                    ],
                    
                    /////////////// Blockchain ////////////////////////////////////////////////////////////////////
                    [
                        'key'     => 'BC_SWITCH',
                        'value'   => is_null($req->input('bc_switch')) ? 0 : $req->input('bc_switch')
                    ],
                    [
                        'key'     => 'BCM_SECRETE',
                        'value'   => $req->input('bc_secrete')
                    ],
                    [
                        'key'     => 'BC_MY_XPUB',
                        'value'   => $req->input('bc_xpub')
                    ],
                    [
                        'key'     => 'BC_MY_API_KEY',
                        'value'   => $req->input('bc_api_key')
                    ],

                ]);

                $file = DotenvEditor::save();
                $settings->save();
                $toast_msg = ['msg' => __('messages.set_sav'), 'type' => 'suc'];
                return json_encode($toast_msg);
            } catch (\Exception $e) {
                $toast_msg = ['msg' => $e->getMessage(), 'type' => 'err'];
                return json_encode($toast_msg);
            }
        } else {
            return redirect('/');
        }
    }

    public function create_package()
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {
            return view('admin.add_package');
        } else {
            return redirect('/');
        }
    }

    public function create_package_post(Request $req)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {
            $val = Validator::make($req->all(), [
                'package_name' => 'required|string|max:15',
                'min' => 'required|numeric',
                'max' => 'required|numeric',
                'interest' => 'required|numeric',
                'period' => 'required|numeric',
                'interval' => 'required|numeric',
                'inv_method' => 'required|numeric'
            ]);

            if ($val->fails()) {
                $toast_msg = ['msg' => __('messages.chk_val_inp'), 'type' => 'err'];
                return json_encode($toast_msg);
            }
            if ((int)$req->input('period') % (int)$req->input('interval') != 0) {
                $toast_msg = ['msg' => __('messages.prd_div_intvl'), 'type' => 'err'];
                return json_encode($toast_msg);
            }

            try {
                $interest_calc = ($req->input('interest') / 100) / $req->input('period');
                $pack = new packages;
                $pack->package_name = $req->input('package_name');
                $pack->currency = $this->settings->currency;
                $pack->min = $req->input('min');
                $pack->max = $req->input('max');
                $pack->daily_interest = $interest_calc;
                $pack->withdrwal_fee = env('WD_FEE');
                $pack->period = $req->input('period');
                $pack->days_interval = $req->input('interval');
                $pack->ref_bonus = 0;
                $pack->status = 1;
                $pack->method = $req->input('inv_method');
                $pack->save();
            } catch (\Exception $e) {
                $toast_msg = ['msg' => $e->getMessage(), 'type' => 'err'];
                return json_encode($toast_msg);
            }

            $toast_msg = ['msg' => __('messages.packg_succf'), 'type' => 'suc'];
            return json_encode($toast_msg);
        } else {
            return redirect('/');
        }
    }

    public function adminDeletePack($id)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {
            try {
                packages::where('id', $id)->delete();
                return json_encode('["rst" => "suc"]');
            } catch (\Exception $ex) {
                return json_encode('["rst" => "err"]');
            }
        } else {
            return redirect('/');
        }
    }

    public function view_tickets()
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {
            $tickets = ticket::orderby('status', 'desc')->orderby('updated_at', 'desc')->paginate(30);
            return view('admin.ticket_view', ['tickets' => $tickets]);
        } else {
            return redirect('/login');
        }
    }

    public function delete_ticket($id)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {
            ticket::with('comments')->where('id', $id)->delete(10);
            return back()->with([
                'toast_msg' => __('messages.tckt_del_succf'),
                'toast_type' => 'suc'
            ]);
        } else {
            return redirect('/login');
        }
    }

    public function open_ticket($id)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {

            $ticket_view = ticket::With('comments')->find($id);
            $comments = comments::where('ticket_id', $id)->orderby('id', 'asc')->get();
            $user = User::find($ticket_view->user_id);
            $ticket_view->state = 0;
            $ticket_view->save();
            comments::where('ticket_id', $id)->where('sender', 'user')->update(['state' => 0]);
            return view('admin.ticket_chat', ['ticket_view' => $ticket_view, 'user' => $user, 'comments' => $comments]);
        } else {
            return redirect('/login');
        }
    }
    public function ticket_chat($id)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {
            $comments = comments::with('user')->where('ticket_id', $id)->where('sender', 'user')->where('state', 1)->orderby('id', 'asc')->get();
            // $user = User::find($ticket_view->user_id);
            comments::where('ticket_id', $id)->where('sender', 'user')->update(['state' => 0]);
            return json_encode($comments);
        } else {
            return redirect('/login');
        }
    }
    public function close_ticket($id)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {
            try {
                ticket::where('id', $id)->update(['status' => 0]);
                return back()->with([
                    'toast_msg' => __('messages.tckt_clsd'),
                    'toast_type' => 'suc'
                ]);
            } catch (\Exception $e) {
                return back()->with([
                    'toast_msg' => __('messages.err_occr'),
                    'toast_type' => 'err'
                ]);
            }
        } else {
            return redirect('/login');
        }
    }
    public function ticket_comment(Request $req)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {
            $close_check = ticket::find($req->input('ticket_id'));
            $usr = User::find($close_check->user_id);
            if (empty($close_check) || $close_check->status == 0) {
                return json_encode([
                    'toast_msg' => __('messages.tckt_clsd'),
                    'toast_type' => 'err'
                ]);
            }
            $user = Session::get('adm');
            $validator = Validator::make($req->all(), [
                'ticket_id' => 'required|string',
                'msg' => 'required|string'
            ]);

            if ($validator->fails()) {
                return json_encode([
                    'toast_msg' => __('messages.msg_err') . $validator->errors()->first(),
                    'toast_type' => 'err'
                ]);
            }

            try {
                $comment = new comments([
                    'ticket_id' => $req->input('ticket_id'),
                    'sender' => 'support',
                    'sender_id' => $user->id,
                    'message' => $req->input('msg'),
                ]);
                $comment->save();

                $maildata = ['email' => $usr->email, 'username' => $usr->username];

                Mail::send('mail.admin_tickect_msg', ['md' => $maildata], function ($msg) use ($maildata) {
                    $msg->from(env('MAIL_USERNAME'), env('APP_NAME'));
                    $msg->to($maildata['email']);
                    $msg->subject(__('messages.ticket_msg'));
                });

                return json_encode([
                    'toast_msg' => __('messages.suc_msg'),
                    'toast_type' => 'suc',
                    'comment_msg' => $req->input('msg'),
                    'comment_time' => date('Y-m-d H:i:s'),
                ]);
            } catch (\Exception $e) {
                return json_encode([
                    'toast_msg' => __('messages.err_uknw'),
                    'toast_type' => 'err'
                ]);
            }
        } else {
            return redirect('/login');
        }
    }

    public function kyc()
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {
            return view('admin.kyc');
        } else {
            return redirect('/login');
        }
    }

    public function approve_kyc(Request $req)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {
            try {
                $kyc = kyc::find($req['id']);
                $kyc->status = 1;
                $kyc->save();
                return back()->with([
                    'toast_msg' => __('messages.apprvl_suucf'),
                    'toast_type' => 'suc'
                ]);
            } catch (\Exception $e) {
                return back()->with([
                    'toast_msg' => __('messages.err_uknw'),
                    'toast_type' => 'err'
                ]);
            }
        } else {
            return redirect('/login');
        }
    }

    public function reject_kyc(Request $req)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {
            try {
                $kyc = kyc::find($req['id']);
                $files = array(env('APP_URL') . '/img/kyc/' . $kyc->front_card, env('APP_URL') . '/img/kyc/' . $kyc->back_card, env('APP_URL') . '/img/kyc/' . $kyc->address_proof);
                File::delete($files);
                $kyc->delete();
                return back()->with([
                    'toast_msg' => __('messages.kyc_del'),
                    'toast_type' => 'suc'
                ]);
            } catch (\Exception $e) {
                return back()->with([
                    'toast_msg' => __('messages.err_uknw'),
                    'toast_type' => 'err'
                ]);
            }
        } else {
            return redirect('/login');
        }
    }

    public function admin_add_fund(Request $req)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {
            $user = User::find($req['uid']);
            if (!empty($user)) {
                try {
                    $user->wallet += floatval($req['amt']);
                    $user->save();
                    return back()->with([
                        'toast_msg' => __('messages.fund_add_suc'),
                        'toast_type' => 'suc'
                    ]);
                } catch (\Exception $e) {
                    return back()->with([
                        'toast_msg' => __('messages.err_uknw'),
                        'toast_type' => 'err'
                    ]);
                }
            } else {
                return back()->with([
                    'toast_msg' =>  __('messages.usr_not_found'),
                    'toast_type' => 'err'
                ]);
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function admin_remove_fund(Request $req)
    {
        if (Session::has('adm') && !empty(Session::get('adm'))) {
            $user = User::find($req['uid']);
            if (!empty($user)) {
                try {
                    $user->wallet -= floatval($req['amt']);
                    $user->save();
                    return back()->with([
                        'toast_msg' => __('messages.fund_remv_suc'),
                        'toast_type' => 'suc'
                    ]);
                } catch (\Exception $e) {
                    return back()->with([
                        'toast_msg' => __('messages.err_uknw'),
                        'toast_type' => 'err'
                    ]);
                }
            } else {
                return back()->with([
                    'toast_msg' =>  __('messages.usr_not_found'),
                    'toast_type' => 'err'
                ]);
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function admin_reset_pwd(Request $req)
    {

        try {
            $admin_user = admin::where('email', $req['admin_email'])->get();
            if (count($admin_user) > 0) {
                $new_pwd = strtotime(date('Y-m-d H:s:i'));
                $admin_user[0]->pwd = Hash::make($new_pwd);

                $maildata = ['email' => $admin_user[0]->email, 'new_pwd' => $new_pwd];
                Mail::send('mail.admin_reset_pwd', ['md' => $maildata], function ($msg) use ($maildata) {
                    $msg->from(env('MAIL_USERNAME'), env('APP_NAME'));
                    $msg->to($maildata['email']);
                    $msg->subject(__('messages.adm_pwd_rec'));
                });
                // dd($admin_user);
                $admin_user[0]->save();
                return back()->with([
                    'toast_msg' => __('messages.pwd_rst_suc'),
                    'toast_type' => 'suc'
                ]);
            } else {
                return back()->with([
                    'toast_msg' => __('messages.usr_not_found'),
                    'toast_type' => 'err'
                ]);
            }
        } catch (\Exception $e) {
            return back()->with([
                'toast_msg' => __('messages.err_uknw'),
                'toast_type' => 'err'
            ]);
        }
    }

    public function add_lang(Request $req)
    {
        try {
            if (Session::has('adm') && !empty(Session::get('adm'))) {
                $lang = new lang;
                $lang->lang_name = ucfirst($req['lang_name']);
                $lang->lang_code = strtolower($req['lang_code']);
                
                $path = base_path().'/resources/lang/'.$req['lang_code'];

                if(!File::exists($path)) 
                {
                    File::makeDirectory($path, 0777, true);
                }
                                                
                File::copy(base_path().'/resources/lang/en/messages.php', $path.'/messages.php');

                $lang->save();

                return back()->with([
                    'toast_msg' => __('messages.lang_added_suc'),
                    'toast_type' => 'suc'
                ]);
            } else {
                return redirect()->route('login');
            }
        } catch (\Exception $e) {
            return back()->with([
                'toast_msg' => __('messages.err_uknw'),
                'toast_type' => 'err'
            ]);
        }
    }


    public function lang_del(Request $req)
    {
        try {
            if (Session::has('adm') && !empty(Session::get('adm'))) {
                $lang = lang::where('id', $req['id'])->delete();
                return back()->with([
                    'toast_msg' => __('messages.lang_del_suc'),
                    'toast_type' => 'suc'
                ]);
            } else {
                return redirect()->route('login');
            }
        } catch (\Exception $e) {
            return back()->with([
                'toast_msg' => __('messages.err_uknw'),
                'toast_type' => 'err'
            ]);
        }
    }
}
