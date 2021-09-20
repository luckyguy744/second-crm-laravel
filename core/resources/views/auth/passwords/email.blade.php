@extends('inc.auth_layout')
 <title>Password Recovery - {{env('APP_NAME')}}</title>
@section('content')
<body>
    <div>
        <img src="/img/adult.jpg" class="fixedOverlayIMG">         
        <div class="fixedOeverlayBG"></div>
        <div class="container">
            <div class="row pad_T90">
                <div class="col-md-4"></div>
                <div class="col-md-4 card">
                    <div class="card-header" align="center">
                        <img src="/img/{{$settings->site_logo}}" alt="{{$settings->site_title}}" class="login_logo"> 
                        <br>
                        <h3><i class="fa fa-key"></i>{{ __('messages.pwd_recovery2') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="">                    
                            @if(Session::has('msgType') && Session::get('msgType') == 'err')                                
                                <div class="alert alert-danger">
                                    {{Session::get('status')}}
                                </div>
                                {{Session::forget('msgType')}}
                                {{Session::forget('status')}}

                            @elseif(Session::has('msgType') && Session::get('msgType') == 'suc')
                            
                                <div class="alert alert-success">
                                    {{Session::get('status')}}
                                </div>
                                {{Session::forget('msgType')}}
                                {{Session::forget('status')}}                                
                            @else
                            @endif
                            <div>
                                <form method="POST" action="/user/request/change/pwd">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="email">{{ __('messages.user_login_frm_email') }}</label>                                        
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class=" " align="center">
                                            <button type="submit" class="collcc btn btn-primary">
                                                {{ __('messages.reset_pwd_btn') }}
                                        </div>
                                        <br><br>                                     
                                    </div>
                                    <div class="form-group row mb-0">                                      
                                        <a href="/login">
                                            <i class="fa fa-arrow-left"></i> {{ __('messages.bck_to_login') }}
                                        </a>                                    
                                        <br><br>                                     
                                    </div>
                                     
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br><br>
        </div>

    </div>
@endsection
