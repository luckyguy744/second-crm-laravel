<?php
    $st = App\site_settings::find(1);
?>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<title>{{ __('messages.kyc_adm_not') }} </title>
	<link rel="stylesheet" href="{{env('APP_URL')}}/css/bootstrap.min.css">
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >
    <style type="text/css">
        .btn{
            padding: 6px; background-color: #05a;
        }
        .table_boder{
            border: none;
        }
    </style>
</head>
<body>
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4" style="border:1px solid #CCC; padding:4%; box-shadow:2px 2px 4px 4px #CCC;">
            <table class="table_boder">
                <tr>
                    <td></td>
                    <td><img src="{{env('APP_URL')}}/img/{{$st->site_logo}}" style="height:100px; width:100px;" align="center"></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <h3 align="">{{ __('messages.kyc_apr_req') }}</h3>
                        <p>
                           {{ __('messages.hi_adm') }}, <b>{{$md['username']}} {{ __('messages.mail_on') }} {{env('APP_NAME')}} </b> {{ __('messages.ky_doc_appr') }}. <br> 
                           {{ __('messages.kdly_att_req') }}.<br>                           
                        </p>
                        <p>
                            <i class="fa fa-certificate">{{$st->site_title}} {{ __('messages.wd_ivt') }}.
                        </p>
                    </td>
                    <td></td>
                </tr>
            </table>
           
        	
        </div>
    </div>
	
</body>
</html>