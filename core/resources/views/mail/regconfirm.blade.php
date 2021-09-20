<?php
    $st = App\site_settings::find(1);
?>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<title>{{ __('messages.req_confirm') }}</title>
</head>
<body>
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4" style="border:1px solid #CCC; padding:5%; ">
            <div align="">
        		<img src="{{env('APP_URL')}}/img/{{$st->site_logo}}" style="height:100px; width:100px;" align="center">
        	</div>
        	<h3 align="">{{ __('messages.hi') }}, {{$md['usr']}}, </h3>
        	<p>
        	    {{ __('messages.reg_str_msg') }} <a href="{{env('APP_URL')}}"><b>{{env('APP_NAME')}}</b></a>
                <br>
        		{{ __('messages.reg_msg_cont') }}.
                <br><br>
        		<a class="btn btn-info" href="{{env('APP_URL')}}/registration/confirm/{{$md['usr']}}/{{$md['token']}}">
                    <b>{{ __('messages.confirm_reg') }}</b>
                </a>
        	</p>
        	<p>
        		<i class="fa fa-certificate"></i>{{env('APP_NAME')}}.
        	</p>
        </div>
    </div>
	
</body>
</html>