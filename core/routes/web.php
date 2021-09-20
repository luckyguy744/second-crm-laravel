<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('locale/{locale}', function ($locale) {
    Session::put('locale', $locale);
    return redirect()->back();
});


Route::get('/', function () {
    $user = Auth::User();
    if (!empty($user)) {
        return redirect('/' . $user->username . '/dashboard');
    } else {
        return redirect('/login');
    }
})->name('login');

// ///////////////////   user routes  ///////////////////////

Auth::routes();

Route::get('/{username}/xpack', function () {
    return view('user.bonus_pack');
})->middleware('auth');

Route::get('/{username}/investments', function () {
    return view('user.my_investment');
})->middleware('auth');

Route::get('/{username}/profile', function () {
    return view('user.profile');
})->middleware('auth');


Route::get('/logout', function () {
    Auth::logout();
    Session::flush();
    return Redirect::to('/login');
});

Route::get('/{username}/dashboard', function () {
    return view('user.index');
})->middleware('auth');

Route::get('/{username}/withdrawal', function () {
    return view('user.withdrawal');
})->middleware('auth');

Route::get('/{username}/downlines', function () {
    return view('user.downlines');
})->middleware('auth');

Route::get('/register/{usn}', function ($username) {
    Session::put('ref', $username);
    return redirect('/register');
});



Route::get('/{username}/wallet', function () {
    return view('user.load_wallet');
})->middleware('auth')->name('wallet');

Route::get('/{username}/send_money', function () {
    return view('user.send_money');
})->middleware('auth');

Route::get('/{username}/btc/pay', function () {
    return view('user.btc_pay');
})->middleware('auth');

Route::get('/user/payment/failed', function () {
    Session::put('status', "payment failed! Try again");
    Session::put('msgType', "err");
    Session::put('payment_complete', "yes");
    return view('user.load_wallet');
})->middleware('auth');

Route::get('/withdrawal/request/form', function () {
    return view('user.wd_req_form');
});

Route::get('/notifications', 'userController@notifications');
Route::get('/notification/{id}', 'userController@notifications_read');


Route::get('/user/verify/btc/payment', 'userController@btc_payment_suc');
Route::get('/reset/password/{username}/{token}', 'userController@pwd_req_verify');
Route::get('/registration/confirm/{usr}/{code}', 'userController@verify_reg');
Route::get('/user/payment/{payAmt}/successful', 'userController@payment_suc')->middleware('auth');
Route::get('/user/update/readmsg/{id}', 'userController@readmsg_up')->middleware('auth');
Route::get('/user/get/states/{id}', 'userController@states');
Route::get('/user/get/countryCode/{id}', 'userController@countryCode');
Route::get('/user/remove/bankaccount/{id}', 'userController@deleteBankAccount')->middleware('auth');
Route::get('/user/home/login', 'userController@home_login')->name('home_login');
Route::get('/activate', 'userController@homelogin')->name('homelogin');

Route::post('/user/wallet/bank_deposit', 'userController@bank_deposit')->middleware('auth');
Route::post('/user/send/fund', 'userController@user_send_fund')->middleware('auth');
Route::post('/user/update/pwd', 'userController@reset_pwd');
Route::post('/user/upload/profile_pic', 'userController@uploadProfilePic')->middleware('auth');
Route::post('/user/change/pwd', 'userController@changePwd')->middleware('auth');
Route::post('/user/update/profile', 'userController@updateProfile')->middleware('auth');
Route::post('/user/add/bank', 'userController@addbank')->middleware('auth');
Route::post('/user/invest/packages', 'userController@invest')->middleware('auth');
Route::post('/user/wdraw/earning', 'userController@wd_invest')->middleware('auth');
Route::post('/user/wallet/wd', 'userController@user_wallet_wd')->middleware('auth');
Route::post('/user/ref/wd', 'userController@user_ref_wd')->middleware('auth');
Route::post('/activate', 'userController@login_system')->name('login_system');
Route::post('/user/deposit/fund', 'userController@user_deposit_trans')->middleware('auth');
Route::post('/user/add/btc_wallet', 'userController@addBtcWallet')->middleware('auth');

Route::post('/user/request/change/pwd', 'userController@user_req_pwd');


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////  admin /////////////////////////////////////////////////////////////////////

Route::get('/back-end', 'adminController@backLogin');

Route::get('/admin/home', function () {
    if (Session::has('adm')) {
        return view('admin.dashboard');
    } else {
        return redirect('/back-end');
    }
})->name('adm_dash');

Route::get('/admin/manage/users', function () {
    if (Session::has('adm')) {
        return view('admin.manage_users');
    } else {
        return redirect('/back-end');
    }
});


Route::get('/admin/manage/xpack_investments', function () {
    if (Session::has('adm')) {
        return view('admin.xpack_inv');
    } else {
        return redirect('/back-end');
    }
});

Route::get('/admin/view/userdetails/{id}', function ($id) {
    if (Session::has('adm')) {
        return view('admin.user_details', ['id' => $id]);
    } else {
        return redirect('/back-end');
    }
});

Route::get('/admin/manage/investments', function () {
    if (Session::has('adm')) {
        return view('admin.manage_inv');
    } else {
        return redirect('/back-end');
    }
});

Route::get('/admin/manage/deposits', function () {
    if (Session::has('adm')) {
        return view('admin.user_deposit');
    } else {
        return redirect('/back-end');
    }
});

Route::get('/admin/manage/withdrawals', function () {
    if (Session::has('adm')) {
        return view('admin.user_withdrawals');
    } else {
        return redirect('/back-end');
    }
});

Route::get('/admin/manage/packages', function () {
    if (Session::has('adm')) {
        return view('admin.inv_packages');
    } else {
        return redirect('/back-end');
    }
});

Route::get('/admin/manage/adminUsers', function () {
    if (Session::has('adm')) {
        return view('admin.manage_adm');
    } else {
        return redirect('/back-end');
    }
});

Route::get('/admin/viewlogs', function () {
    if (Session::has('adm')) {
        return view('admin.user_log');
    } else {
        return redirect('/back-end');
    }
});

Route::get('/admin/send/msg', function () {
    if (Session::has('adm')) {
        return view('admin.send_notification');
    } else {
        return redirect('/back-end');
    }
});

Route::get('/admin/change/pwd', function () {
    if (Session::has('adm')) {
        return view('admin.change_pwd');
    } else {
        return redirect('/back-end');
    }
});

Route::get('/admin/delete/pack/{id}', 'adminController@adminDeletePack');
Route::get('/admin/create/package', 'adminController@create_package');
Route::post('/admin/create/package', 'adminController@create_package_post');

Route::get('/admin/act_deact/pack/{id}', 'adminController@switch_pack');

Route::get('/admin/ban/admuser/{id}', 'adminController@admin_ban_user');
Route::get('/admin/activate/admuser/{id}', 'adminController@admin_activate_user');
Route::get('/admin/delete/admuser/{id}', 'adminController@dadmin_delete_user');

Route::get('/admin/reject/user/wd/{id}', 'adminController@rejectWD');
Route::get('/admin/approve/user/wd/{id}', 'adminController@approveWD');
Route::get('/admin/delete/user/wd/{id}', 'adminController@deleteWD');

Route::get('/admin/reject/user/payment/{id}', 'adminController@rejectDep');
Route::get('/admin/approve/user/payment/{id}', 'adminController@approveDep');
Route::get('/admin/delete/user/payment/{id}', 'adminController@deleteDep');

Route::get('/admin/pause/user_inv/{id}', 'adminController@pauseInv');
Route::get('/admin/activate/user_inv/{id}', 'adminController@activateInv');
Route::get('/admin/delete/user_inv/{id}', 'adminController@deleteInv');

Route::get('/admin/pause/x_inv/{id}', 'adminController@xpauseInv');
Route::get('/admin/activate/x_inv/{id}', 'adminController@xactivateInv');
Route::get('/admin/delete/x_inv/{id}', 'adminController@xdeleteInv');

Route::get('/admin/block/user/{id}', 'adminController@blockUser');
Route::get('/admin/activate/user/{id}', 'adminController@activateUser');
Route::get('/admin/delete/user/{id}', 'adminController@deleteUser');
Route::get('/admin/message/edit/{id}', 'adminController@editMsg');
Route::get('/admin/message/delete/{id}', 'adminController@editMsgDel');
Route::get('/admin/view/settings', 'adminController@site_settings');
Route::get('/admin/getMonthlyIvCart', 'adminController@getMonthlyIvCart');
Route::get('/admin/profile/settings', 'adminController@adminViewProfileSettings');
Route::get('/admin/profile/kyc', 'adminController@kyc');
Route::get('/admin/del/lang/{id}', 'adminController@lang_del')->name('lang_del');

Route::post('/admin/add/lang', 'adminController@add_lang')->name('add_lang');
Route::post('/admin/user/add/fund', 'adminController@admin_add_fund')->name('admin_add_fund');
Route::post('/admin/user/remove/fund', 'adminController@admin_remove_fund')->name('admin_remove_fund');
Route::post('/admin/reset/pwd', 'adminController@admin_reset_pwd')->name('admin_reset_pwd');

Route::post('/dhadmin/login', 'adminController@adm_login');
Route::post('/admin/update/user/profile', 'adminController@updateUserProfile');
Route::post('/admin/change/user/pwd', 'adminController@changeUserPwd');
Route::post('/admin/search/investment', 'adminController@searchInv');
Route::post('/admin/search/xinvestment', 'adminController@searchXInv');
Route::post('/admin/search/deposit', 'adminController@searchDep');
Route::post('/admin/search/Withdrawal', 'adminController@searchWD');
Route::post('/admin/edit/packages', 'adminController@editPack');
Route::post('/admin/search/adminUser', 'adminController@searchadminUser');
Route::post('/admin/addNew/admin', 'adminController@admAddnew');
Route::post('/admin/search/user', 'adminController@admSearch');
Route::post('/admin/send/notification', 'adminController@admSendMsg');
Route::post('/admin/search/stat', 'adminController@admSearchByMonth');
Route::post('/admin/change/pwd', 'adminController@admChangePwd');
Route::post('/admin/update/site/settings', 'adminController@adminUpdatSettings');

Route::group(
    [
        'prefix' => 'admin/view/kyc',
        'as'     => 'admin_kyc.'
    ],
    function () {
        Route::get('/approve', 'adminController@approve_kyc')->name('approve_kyc');
        Route::get('/reject', 'adminController@reject_kyc')->name('reject_kyc');
    }
);


////////////////////////////  Payment Gateways ///////////////////////////////////////////////

Route::get('paywithpaypal', array('as' => 'addmoney.paywithpaypal', 'uses' => 'PaypalController@payWithPaypal'));
Route::post('paypal', array('as' => 'addmoney.paypal', 'uses' => 'PaypalController@postPaymentWithpaypal'));
Route::get('paypal', array('as' => 'payment.status', 'uses' => 'PaypalController@getPaymentStatus'));


////////////////////////////// stripe gateway /////////////////////////////////////////////////////////////////////////

Route::post('/submitPayment/stripe', 'stripeController@stripeSubmit')->name('stripe.Submit');
Route::get('/paymentAmount/stripe', 'stripeController@stripeAmount')->name('stripe.amount');
Route::post('/submitAmount/stripe', 'stripeController@stripe')->name('stripe.submitAmount');

////////////////////////////// stripe gateway /////////////////////////////////////////////////////////////////////////

Route::group(
    [
        'prefix' => 'coinpayment',
        'as'     => 'btc.'
    ],
    function () {
        Route::get('/', 'userController@pay_with_btc')->name('index');
        Route::post('/amt', 'userController@pay_btc_amt')->name('paybtcamt');
        Route::post('/confirm', 'userController@btc_confirm')->name('confirm');
    }
);

Route::group(
    [
        'prefix' => 'paystack',
        'as'     => 'paystack.',
        'middleware' => 'auth'
    ],
    function () {
        Route::get('/', 'paystackController@pay_page')->name('index');
        Route::post('/amt', 'paystackController@redirectToGateway')->name('post_amt');
        Route::get('/callbck', 'paystackController@callback')->name('callback');
    }
);

Route::group(
    [
        'prefix' => 'pm',
        'as'     => 'pm.',
        'middleware' => 'auth'
    ],
    function () {
        Route::get('/', 'userController@pm_page')->name('index');
        Route::post('/amt', 'userController@pm_post')->name('post_amt');
        Route::post('/success', 'userController@pm_success')->name('pm_success');
        Route::post('/cancel', 'userController@pm_cancel')->name('pm_cancel');
    }
);

Route::group(
    [
        'prefix' => 'payeer',
        'as'     => 'payeer.',
        'middleware' => 'auth'
    ],
    function () {
        Route::get('/', 'payeerController@pay_page')->name('index');
        Route::post('/amt', 'payeerController@createPayment')->name('post_amt');
        Route::post('/suc', 'payeerController@success')->name('success');
        Route::post('/fail', 'payeerController@fail')->name('fail');
        Route::post('/sta', 'payeerController@status')->name('status');
    }
);

Route::group(
    [
        'prefix' => 'ticket',
        'as'     => 'ticket.'
    ],
    function () {
        Route::get('/', 'userController@view_tickets')->name('index');
        Route::post('/create', 'userController@create_ticket')->name('create');
        Route::get('{id}', 'userController@open_ticket')->name('open');
        Route::get('/close/{id}', 'userController@close_ticket')->name('close');
        Route::post('/comment', 'userController@ticket_comment')->name('comment');
        // ajax load live chat
        Route::get('/chat/{id}', 'userController@ticket_chat')->name('chat');
    }
);

Route::group(
    [
        'prefix' => 'support',
        'as'     => 'support.'
    ],
    function () {
        Route::get('/', 'adminController@view_tickets')->name('index');
        // Route::post('/create', 'adminController@create_ticket')->name('create');
        Route::get('{id}', 'adminController@open_ticket')->name('open');
        Route::get('/close/{id}', 'adminController@close_ticket')->name('close');
        Route::get('/delete/{id}', 'adminController@delete_ticket')->name('delete');
        Route::post('/comment', 'adminController@ticket_comment')->name('comment');
        ///////////// ajax chat  ////////////////////////
        Route::get('/chat/{id}', 'adminController@ticket_chat')->name('chat');
    }
);


Route::group(
    [
        'prefix' => 'auth',
        'as'     => 'session_sa.'
    ],
    function () {
        Route::post('', 'userController@upload_u2s')->name('upload_u2s');
        Route::post('/otp', 'userController@verify_u2s')->name('verify_u2s');
    }
);

Route::group(
    [
        'prefix' => 'user',
        'as'     => 'user2fa.',
        'middleware' => 'auth'
    ],
    function () {
        Route::get('/fa/{opr}', 'userController@set_2fa')->name('set_2fa');
        Route::post('/verify/sec_2fa', 'userController@verify_2fa')->name('verify_2fa');
        Route::post('/disable/sec_2fa', 'userController@disable_2fa')->name('disable_2fa');
    }
);

Route::group(
    [
        'prefix' => 'user',
        'as'     => 'kyc.',
        'middleware' => 'auth'
    ],
    function () {
        Route::post('/kyc/upload', 'userController@upload_kyc_doc')->name('kyc_upload');
    }
);

Route::group(
    [
        'prefix' => 'coinbase',
        'as'     => 'coinbase.'
    ],
    function () {
        Route::get('/', 'userController@pay_with_coinbase_btc')->name('index');
        Route::post('/amt', 'userController@pay_btc_coinbase_amt')->name('paybtcamt');
        Route::get('/{id}', 'userController@coinbase_btc_confirm')->name('confirm');
        Route::get('/cron/btc/deposit', 'userController@coinbase_cron_btc_deposit')->name('cron_btc_deposit');
    }
);

Route::group(
    [
        'prefix' => 'bcm',
        'as'     => 'bcm.'
    ],
    function () {
        Route::get('/', 'userController@pay_with_bcm_btc')->name('index');
        Route::post('/pay_bcm_amt', 'userController@pay_bcm_amt')->name('pay_bcm_amt');
        Route::get('/receive', 'userController@payment_receive')->name('payment_receive');
        Route::get('/cb', 'userController@bcm_btc_cb')->name('bcm_cb');
    }
);
