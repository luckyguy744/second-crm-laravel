<?php
    $st = App\site_settings::find(1);
?>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>{{ __('messages.tkt_t_msg_mail') }}</title>
</head>
<body>
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4" style="border:1px solid #CCC; padding:4%; box-shadow:2px 2px 4px 4px #CCC;">
            <div align="">
                <img src="{{env('APP_URL')}}/img/{{$st->site_logo}}" style="height:100px; width:100px;" align="center">
            </div>
            <h3 align="">{{ __('messages.tkt_t_msg_mail') }}</h3>
            <p>
               {{ __('messages.hi_adm') }}, <b>{{$md['username']}}</b> {{ __('messages.has_left_msg') }} {{env('APP_URL')}}.
               <br>
               {{ __('messages.kdly_att_to_msg') }}.               
            </p>
            <p>
                <i class="fa fa-certificate">{{env('APP_NAME')}} {{ __('messages.wd_ivt') }}.
            </p>
        </div>
    </div>
    
</body>
</html>