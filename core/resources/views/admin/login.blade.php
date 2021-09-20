@extends('inc.auth_layout')
@section('content')
<body>
    <div style="">
        <img src="/img/adult.jpg" class="fixedOverlayIMG">         
        <div style="position: fixed; left: 0px; top: 0px; height:100%; width: 100%; background-color: {{$settings->header_color}}"></div>
        <div class="">
            <div class="row admin_login_row">
                <div class="col-md-6 position_relative" >
                    <div class="admin_login_title" align="center">
                        <img src="/img/{{$settings->site_logo}}" alt="{{$settings->site_title}}" class="login_logo">
                        <h1>{{$settings->site_title}}</h1> 
                        <p>                                                       
                            <h4> {{ __('messages.admin_login_title') }} </h4>
                        </p>
                    </div>                    
                </div>
                <div class="col-md-6 bg_white">
                    <div class="login_fixed_panel">
                        <div class="row">
                            <div class="col-md-12" >
                                <div style="">                        
                                    <div class="panel" align="center">
                                        <img src="/img/{{$settings->site_logo}}" alt="{{$settings->site_title}}" class="login_logo">
                                        <br><br>
                                        <h4 align="center"><b> {{ __('messages.admin_login_frm_title') }}</b> </h4> 
                                        <div id="errMsg" class="card-header alert alert-danger cont_display_none" align="center">         
                                        </div>

                                        @if(Session::has('err2') )         
                                            <script type="text/javascript">            
                                                $('#errMsg').html("{{Session::get('err2')}}");
                                                $('#errMsg').show();
                                            </script>
                                            {{Session::forget('err2')}}
                                        @endif

                                        <div class="panel-body" style="padding: 5px 10%;">
                                            <form method="POST" action="/dhadmin/login">                        
                                                <input id="csrf" type="hidden"  name="_token" value="{{ csrf_token() }}" >
                                                <div class="form-group row" >
                                                    <b>{{ __('messages.admin_frm_email') }}</b>
                                                    <div class="input-group">
                                                        <input id="" type="hidden" name="_token" value="{{csrf_token()}}" class="form-control">
                                                        <div class="input-group-prepend bg_ash">
                                                            <span class="input-group-text"><i class="fa fa-envelope "></i></span>
                                                        </div>
                                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('messages.admin_frm_email') }}">

                                                        @error('email')
                                                            <span class="invalid-feedback text-danger" role="alert" >
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row ">
                                                    <b>{{ __('messages.admin_form_pwd') }}</b>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend bg_ash">
                                                            <span class="input-group-text"><i class="fa fa-key"></i></span>
                                                        </div>
                                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('messages.admin_form_pwd') }}">

                                                        @error('password')
                                                            <span class="invalid-feedback text-danger" role="alert" >
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-0 pt-0 pb-0">
                                                    <div class="col-md-12" align="center">
                                                        <button type="submit" class="btn btn-primary">
                                                            {{ __('messages.login_btn') }}
                                                        </button>                               
                                                    </div>
                                                    <div class="col-md-12 mt-5" align="center">
                                                        <strong><a href="" class="btn border" data-target="#reset_pwd_modal" data-toggle="modal"><i class="fa fa-key"></i> {{ __('messages.pwd_recovery') }}</a></strong>
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
            </div>
        </div>
    </div>
    <div class="modal fade" id="reset_pwd_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="padding-top:70px" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel"><b>{{ __('messages.pwd_recovery') }}</b></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('admin_reset_pwd')}}">
                        <div class="row"> 
                            <div class="col-md-12">
                                <input type="text" name="admin_email" value="" class="form-control" placeholder="{{ __('messages.admin_frm_email') }}" required >                               
                            </div> 
                            <div class="col-sm-12 mt-3">
                                <input type="submit" class="btn btn-primary" value="Reset">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                                                
                </div>
            </div>
        </div>
    </div>
    
    <div class="floating_lang_div" style="display:none">
       <select id="lang_select" class="lang_select_input">
            <?php
                $activities = $lang;
            ?>
            @if(count($activities) > 0 )
                @foreach($activities as $activity)
                    <option value="{{ $activity->lang_code }}" @if(Session::get('locale') == $activity->lang_code)) {{__('selected')}} @endif><i class="fa fa-flag"></i>{{ strtoupper($activity->lang_code) }}</option>
                @endforeach
            @else
                {{ __('No language') }}
            @endif      
            
        </select>
    </div>
@endsection
