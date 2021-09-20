@include('user.inc.fetch')
@extends('layouts.atlantis.layout')
@Section('content')
        <div class="main-panel">
            <div class="content">
                @php($breadcome = __('messages.pm_paymt'))
                @include('user.atlantis.main_bar')
                <div class="page-inner mt--5">                   
                    <div id="prnt"></div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title">
                                             <img align="center" src="http://www.deminetsolution.biz/slides/slide4.jpg" class="img-responsive" style="height: 70px"></div>
                                        <div class="card-tools">                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row"> 
                                         
                                        <div class="col-md-7">
                                            <div class="panel-body">
                                            <form class="form-horizontal" action="https://perfectmoney.is/api/step1.asp" method="POST" role="form">
                                                <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                                    <div class="col-md-12" align="center">
                                                        <h3 align="center">{{ __('messages.confrm_amt')}}</h3>
                                                        <p style="font-size: 30px;">
                                                           <strong>{{ __('$').$pm_amount }}</strong>
                                                        </p>                                                    
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12" align="center">
                                                        <button type="submit" class="btn btn-primary">
                                                            {{ __('messages.proc') }}
                                                        </button>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="PAYEE_ACCOUNT" value="{{ env('PM_ACCOUNT') }}">
                                                <input type="hidden" name="PAYEE_NAME" value="{{ env('PM_COMPANY') }}">
                                                <input type="hidden" name="PAYMENT_AMOUNT" value="{{ $pm_amount }}">
                                                <input type="hidden" name="PAYMENT_UNITS" value="USD">
                                                <input type="hidden" name="STATUS_URL" value="{{ route('pm.pm_success') }}">
                                                <input type="hidden" name="PAYMENT_URL" value="{{ route('pm.pm_success') }}">
                                                <input type="hidden" name="NOPAYMENT_URL" value="{{ route('pm.pm_cancel') }}">
                                                <input type="hidden" name="BAGGAGE_FIELDS" value="{{ $user->username }}">
                                                <input type="hidden" name="ORDER_NUM" value="{{ $tnx_id }}">
                                                <input type="hidden" name="CUST_NUM" value="{{ $user->id }}">
                                                <!-- <input type="submit" name="PAYMENT_METHOD" value="PerfectMoney account"> -->

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

            
@endSection