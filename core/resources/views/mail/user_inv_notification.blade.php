<?php
    $st = App\site_settings::find(1);
?>
<!DOCTYPE html>
<html>
<head lang="{{ app()->getLocale() }}">
	<title>{{ __('messages.ivt_not') }} </title>
</head>
<body>
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4" style="border:1px solid #CCC; padding:4%; box-shadow:2px 2px 4px 4px #CCC;">
            <div align="">
        		<img src="{{env('APP_URL')}}/img/{{$st->site_logo}}" style="height:100px; width:100px;" align="center">
        	</div>
        	<h3 align="">{{ __('messages.ivt_not') }}</h3>
        	<p>
        	   {{ __('messages.hi') }}, <b>{{$md['username']}}</b> {{ __('messages.yr_ivt_on') }} {{env('APP_URL')}} {{ __('messages.was_suc') }}.
        	   <br>
               {{ __('messages.check_yr_ivt') }}.
        	   
        	</p>
        	<p>
        		<i class="fa fa-certificate">{{env('APP_NAME')}} {{ __('messages.wd_ivt') }}.
        	</p>
        </div>
    </div>
	
</body>
</html>