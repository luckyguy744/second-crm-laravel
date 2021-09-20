<?php
    $user = Auth::User();  
    $settings = App\site_settings::find(1);
    
    $myInv = App\investment::where('user_id', $user->id)->orderby('id', 'desc')->get();
    $actInv = App\investment::where('user_id', $user->id)->where('status', 'Active')->orderby('id', 'desc')->get();
    
    $refs = App\ref::where('username', $user->username)->orderby('id', 'desc')->get();
    $wd = App\withdrawal::where('user_id', $user->id)->get();
    $logs = App\activities::where('user_id', $user->id)->get();
    
    $mybanks = App\banks::where('user_id', $user->id)->get();
    
    
?>