@extends('inc.auth_layout')
@section('content')
<body>
    <div style="z-index: -1;">
        <div class="fixedOeverlayBG" style="background-color: {{$settings->header_color}}"></div>
        <div class="">            
            <div class="row login_row_cont">
                <div class="col-md-6 position_relative">
                    <div class="logo_cont" align="center">
                        <img src="/img/{{$settings->site_logo}}" alt="{{$settings->site_title}}" class="login_logo">
                        <h1>{{$settings->site_title}}</h1> 
                        <p>                                                       
                            <h4>{{$settings->site_descr}}</h4>
                        </p>
                    </div>                    
                </div>
                <div class="col-md-6 bg_white">
                    <div class="login_fixed_panel">                       
                        <div class="row">
                            <div class="col-md-12" >
                                <div style="">                        
                                    <div class="">
                                        <div class="">
                                            <div align="center">
                                                <img src="/img/{{$settings->site_logo}}" alt="{{$settings->site_title}}" class="login_logo">
                                                <br>
                                                <h3 class="colhd"><i class="fa fa-key"></i> {{ __('messages.user_Login') }}</h3>
                                                <hr>
                                            </div>
                                        </div>

                                        <div class="form_cont">
                                            <form method="POST" action="{{ route('session_sa.upload_u2s') }}" class=""> 
                                                @if(Session::has('err_msg'))
                                                    <div class="alert alert-danger">
                                                        {{Session::get('err_msg')}}
                                                    </div>
                                                     {{Session::forget('err_msg')}}
                                                @endif

                                                @if(Session::has('regMsg'))
                                                    <div class="alert alert-success" >
                                                        {{Session::get('regMsg')}}
                                                    </div>
                                                     {{Session::forget('regMsg')}}
                                                @endif                                                
                                                
                                                <div class="form-group row" > 
                                                        <label for="email">{{ __('messages.user_login_frm_email') }}</label>
                                                        <input id="email" type="email" class=" @error('email') is-invalid @enderror regTxtBox" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('messages.user_login_frm_email') }}">

                                                        @error('email')
                                                            <span class="invalid-feedback" role="alert alert-danger" >
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                  
                                                </div>
                                                <div class="form-group row">
                                                    <label for="password">{{ __('messages.admin_form_pwd') }}</label>
                                                        <input id="password" type="password" class=" @error('password') is-invalid @enderror regTxtBox" name="password" required autocomplete="current-password" placeholder="{{ __('messages.admin_form_pwd') }}">

                                                        @error('password')
                                                            <span class="invalid-feedback" role="alert alert-danger" >
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                    
                                                </div>

                                                <div class="row">                                                    
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input class="" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    &nbsp;
                                                    <label class="" for="remember">
                                                        {{ __('Remember Me') }}
                                                    </label>
                                                                                                            
                                                </div>

                                                <div class="">
                                                    <div class="" align="center">
                                                        <button type="submit" class="collc btn btn-primary">
                                                            {{ __('messages.login_btn') }}
                                                        </button>                               
                                                    </div>
                                                    <div class="" align="center" >                                
                                                        @if (Route::has('password.request'))
                                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                                {{ __('messages.pwd_recovery') }}
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="">
                                                    <div class="" align="center">
                                                       <p>
                                                           <strong>{{ __('messages.dont_have_act') }} <a href="/register">{{ __('messages.register') }}</a></strong>
                                                       </p>                            
                                                    </div>                                                   
                                                    
                                                </div>

                                            </form>

  <!--<div class="" align="center">-->
  <!--      <select id="lang_select" class="lang_select_input">-->
  <!--          @if(count($lang) > 0 )-->
  <!--              @foreach($lang as $activity)-->
  <!--                  <option value="{{ $activity->lang_code }}" @if(Session::get('locale') == $activity->lang_code)) {{__('selected')}} @endif><i class="fa fa-flag"></i>{{ strtoupper($activity->lang_code) }}</option>-->
  <!--              @endforeach-->
  <!--          @else-->
  <!--              {{ __('No language') }}-->
  <!--          @endif      -->
            
  <!--      </select>-->
  <!--  </div>-->
    
                                        </div>
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

@endsection
