@extends('inc.auth_layout')
<title>Verify Account - {{env('APP_NAME')}}</title>
@section('content')
<body>
    <div class="verify_form_cont">
        <img src="/img/adult.jpg" class="fixedOverlayIMG">         
        <div class="fixedOeverlayBG"></div>
        <div class="container">
            <div class="row pad_T90">
                <div class="col-md-4"></div>
                <div class="col-md-4">                    
                    <div class="very_form_div">                        
                        <div class="panel ">
                            <div class="card-header">
                                <div align="center">
                                     <img src="/img/{{$settings->site_logo}}" alt="{{$settings->site_title}}" class="login_logo">                 
                                    <br>
                                    <h3 class="colhd"><i class="fa fa-key"></i>{{ __('messages.user_verify_call') }} </h3>
                                    <hr>
                                </div>
                            </div>
                            <div class="panel-body" style="">
                                @if(Session::has('msgType') && Session::get('msgType') == 'err')
                                
                                    <div class="alert alert-danger">
                                        {{Session::get('status')}}
                                    </div>
                                    {{Session::forget('status')}}
                                    {{Session::forget('msgType')}}
                                    
                                @elseif(Session::has('msgType') && Session::get('msgType') == 'suc')
                                
                                    <div class="alert alert-success">
                                        {{Session::get('status')}}
                                    </div>
                                    {{Session::forget('status')}}
                                    {{Session::forget('msgType')}}
                                @else
                                
                                    <div class="alert alert-danger">
                                       <p>
                                           {{ __('messages.invalid_access') }}
                                       </p>
                                    </div>
                                     
                                @endif

                                <div class="form-group row mb-0">
                                    <div class="" align="center">
                                       <p>
                                           <strong><a href="/login" class="collcc btn btn-warning">{{ __('messages.bck_to_login') }}</a></strong>
                                       </p>                            
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection