<?php
    $st = App\site_settings::find(1);
?>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<title>{{ __('messages.pwd_rst_ttl') }} </title>
</head>
<body>
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4" style="border:1px solid #CCC; padding:4%; box-shadow:2px 2px 4px 4px #CCC;">
            <div align="">
        		<img src="{{env('APP_URL')}}/img/{{$st->site_logo}}" style="height:100px; width:100px;" align="center">
        	</div>
        	<h3 align="">{{ __('messages.pwd_rst_ttl') }}</h3>
        	<p>
        	   {{ __('messages.pwd_req_msg') }} {{env('APP_NAME')}} {{ __('messages.pwd_rq_cont') }} <br> <b>{{ $md['new_pwd'] }}</b>
        	</p>
        	<p>
        		<i class="fa fa-certificate">{{env('APP_NAME')}} {{ __('messages.wd_ivt') }}.
        	</p>
        </div>
    </div>
	
</body>
</html>