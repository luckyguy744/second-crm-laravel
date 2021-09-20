<?php
    $st = App\site_settings::find(1);
?>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<title>{{ __('messages.wd_approval') }}</title>
	<link rel="stylesheet" href="{{env('APP_URL')}}/css/bootstrap.min.css">
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >
</head>
<body>
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4" style="border:1px solid #CCC; padding:4%; box-shadow:2px 2px 4px 4px #CCC;">
            <div align="">
        		<img src="{{env('APP_URL')}}/img/{{$st->site_logo}}" style="height:100px; width:100px;" align="center">
        	</div>
        	<h3 align="">{{ __('messages.wd_approval') }}</h3>
        	<p>
        	   {{ __('messages.wd_this_info') }}  <b>{{$md['wd_id']}} {{ __('messages.mail_on') }} {{env('APP_URL')}} </b>{{ __('messages.wd_has_appr') }}  <br> 
        	   {{ __('messages.wd_kindly_wait') }} <br>
        	   <b>{{ __('messages.act :') }} {{$md['act']}}</b><br>
        	   <b>{{ __('messages.amnt :') }} {{$md['currency']}}{{$md['amt']}}</b>
        	</p>
        	<p>
        		<i class="fa fa-certificate">{{$st->site_title}} {{ __('messages.wd_ivt') }}.
        	</p>
        </div>
    </div>
	
</body>
</html>