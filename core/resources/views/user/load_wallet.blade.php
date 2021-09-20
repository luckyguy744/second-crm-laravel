@include('user.inc.fetch')
@extends('layouts.atlantis.layout')
@Section('content')
        <div class="main-panel">
            <div class="content">
                @php($breadcome = __('messages.walt'))
                @include('user.atlantis.main_bar')
                <div class="page-inner mt--5">
                    @include('user.atlantis.overview')
                    <div id="prnt"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title">{{ __('messages.dpst_int_yr_walt') }}</div>                                        
                                    </div>
                                </div>
                                <div class="card-body"> 
                                        @if($user->status == 2 || $user->status == 'Blocked')
                                            <div class="alert alert-warning">
                                                <p>
                                                   {{ __('messages.act_block') }} 
                                                </p>
                                            </div>
                                        @elseif(empty($user->currency))
                                            <div class="alert alert-warning">
                                                <p>
                                                    <a href="/{{$user->username}}/profile#userdet">
                                                        {{ __('messages.act_update') }}
                                                    </a>
                                                </p>
                                            </div>
                                        @else
                                            @if($settings->deposit == 1)      
                                                <div id="pay_cont" class="row">
                                                    @if(env('SWITCH_PAYPAL') == 1)
                                                    <div class="col-lg-6 mt-5">                                                        
                                                        <div class="payment_method" align="center">
                                                            <p>
                                                                <i class="fab fa-cc-paypal fa-4x text-info"></i> <br>
                                                            </p>
                                                            <p>
                                                                {{ __('messages.py_usng_pypl_gtwy') }}
                                                            </p>
                                                            <div align="">
                                                                <a href="{{ route('addmoney.paywithpaypal') }}" class="btn btn_blue" >{{ __('messages.pay_w_paypal') }}</a>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                    @endif
                                                    @if(env('SWITCH_STRIPE') == 1)
                                                    <div class="col-lg-6 mt-5">                                                                                                  
                                                        <div class="payment_method" align="center">
                                                            <p>
                                                                <i class="fab fa-cc-stripe fa-4x text-info"></i> <br>
                                                            </p>
                                                            <p>
                                                                {{ __('messages.py_usng_strp_gtwy') }}
                                                            </p> 
                                                           
                                                            <div align="">
                                                                <a href="{{ route('stripe.amount') }}" class="btn btn_blue" >
                                                                    {{ __('messages.pay_w_stripe') }}
                                                                </a>
                                                            </div>                                      
                                                        </div>                                                       
                                                    </div>
                                                    @endif

                                                    @if(env('PM_SWITCH') == 1)
                                                    <div class="col-lg-6 mt-5">                                                                   
                                                        <div class="payment_method" align="center">
                                                            <p>
                                                                <img src="/img/pm.png" height="50px"></img> <br>
                                                            </p>
                                                            <p>
                                                                {{ __('messages.py_usng_pm') }}
                                                            </p> 
                                                           
                                                            <div align="">
                                                                <a href="{{ route('pm.index') }}" class="btn btn_blue" >
                                                                    {{ __('messages.pay_w_pm') }}
                                                                </a>
                                                            </div>                                      
                                                        </div>                                                       
                                                    </div>
                                                    @endif

                                                   
                                                    @if(env('PAYEER_SWITCH') == 1)
                                                    <div class="col-lg-6 mt-5">                                                                   
                                                        <div class="payment_method" align="center">
                                                            <p>
                                                                <img src="/img/payeer.png" height="50px"></img> <br>
                                                            </p>
                                                            <p>
                                                                {{ __('messages.dpst_wt_pyrr') }}
                                                            </p> 
                                                           
                                                            <div align="">
                                                                <a href="{{ route('payeer.index') }}" class="btn btn_blue" >
                                                                    {{ __('messages.pay_w_payeer') }}
                                                                </a>
                                                            </div>                                      
                                                        </div>                                                       
                                                    </div>
                                                    @endif

                                                     @if(env('SWITCH_BTC') == 1)
                                                    <div class="col-lg-6 mt-5">                                                                   
                                                        <div class="payment_method" align="center">
                                                            <p>
                                                                <i class="fab fa-bitcoin fa-4x text-info"></i> <br>
                                                            </p>
                                                            <p>
                                                                {{ __('Pay using Bitcoin (Coinpayment system)') }}
                                                            </p> 
                                                           
                                                            <div align="">
                                                                <a href="{{ route('btc.index', ['coin' => 'BTC']) }}" class="btn btn_blue" >
                                                                    {{ __('Pay with BTC') }}
                                                                </a>
                                                            </div>                                      
                                                        </div>                                                       
                                                    </div>
                                                    @endif

                                                    @if(env('COINBASE_SWITCH') == 1)
                                                    <div class="col-lg-6 mt-5">                                                                    
                                                        <div class="payment_method" align="center">
                                                            <p>
                                                                <i class="fab fa-bitcoin fa-4x text-info"></i> <br>
                                                            </p>
                                                            <p>
                                                                {{ __('messages.py_usng_cnbs_cps') }}
                                                            </p> 
                                                           
                                                            <div align="">
                                                                <a href="{{ route('coinbase.index') }}" class="btn btn_blue" >
                                                                    {{ __('messages.pay_w_cb') }}
                                                                </a>
                                                            </div>                                      
                                                        </div>                                                       
                                                    </div>
                                                    @endif

                                                    @if(env('BC_SWITCH') == 1)
                                                    <div class="col-lg-6 mt-5">                                                                    
                                                        <div class="payment_method" align="center">
                                                            <p>
                                                                <i class="fab fa-bitcoin fa-4x text-info"></i> <br>
                                                            </p>
                                                            <p>
                                                                {{ __('messages.pay_w_btc_bc') }}
                                                            </p> 
                                                           
                                                            <div align="">
                                                                <a href="{{ route('bcm.index') }}" class="btn btn_blue" >
                                                                    {{ __('messages.pay_w_bc') }}
                                                                </a>
                                                                <!-- <a href="https://www.blockonomics.co/pay-url/cc98e852769c11eb" class="btn btn_blue" >
                                                                    {{ __('Pay with BTC') }}
                                                                </a>
                                                                <a href="" class="blockoPayBtn btn btn_blue" data-toggle="modal" data-uid=cc98e852769c11eb>
                                                                     {{ __('Pay with BTC') }}
                                                                </a> -->
                                                            </div>                                      
                                                        </div>                                                       
                                                    </div>
                                                    @endif

                                                    @if(env('SWITCH_ETH') == 1)
                                                    <div class="col-lg-6 mt-5">                                                                   
                                                        <div class="payment_method" align="center">
                                                            <p>
                                                                <i class="fab fa-ethereum fa-4x text-info"></i> <br>
                                                            </p>
                                                            <p>
                                                                {{ __('messages.pay_u_eth') }}
                                                            </p> 
                                                           
                                                            <div align="">
                                                                <a href="{{ route('btc.index', ['coin' => 'ETH']) }}" class="btn btn_blue" >
                                                                    {{ __('messages.pay_w_eth') }}
                                                                </a>
                                                            </div>                                      
                                                        </div>                                                       
                                                    </div>
                                                    @endif

                                                    @if(env('PAYSTACK_SWITCH') == 1)
                                                    <div class="col-lg-6 mt-5">                                                                   
                                                        <div class="payment_method" align="center">
                                                            <p>
                                                                <img src="https://website-v3-assets.s3.amazonaws.com/assets/img/hero/Paystack-mark-white-twitter.png" height="50px"></img> <br>
                                                            </p>
                                                            <p>
                                                                {{ __('messages.py_usng_pyst') }}
                                                            </p> 
                                                           
                                                            <div align="">
                                                                <a href="{{ route('paystack.index') }}" class="btn btn_blue" >
                                                                    {{ __('messages.pay_w_paystack') }}
                                                                </a>
                                                            </div>                                      
                                                        </div>                                                       
                                                    </div>
                                                    @endif

                                                    @if(env('BANK_DEPOSIT_SWITCH') == 1)
                                                    <div class="col-lg-6 mt-5">                                                                    
                                                        <div class="payment_method" align="center">
                                                            <p>
                                                                <i class="far fa-building fa-4x text-info"></i> <br>
                                                            </p>
                                                            <p>
                                                                {{ __('messages.py_usng_bnk_dps') }}
                                                            </p> 
                                                           
                                                            <div align="">
                                                                <a id="pay_with_bank_dep" href="javascript:void(0)" class="btn btn_blue" >
                                                                    {{ __('messages.pay_w_bank') }}
                                                                </a>
                                                            </div> 
                                                            <div id="bank_dets" align="" class="cont_display_none">
                                                                <div class="row mt-5 border border-primary rounded">              
                                                                    <div class="col-sm-12">
                                                                        <h3 class="color_blue_b">
                                                                            <i class="fas fa-money-check-alt color_blue_9"></i> {{env('ACCOUNT_NAME')}}
                                                                        </h3>
                                                                        <h4 class="text-danger">{{ __('messages.act_numb') }}: {{env('ACCOUNT_NUMBER')}}</h4>
                                                                        <h4 class="text-danger">{{ __('messages.route_iban') }}: {{env('ROUTE_IBAN_NUMBER')}}</h4>
                                                                        <h5 class="">{{ __('messages.bnk_nam') }}: {{env('BANK_NAME')}}</h5>
                                                                    </div>
                                                                </div>
                                                                <div class="row">              
                                                                    <div class="col-sm-12">
                                                                        <p class="text-danger">
                                                                           {{ __('messages.bank_pay_info') }} 
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="row">              
                                                                    <div class="col-sm-12">
                                                                        <a id="bank_deposit_cont" href="javascript:void(0)" class="btn btn_blue" >
                                                                            {{ __('messages.cont') }}
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>                                                                                               
                                                        </div>                                                       
                                                    </div>
                                                    @endif


                                                </div>                                                   
                                            @else
                                                <div class="row">
                                                    <div class="col-lg-12">                                                                       
                                                        <div class="payment_method">
                                                            <p align="Center">
                                                               <i class="fa fa-alert"></i> {{ __('messages.dpt_disble') }} 
                                                            </p>                              
                                                        </div>                                                       
                                                    </div>
                                                </div>      
                                            @endif
                                        @endif
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">{{ __('messages.dpst_hstr') }}</div>
                                </div>
                                <div class="card-body pb-0">
                                    <?php
                                        $deps = App\deposits::where('user_id', $user->id)->orderby('id', 'desc')->paginate(10);
                                    ?>                                                   
                                                
                                    <div class="table-responsive">
                                        <table class="display table table-striped table-hover" >
                                        <thead>
                                            <tr>  
                                                <th>{{ __('messages.amnt') }}</th>        
                                                <th>{{ __('messages.mthd') }}</th>
                                                <th>{{ __('messages.act') }}</th>
                                                <th>{{ __('messages.id') }}</th>
                                                <th>{{ __('messages.date') }}</th>
                                                <th>{{ __('messages.sts') }}</th>
                                                <th>{{ __('messages.url') }}</th>                                                                        
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            @if(count($deps) > 0 )
                                                @foreach($deps as $dep)
                                                    <tr> 
                                                        <td>
                                                            @if($dep->bank != 'BTC')
                                                                {{$settings->currency}} 
                                                            @endif
                                                            {{$dep->amount}}
                                                        </td>     
                                                        <td>{{$dep->bank}}</td>
                                                        <td>
                                                           {{$dep->account_no}}
                                                        </td>
                                                        <td>
                                                           {{$dep->account_name}}
                                                        </td>
                                                        <td>{{$dep->created_at}}</td>
                                                        <td>
                                                            @if($dep->status == 0)
                                                                Pending
                                                            @elseif($dep->status == 1)
                                                                Approved
                                                            @elseif($dep->status == 2)
                                                                Rejected
                                                            @endif
                                                        </td> 
                                                        <td>
                                                            @if($dep->bank == 'BTC')
                                                                @if($dep->account_name == 'Coin Base')
                                                                    <a href="{{ route('coinbase.confirm', ['id' => $dep->pop]) }}" target="_blank" class="btn btn-info">Check</a>
                                                                @elseif($dep->account_name == 'BCM')
                                                                    <a href="/{{$user->username}}/wallet" class="btn btn-info">{{__('messages.refresh')}}</a>
                                                                @else
                                                                    <a href="{{ route('btc.confirm', ['id' => $dep->account_name]) }}" target="_blank" class="btn btn-info">{{ __('messages.chck') }}</a>
                                                                @endif
                                                            @endif
                                                        </td>                                                                       
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>                                                            
                                                    <td colspan="6">{{ __('messages.no_data') }}</td>                                        
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <div>
                                        {{ $deps->links() }}
                                    </div>           
                                    <br><br>  
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
            @include('user.inc.confirm_inv')
            <div id="dep_pop" class="container dep_pop">
                <div class="row pad_5p2p">
                    <div class="col-md-4">&emps;</div>
                    <div class="col-md-4 pop_cont" align="Center">   
                        <div class="">                        
                                <span>            
                                  <a id="dep_pop_close" href="javascript:void(0)" class="btn btn-danger">{{ __('messages.cncl') }}</a>        
                                </span>
                                <br>
                            </div>
                            <div>
                                <img id="img_pop" src="" class="pop_img_h">
                            </div>
                            <br>
                        </div>  
                        <!-- close btn -->
                        <script type="text/javascript">
                          $('#dep_pop_close').click( function(){
                            $('#dep_pop').hide();
                          });        
                        </script>
                        <!-- end close btn -->
                    </div>
                </div>
            </div>

            <div id="bank_deposit_cont_dets" class="container popmsgContainer" >
                <div class="row">
                  <div class="col-md-4">&emps;</div>
                  <div class="col-md-4 popmsg-mobile card" align="Center">        
                    <div class="mt-2">
                      <h3><b>{{ __('messages.dpt_det') }}</b></h3>                              
                      <hr>
                    </div>
                    <div class="">                        
                        <form action="/user/wallet/bank_deposit" method="post">
                            <div class="form-group" align="left">                       
                                <input type="hidden" class="form-control" name="_token" value="{{csrf_token()}}">
                            </div>
                            <div class="form-group">
                              <div class="input-group">
                                <div class="input-group-prepend " >
                                  <span class="input-group-text span_bg">{{$settings->currency}}</span>
                                </div>                        
                                <input type="number" class="form-control" name="amt"  required placeholder="{{ __('messages.entr_dptd') }} " >
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="input-group" >                   
                                <div class="input-group-prepend " >
                                  <span class="input-group-text span_bg"><i class="fa fa-user" ></i></span>
                                </div>
                                <input type="text" class="form-control" name="account_name"  required placeholder="{{ __('messages.act_n_dptd') }}" >
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="input-group" >                   
                                <div class="input-group-prepend " >
                                  <span class="input-group-text span_bg"><i class="fa fa-home" ></i></span>
                                </div>
                                <input type="text" class="form-control" name="account_no"  required placeholder="{{ __('messages.act_num_dptd') }}" >
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="input-group" >                   
                                <div class="input-group-prepend" >
                                  <span class="input-group-text span_bg"><i class="fa fa-home" ></i></span>
                                </div>
                                <input type="text" class="form-control" name="bank_name"  required placeholder="{{ __('messages.bnk_snt_from') }}" >
                              </div>
                            </div>
                            <div class="form-group">
                              <br>
                                <button class="collb btn btn-info">{{ __('messages.proc') }}</button>
                                <span style="">            
                                  <a id="bank_deposit_cont_dets_close" href="javascript:void(0)" class="collcc btn btn-danger">{{ __('messages.cncl') }}</a>        
                                </span>
                                <br>
                            </div>
                        </form>
                    </div>  
                    <!-- close btn -->
                    <script type="text/javascript">
                      $('#bank_deposit_cont_dets_close').click( function(){
                        $('#bank_deposit_cont_dets').hide();
                      });        
                    </script>
                    <!-- end close btn -->
                  </div>

                </div>
            </div>            
@endSection
            