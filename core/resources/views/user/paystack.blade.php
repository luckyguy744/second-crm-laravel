@include('user.inc.fetch')
@extends('layouts.atlantis.layout')
@Section('content')
        <div class="main-panel">
            <div class="content">
                @php($breadcome = __('messages.pystack_pymt'))
                @include('user.atlantis.main_bar')
                <div class="page-inner mt--5">                   
                    <div id="prnt"></div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title">{{ __('messages.dpt_u_pystack') }}</div>
                                        <div class="card-tools">                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row"> 
                                         
                                        <div class="col-md-7">
                                            <div class="panel-body">
                                                <form class="form-horizontal" method="POST" id="" role="form" action="{{ route('paystack.post_amt') }}" >
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="email" value="{{ $user->email }}">
                                                    <input type="hidden" name="orderID" value="{{ $user->username.strtotime(date('Y-m-s H:i:s')) }}">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <input type="hidden" name="currency" value="NGN">
                                                    <input type="hidden" name="metadata" value="{{ json_encode($array = ['Username' => $user->username]) }}" > 
                                                    <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}">
                                                    <div class="form-group">
                                                        <label for="amount" class="col-md-4 control-label">{{ __('messages.enter_amt') }}</label>
                                                        <div class="col-md-12">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><b>{{ $settings->currency }}</b></span>
                                                                </div>
                                                                <input id="amount" type="number" class="form-control" name="amount" value="" required autofocus>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-md-6 col-md-offset-4">
                                                            <button type="submit" class="btn btn-primary">
                                                                {{ __('messages.pay_now') }}
                                                            </button>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-md-5 " align="center">
                                            <br>
                                            <img src="https://website-v3-assets.s3.amazonaws.com/assets/img/hero/Paystack-mark-white-twitter.png" height="60px"></img>
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>

@endSection
            