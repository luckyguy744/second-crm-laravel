@include('user.inc.fetch')
@extends('layouts.atlantis.layout')
@Section('content')
        <div class="main-panel">
            <div class="content">
                @php($breadcome = __('messages.paypal_pymt'))
                @include('user.atlantis.main_bar')
                <div class="page-inner mt--5">                   
                    <div id="prnt"></div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title">{{ __('messages.dpt_u_pypal') }}</div>
                                        <div class="card-tools">                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row"> 
                                         
                                        <div class="col-md-7">
                                            @include('user.inc.paypal_form')
                                        </div>
                                        <div class="col-md-5 " align="center">
                                            <br>
                                            <i class="fab fa-cc-paypal fa-4x text-info"></i>
                                            <p>
                                                {{ __('') }} 
                                            </p>
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>

             @include('user.inc.confirm_inv')

@endSection
            