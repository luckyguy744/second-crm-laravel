@extends('inc.ai_layout')
@section('content')
<body>
    <div style="">
        <div class="fixedOeverlayBG"></div>
        <div class="">
            <div class="row login_row_cont">
                <div class="col-md-3 ">                                    
                </div>
                <div class="col-md-6 bg_white mt-5">
                    
                    <div class="row">
                        <div class="col-md-12 " >
                            <div style="">                        
                                <div class="">
                                    <div class="">
                                        <div align="center">
                                            <br>
                                            <img src="/img/{{$settings->site_logo}}" alt="{{$settings->site_title}}" class="login_logo">
                                            <h3 class="colhd mt-2"><i class="fa fa-key"></i>{{ __('messages.activation_title') }}</h3>
                                            <hr>
                                        </div>
                                    </div>

                                    <div class="">
                                        <form method="POST" action="{{ route('login_system') }}" class=""> 
                                            @if(Session::has('err'))
                                                <div class="alert alert-danger">
                                                    {{Session::get('err')}}
                                                </div>
                                            @endif                                          
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label>{{ __('messages.activation_det') }}</label>
                                                </div>
                                            </div>
                                            <div class="form-group row" >
                                                <div class="col-md-6">
                                                    <input type="text" class="regTxtBox" name="key" value="" required placeholder="{{ __('messages.actvation_key') }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="regTxtBox" name="app_name" value="" required placeholder="{{ __('messages.app_name') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6 mt-2">
                                                    <label>{{ __('messages.admin_setup') }}</label>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <input type="email" class="regTxtBox" name="username" value="" required placeholder="{{ __('messages.admin_email') }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="password" class="regTxtBox" name="password" value="" required placeholder="{{ __('messages.admin_form_pwd') }}">
                                                </div>
                                            </div>
                                            
                                            <!-- <div class="form-group row">
                                                <div class="col-md-6 mt-5">
                                                    <label>Database Details</label>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row">
                                                <div class="col-md-6 mt-3">
                                                    <h6>{{ __('Database Name ') }}</h6>
                                                    <input type="text" class="regTxtBox" name="db_name" value="" required placeholder="">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <h6>{{ __('Database Username') }}</h6>
                                                    <input type="text" class="regTxtBox" name="db_user" value=""  placeholder="">
                                                </div>
                                                 <div class="col-md-6 mt-3">
                                                    <h6>{{ __('Database Password') }}</h6>
                                                    <input type="password" class="regTxtBox" name="db_pwd" value="" placeholder="">
                                                </div>
                                            </div> -->

                                            <div class="mb-5">
                                                <div class="mt-5" align="center">
                                                    <button type="submit" class="collc btn btn-primary">
                                                        {{ __('messages.btn_activate') }}
                                                    </button>                               
                                                </div>                                                
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <br><br>
        </div>
    </div>
    <!--<div class="floating_lang_div" style="">-->
    <!--    <select id="lang_select" class="lang_select_input">-->
    <!--        @if(count($lang) > 0 )-->
    <!--            @foreach($lang as $activity)-->
    <!--                <option value="{{ $activity->lang_code }}" @if(Session::get('locale') == $activity->lang_code)) {{__('selected')}} @endif><i class="fa fa-flag"></i>{{ strtoupper($activity->lang_code) }}</option>-->
    <!--            @endforeach-->
    <!--        @else-->
    <!--            {{ __('No language') }}-->
    <!--        @endif      -->
            
    <!--    </select>-->
    <!--</div>-->
@endsection
