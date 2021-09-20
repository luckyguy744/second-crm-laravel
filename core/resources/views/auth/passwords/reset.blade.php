@extends('inc.auth_layout')
<title>Password Reset - </title>
@section('content')

<body>
    <div>
        <img src="/img/adult.jpg" class="fixedOverlayIMG">         
        <div class="fixedOeverlayBG"></div>
        <div class="container">
            <div class="row ">
                <div class="col-md-4"></div>
                <div class="col-md-4 mt-5 card">
                    <div class="card">
                        <div class="card-header">
                            <div align="center">
                                <img src="/img/{{$settings->site_logo}}" alt="{{$settings->site_title}}" class="login_logo"> 
                                <br>
                                {{ __('messages.reset_pwd_btn') }}                                
                            </div>
                        
                        </div>
                        <div class="card-body">                            
                                @if(Session::has('msgType') && Session::get('msgType') == 'err')                                
                                    <div class="alert alert-danger">
                                        {{Session::get('status')}}
                                    </div>
                                    {{Session::forget('msgType')}}
                                    {{Session::forget('status')}}
                                     
                                @endif
                           
                                @if(Session::has('pwd_rst_suc'))
                                    <div class="alert alert-success">
                                        {{Session::get('status')}}
                                    </div>
                                    {{Session::forget('msgType')}}
                                    {{Session::forget('status')}}
                                    {{Session::forget('pwd_rst_suc')}}
                                    
                                @elseif(Session::has('pwd_reset_err'))
                                    <div class="alert alert-danger">
                                        {{Session::get('pwd_reset_err')}}
                                    </div>
                                    {{Session::forget('pwd_reset_err')}}
                                    <br><br><br>
                                @else
                                    <form method="POST" action="/user/update/pwd">
                                    @csrf                                    
                                    <div class="form-group row">
                                            <div class="col-md-12">
                                            <label for="password" class=" col-form-label text-md-right">{{ __('messages.new_pwd') }}</label>
                                            <input id="password" type="password" class="regTxtBox @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
    
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
    
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="password-confirm" class=" col-form-label text-md-right">{{ __('messages.confrm_pwd') }}</label>
                                            <input id="password-confirm" type="password" class="regTxtBox" name="c_pwd" required autocomplete="new-password">
                                        </div>
                                    </div>
    
                                    <div class="form-group row mb-0">
                                        <div class="col-md-12" align="center">
                                            <button type="submit" class="btn btn-primary collc">
                                                {{ __('messages.reset_pwd_btn') }}
                                            </button>
                                        </div>
                                        <br><br>
                                    </div>
                                </form>
                                    
                                @endif
                                <div class="form-group row mb-0">
                                    <div class="col-md-12" align="center">
                                        <a href="/login">
                                            <i class="fa fa-arrow-left"></i> {{ __('messages.bck_to_login') }}
                                        </a>
                                    </div>
                                    <br><br>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
