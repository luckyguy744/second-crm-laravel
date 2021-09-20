<?php
    $user = Auth::User();  
    $myInv = App\investment::where('user_id', $user->id)->orderby('id', 'desc')->get();
    $actInv = App\investment::where('user_id', $user->id)->where('status', 'Active')->orderby('id', 'desc')->get();
    $refs = App\User::where('referal', $user->username)->get();
    $wd = App\withdrawal::where('user_id', $user->id)->get();
?>