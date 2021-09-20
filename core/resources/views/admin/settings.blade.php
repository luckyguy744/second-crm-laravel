@extends('admin.atlantis.layout')
@Section('content')
        <div class="main-panel">
            <div class="content">
                @include('admin.atlantis.main_bar')
                <div class="page-inner mt--5 ">
                  <div id="prnt"></div>
                  <div class="row">
                    <div class="col-sm-12 card">
                      <form id="settings_form" action="/admin/update/site/settings" method="post">
                        <ul class="nav nav-tabs mt-5" id="myTab" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">
                              {{ __('messages.genr') }}
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">
                              {{ __('messages.dpst') }}
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">
                              {{ __('messages.wthdrwls') }}
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="referral-tab" data-toggle="pill" href="#referral" role="tab" aria-controls="pills-contact" aria-selected="false">
                              {{ __('messages.refrl') }}
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="mail_settings-tab" data-toggle="pill" href="#mail_settings" role="tab" aria-controls="pills-contact" aria-selected="false">
                              {{ __('messages.smtp') }}
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#payment_setting_tab" role="tab" aria-controls="pills-contact" aria-selected="false">
                              {{ __('messages.pymnt_mthd') }}
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="pills-widget-tab" data-toggle="pill" href="#widget_setting_tab" role="tab" aria-controls="pills-contact" aria-selected="false">
                              {{ __('messages.wdgt') }}
                            </a>
                          </li>  
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                          <div class="p-5 tab-pane fade show active" id="pills-home" role="tabpanel" >
                            <div class="form-group">                                            
                              <div class="row">                                                
                                <div class="col-md-6" align="">
                                    <h3><i class="fas fa-palette"></i> {{ __('messages.hedr_clr') }} </h3>
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <input id="input_hcolor" value="{{$settings->header_color}}" class="p-0 color_picker float-left with_50per" type="color"  name="hcolor" required >
                                </div>                                   
                                <div class="col-md-6" align="">
                                    <h3><i class="fas fa-palette"></i> {{ __('messages.fotr_clr') }} </h3>
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <input id="input_fcolor" value="{{$settings->footer_color}}" class="p-0 color_picker float-left with_50per" type="color"  name="fcolor" required >
                                </div>                                                
                              </div>
                              <br><br>
                              <hr>
                              <div class="row margin_top50"> 
                                  <div class="col-md-6">
                                      <h3><i class="fab fa-centercode"></i> {{ __('messages.ste_lgo') }} </h3>
                                      <input type="file" name="siteLogo" class=" btn btn-info border_none" >
                                  </div>                                               
                                  <div class="col-md-6" align="center"> 
                                        <img src="/img/{{$settings->site_logo}}" alt="Logo" class="height_50" align="center" >
                                  </div>                                                
                              </div>
                              <br><br>
                              <hr>

                              <div class="row margin_top50"> 
                                  <div class="col-md-6">
                                      <h3><i class="fas fa-thumbtack"></i> {{ __('messages.ste_ttl') }} </h3>
                                      <input type="text" name="siteTitle" value="{{$settings->site_title}}" class="form-control"  required >
                                  </div> 
                                  <div class="col-md-6">
                                      <h3><i class="fas fa-pen"></i> {{ __('messages.ste_dscrpt') }} </h3>
                                      <input type="text" name="siteDescr" value="{{$settings->site_descr}}" class="form-control"  required>
                                  </div>  
                              </div>
                              <div class="row margin_top50">
                               <div class="col-md-8">
                                      <h3><i class="fas fa-envelope"></i> {{ __('messages.sppt_emil') }} </h3>
                                      <input type="text" name="supEmail" value="{{env('SUPPORT_EMAIL')}}" class="form-control" required>
                                  </div>
                              </div>
                              <br>
                              <div class="row margin_top50"> 
                                <div class="col-md-4">
                                    <h3><i class="fas fa-hand-holding-usd"></i> {{ __('messages.enbl_invstm') }}  </h3>
                                </div>                                               
                                <div class="col-md-8" align="right">
                                    <b>{{ __('messages.on_off') }} </b><br>               
                                    <label class="switch">
                                      <input id="inv" type="checkbox" name="inv"  value="{{$settings->investment}}" @if($settings->investment == 1){{('checked')}}@endif>
                                      <span id="" class="slider round" onclick="checkedOnOff('inv')"></span>
                                    </label> 
                                </div>                                                
                              </div>

                              <div class="row margin_top50"> 
                                  <div   class="col-md-4">
                                      <h3> <i class="fas fa-user"></i> {{ __('messages.enbl_usr_reg') }} </h3>
                                  </div>                                               
                                  <div class="col-md-8" align="right">
                                      <b>{{ __('messages.on_off') }}</b><br>               
                                      <label class="switch">
                                        <input id="reg" type="checkbox" name="reg" value="{{$settings->user_reg}}" @if($settings->user_reg == 1){{('checked')}}@endif>
                                        <span id="" class="slider round" onclick="checkedOnOff('reg')"></span>
                                      </label> 
                                  </div>                                                
                              </div>

                              <div class="row margin_top50"> 
                                <div class="col-md-4">
                                    <h3><i class="fas fa-paper-plane"></i> {{ __('messages.enable_usr_tran') }}  </h3>
                                </div>                                               
                                <div class="col-md-8" align="right">
                                    <b>{{ __('messages.on_off') }} </b><br>               
                                    <label class="switch">
                                      <input id="user_trans" type="checkbox" name="user_trans"  value="{{$settings->user_transfer}}" @if($settings->user_transfer == 1){{('checked')}}@endif>
                                      <span id="" class="slider round" onclick="checkedOnOff('user_trans')"></span>
                                    </label> 
                                </div>                                                
                              </div>

                              <br><br>
                              <hr>
                              <div class="row margin_top50">                                                                                               
                                  <div class="col-md-12">
                                      <h3><i class="fa fa-money-bill-wave"></i> {{ __('messages.curncy_sett') }} </h3>
                                  </div>
                                  <div   class="col-md-6 ">
                                      <div class="card pad_20" >
                                          <h5> {{ __('messages.curncy_code') }} </h5>
                                          <input type="text" name="cur" value="{{$settings->currency}}" class="form-control" required >
                                      </div>
                                  </div> 
                                  <div   class="col-md-6">
                                      <div class="card form-group pad_20" >
                                          <h5> {{ __('messages.curncy_rte') }} </h5>
                                          <input type="text" name="cur_conv" value="{{$settings->currency_conversion}}" class="form-control"  required >
                                      </div>
                                  </div>                                            
                              </div>

                            </div>
                          </div>

                          <div class="p-5 tab-pane fade" id="pills-profile" role="tabpanel" >
                            <div class="row"> 
                                <div class="col-md-6">
                                    <h5> {{ __('messages.min_dpt_set').$settings->currency.__('messages.close_brkt') }} </h5>
                                    <input type="number" name="min_dep" value="{{env('MIN_DEPOSIT')}}" class="form-control"  step="0.01" required>
                                </div>
                                <div class="col-md-6">
                                    <h5> {{ __('messages.max_dep_set').$settings->currency.__('messages.close_brkt') }} </h5>
                                    <input type="number" name="max_dep" value="{{env('MAX_DEPOSIT')}}" class="form-control"  step="1" required>
                                </div> 
                                <div class="col-md-12 mt-3" align="right"> 
                                    <b>{{ __('messages.on_off') }}</b><br>             
                                    <label class="switch">
                                    <input id="wallet" type="checkbox" name="wallet"  value="{{$settings->deposit}}" @if($settings->deposit == 1){{'checked'}}@endif>
                                      <span id="" class="slider round" onclick="checkedOnOff('wallet')"></span>
                                    </label>
                                </div>                                       
                            </div>
                          </div>

                          <div class="p-5 tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">                            
                            <div class="row"> 
                              <div class="col-sm-6">
                                <h5> {{ __('messages.min_wdwal') }} </h5>
                                <input type="number" name="min_wd" value="{{env('MIN_WD')}}" class="form-control" >
                              </div>
                              <div class="col-sm-6">
                                <h5> {{ __('messages.wd_limit') }} </h5>
                                <input type="number" name="wd_limit" value="{{env('WD_LIMIT')}}" class="form-control" >
                              </div> 
                                                                    
                              <div class="col-sm-12 mt-3">
                                <h5> {{ __('messages.wd_fee') }} </h5>
                                <input type="number" name="wd_fee" value="{{env('WD_FEE')*100}}" class="form-control" >
                              </div> 
                                                                                                         
                              <div class="col-md-12 mt-2" align="right">
                                <b>{{ __('messages.on_off') }}</b><br>               
                                <label class="switch">
                                  <input id="wd" type="checkbox" name="wd" value="{{$settings->withdrawal}}" @if($settings->withdrawal == 1){{'checked'}}@endif>
                                  <span id="" class="slider round" onclick="checkedOnOff('wd')"></span>
                                </label> 
                              </div> 
                            </div>                                              
                          </div>

                          <div class="tab-pane fade p-5" id="referral" role="tabpanel" aria-labelledby="referral-tab">
                            
                            <div class="row ">                                 
                                <div class="col-sm-6">
                                    <h5></i> {{ __('messages.ref_sys') }} </h5>
                                       <select id="referal_system" class="form-control" name="referal_system" >
                                        @if(env('REF_SYSTEM') == 'Single_level' )
                                            <option value="Single_level" selected>{{ __('messages.disabled') }}</option>
                                            <option value="Multi_level">{{ __('messages.enabled') }}</option>
                                        @else
                                            <option value="Single_level">{{ __('messages.disabled') }}</option>
                                            <option value="Multi_level" selected>{{ __('messages.enabled') }}</option>
                                        @endif
                                    </select>                                   
                                </div>
                                
                                <div class="col-sm-6">
                                    <h5></i> {{ __('messages.referral_type') }} </h5>
                                     <select class="form-control" name="referal_type" >
                                        @if(env('REF_TYPE') == 'Once')
                                            <option value="Once" selected>{{ __('messages.ref_once_ivt') }}</option>
                                            <option value="Continous">{{ __('messages.ref_cont_ivt') }}</option>
                                        @else
                                            <option value="Once">{{ __('messages.ref_once_ivt') }}</option>
                                            <option value="Continous" selected>{{ __('messages.ref_cont_ivt') }}</option>
                                        @endif
                                    </select> 
                                </div>

                            </div>

                            <div id="Multi_level_settings" class="@if(env('REF_SYSTEM') != 'Multi_level'){{__('cont_display_none')}}@endif">
                              <div class="row mt-5">
                                  <div class="col-sm-6">                                    
                                    <h6> {{ __('messages.ref_lvl') }} </h6>
                                    <input type="number" name="referal_levels" value="{{env('REF_LEVEL_CNT')}}" class="form-control" onkeyup="set_inputs(this.value)" > 
                                    <small class="font_11">{{ __('messages.entr_1_single') }} </small>

                                  </div>                                                 
                              </div> 

                              <div id="warning_div" class="row mt-5">
                                <div class="col-sm-12 alert alert-warning text-center">{{ __('messages.entr_ref_per') }} </div>
                              </div> 

                              <div id="referal_levels_div" class="row mt-5 ">                                                 
                                @php($ref_set = get_ref_set())
                                @foreach($ref_set as $ref_item)
                                  <div class="col-sm-6">
                                      <div class="form-group">
                                          <h6> {{ __('messages.lvl').$ref_item->name}} {{ __('messages.percentage') }} </h6>
                                          <input type="number" step="any" name="{{$ref_item->name}}" value="{{$ref_item->val*100}}" class="form-control" >
                                      </div>
                                  </div>
                                @endforeach                                           
                              </div>
                            </div>
                          </div>

                          <div class="p-5 tab-pane fade" id="mail_settings" role="tabpanel" aria-labelledby="mail_settings-tab">
                            <div class="row "> 
                              <div class="col-sm-12">
                                  <h2 class=""><i class="fas fa-envelope"></i> {{ __('messages.mail_setup') }}</h2>
                              </div>
                              <div   class="col-md-6 ">
                                  <div class="card pad_20">
                                      <br>
                                      <div class="form-group">
                                          <h5> {{ __('messages.mail_host') }} </h5>
                                          <input type="text" name="m_host" value="{{env('MAIL_HOST')}}" class="form-control"  >
                                      </div>
                                      <div class="form-group">
                                          <h5> {{ __('messages.mail_port') }} </h5>
                                          <input type="text" name="m_port" value="{{env('MAIL_PORT')}}" class="form-control"  >
                                      </div>
                                      <div class="form-group">
                                          <h5> {{ __('messages.mail_sender') }} </h5>
                                          <input type="text" name="m_sender" value="{{env('APP_URL')}}" class="form-control" >
                                      </div>
                                  </div>
                              </div> 
                              <div   class="col-md-6 ">
                                  <div class="card pad_20">
                                      <br>
                                      <div class="form-group">
                                          <h5> {{ __('messages.mail_username') }} </h5>
                                          <input type="text" name="m_user" value="{{env('MAIL_USERNAME')}}" class="form-control"  >
                                      </div>
                                      <div class="form-group">
                                          <h5> {{ __('messages.mail_pwd') }} </h5>
                                          <input type="password" name="m_pwd" value="{{env('MAIL_PASSWORD')}}" class="form-control" >
                                      </div>
                                      <div class="form-group">
                                          <h5> {{ __('messages.mail_encryp') }} </h5>
                                          <input type="text" name="m_enc" value="{{env('MAIL_ENCRYPTION')}}" class="form-control" >
                                      </div>
                                  </div>
                              </div>
                            </div>                                           
                          </div>

                          <div class="p-5 tab-pane fade" id="payment_setting_tab" role="tabpanel" aria-labelledby="payment_setting_tab-tab">
                            <div class="row ">                               
                              <div   class="col-md-6 ">
                                  <div class="card pad_20">
                                      <h3 align="center"><i class="fab fa-cc-paypal fa-3x"></i></h3>
                                      <h2 class="text-center">{{ __('messages.paypal_setup') }} </h2>
                                      <hr>
                                      <div class="form-group">
                                          <h5> {{ __('messages.paypal_id') }} </h5>
                                          <input type="text" name="paypal_ID" value="{{$settings->paypal_ID}}" class="form-control" >
                                      </div>
                                      <div class="form-group">
                                          <h5> {{ __('messages.paypal_secrete') }} </h5>
                                          <input type="text" name="paypal_secret" value="{{$settings->paypal_secret}}" class="form-control"  >
                                      </div>
                                      <div class="form-group">
                                          <h5> {{ __('messages.Mode') }} </h5>
                                          <select class="form-control" name="paypal_mode" >
                                              <option value="sandbox">{{ __('messages.sandbox') }}</option>
                                              <option value="live">{{ __('messages.live') }}</option>
                                          </select> 
                                      </div>
                                      <div class="" align="right"> 
                                          <b>{{ __('messages.on_off') }}</b><br>             
                                          <label class="switch">
                                            <input id="switch_paypal" type="checkbox" name="switch_paypal"  value="{{env('SWITCH_PAYPAL')}}" @if(env('SWITCH_PAYPAL') == 1){{'checked'}}@endif>
                                            <span id="" class="slider round" onclick="checkedOnOff('switch_paypal')"></span>
                                          </label>
                                      </div>  
                                      
                                  </div>
                              </div> 
                              <div   class="col-md-6">
                                  <div class="card pad_20" >
                                      <h3 align="center"><i class="fab fa-cc-stripe fa-3x"></i></h3>
                                      <h2 class="text-center">{{ __('messages.stripe_setup') }}</h2>
                                      <hr>
                                      <div class="form-group">
                                          <h5> {{ __('messages.stripe_key') }} </h5>
                                          <input type="text" name="stripe_key" value="{{$settings->stripe_key}}" class="form-control"   >
                                      </div>
                                      <div class="form-group">
                                          <h5> {{ __('messages.stripe_secrete') }} </h5>
                                          <input type="text" name="stripe_secret" value="{{$settings->stripe_secret}}" class="form-control"  >
                                      </div>   
                                      <div class="" align="right"> 
                                          <b>{{ __('messages.on_off') }}</b><br>             
                                          <label class="switch">
                                            <input id="switch_stripe" type="checkbox" name="switch_stripe"  value="{{env('SWITCH_STRIPE')}}" @if(env('SWITCH_STRIPE') == 1){{'checked'}}@endif>
                                            <span id="" class="slider round" onclick="checkedOnOff('switch_stripe')"></span>
                                          </label>
                                      </div>                                                     
                                  </div>                                                   
                              </div>  
                              
                              <div class="col-md-6">
                                  <div class="card pad_20" >
                                      <h3 align="center"><i class="far fa-building fa-3x"></i></h3>
                                      <h2 class="text-center">{{ __('messages.bank_dep_set') }}</h2>
                                      <hr>
                                      <div class="form-group">
                                          <h5> {{ __('messages.bnk_nam') }} </h5>
                                          <input type="text" name="bank_name" value="{{env('BANK_NAME')}}" class="form-control" placeholder=""  >
                                      </div>
                                      <div class="form-group">
                                          <h5> {{ __('messages.act_nam') }} </h5>
                                          <input type="text" name="act_name" value="{{env('ACCOUNT_NAME')}}" class="form-control" placeholder="" >
                                      </div>  
                                      <div class="form-group">
                                          <h5> {{ __('messages.act_numb') }} </h5>
                                          <input type="number" name="act_no" value="{{env('ACCOUNT_NUMBER')}}" class="form-control" placeholder="" >
                                      </div> 
                                      <div class="form-group">
                                          <h5> {{ __('messages.route_iban') }} </h5>
                                          <input type="number" name="route_iban" value="{{env('ROUTE_IBAN_NUMBER')}}" class="form-control" placeholder="" >
                                      </div> 
                                      <div class="form-group">
                                          <h5> {{ __('messages.resp_email') }} </h5>
                                          <input type="email" name="dep_email" value="{{env('BANK_DEPOSIT_EMAIL')}}" class="form-control" placeholder="" >
                                      </div>  
                                      <div class="" align="right"> 
                                          <b>{{ __('messages.on_off') }}</b><br>             
                                          <label class="switch">
                                            <input id="switch_bank_deposit" type="checkbox" name="switch_bank_deposit"  value="{{env('BANK_DEPOSIT_SWITCH')}}" @if(env('BANK_DEPOSIT_SWITCH') == 1){{'checked'}}@endif>
                                            <span id="" class="slider round" onclick="checkedOnOff('switch_bank_deposit')"></span>
                                          </label>
                                      </div>                                                     
                                  </div>                                                   
                              </div>  
                              <div class="col-md-6">
                                  <div class="card pad_20" >
                                      <h3 align="center"><i class="fab fa-bitcoin fa-3x"></i></h3>
                                      <h2 class="text-center">{{ __('messages.cp_setup') }} </h2>
                                      <hr>
                                      <div class="form-group">
                                          <h5> {{ __('messages.cp_mer_id') }} </h5>
                                          <input type="text" name="cp_m_id" value="{{env('COINPAYMENTS_MERCHANT_ID')}}" class="form-control" placeholder=""  >
                                      </div>  
                                      <div class="form-group">
                                          <h5> {{ __('messages.cp_pub_key') }} </h5>
                                          <input type="text" name="cp_p_key" value="{{env('COINPAYMENTS_PUBLIC_KEY')}}" class="form-control" placeholder=""  >
                                      </div>
                                      <div class="form-group">
                                          <h5> {{ __('messages.cp_pri_key') }} </h5>
                                          <input type="text" name="cp_pr_key" value="{{env('COINPAYMENTS_PRIVATE_KEY')}}" class="form-control" placeholder=""  >
                                      </div>
                                      <div class="form-group">
                                          <h5> {{ __('messages.cp_ipn_secr') }} </h5>
                                          <input type="text" name="cp_ipn_secret" value="{{env('COINPAYMENTS_IPN_SECRET')}}" class="form-control" placeholder=""  >
                                      </div>
                                      <div class="form-group">
                                          <h5> {{ __('messages.cp_ipn_url') }} </h5>
                                          <input type="text" name="cp_ipn_url" value="{{env('COINPAYMENTS_IPN_URL')}}" class="form-control" placeholder=""  >
                                      </div>
                                      
                                      <div class="" align="right"> 
                                          <b>{{ __('messages.on_off') }} Bitcoin </b><br>             
                                          <label class="switch">
                                            <input id="switch_BTC" type="checkbox" name="switch_BTC"  value="{{env('SWITCH_BTC')}}" @if(env('SWITCH_BTC') == 1){{'checked'}}@endif>
                                            <span id="" class="slider round" onclick="checkedOnOff('switch_BTC')"></span>
                                          </label>
                                      </div> 

                                      <div class="" align="right"> 
                                          <b> {{ __('messages.on_off') }} Ethereum </b><br>             
                                          <label class="switch">
                                            <input id="switch_ETH" type="checkbox" name="switch_ETH"  value="{{env('SWITCH_ETH')}}" @if(env('SWITCH_ETH') == 1){{'checked'}}@endif>
                                            <span id="" class="slider round" onclick="checkedOnOff('switch_ETH')"></span>
                                          </label>
                                      </div> 

                                  </div>                                                   
                              </div> 

                              <div class="col-md-6">
                                <div class="card pad_20" >
                                    <h3 align="center">
                                      <img align="center" src="/img/coinbase.png" class="img-responsive" style="width: 45%;">
                                    </h3>
                                    <h2 class="text-center">{{ __('messages.coinbase_setup') }}</h2>
                                    <hr>
                                    <div class="form-group">
                                        <h5> {{ __('messages.coinbase_Key') }} </h5>
                                        <input type="text" name="coinbase_key" value="{{ env('COINBASE_API_KEY') }}" class="form-control"   >
                                    </div>
                                    <div class="form-group">
                                        <h5> {{ __('messages.cb_wh_secret') }} </h5>
                                        <input type="text" name="coinbase_seceret" value="{{ env('COINBASE_WEBHOOK_SECRETE') }}" class="form-control" >
                                    </div>
                                    <div class="" align="right"> 
                                        <b>{{ __('messages.on_off') }}</b><br>             
                                        <label class="switch">
                                          <input id="coinbase_switch" type="checkbox" name="coinbase_switch"  value="{{ env('COINBASE_SWITCH') }}" @if(env('COINBASE_SWITCH') == 1){{'checked'}}@endif>
                                          <span id="" class="slider round" onclick="checkedOnOff('coinbase_switch')"></span>
                                        </label>
                                    </div>                                                     
                                </div>                                                   
                              </div> 
                              
                              <div class="col-md-6">
                                  <div class="card pad_20" >
                                      <h3 align="center">
                                        <img align="center" src="/img/bcimg.png" class="img-responsive" style="width: 100px; height: 100px;">
                                      </h3>
                                      <h2 class="text-center">{{ __('messages.bc_card_ttl') }}</h2>
                                      <hr>
                                      <div class="form-group">
                                          <h5> {{ __('messages.bc_secrete') }} </h5>
                                          <input type="text" name="bc_secrete" value="{{ env('BCM_SECRETE') }}" class="form-control"   >
                                      </div>
                                      <div class="form-group">
                                          <h5> {{ __('messages.bc_xpub') }} </h5>
                                          <input type="text" name="bc_xpub" value="{{ env('BC_MY_XPUB') }}" class="form-control"   >
                                      </div>
                                      <div class="form-group">
                                          <h5> {{ __('messages.bc_api_key') }} </h5>
                                          <input type="text" name="bc_api_key" value="{{ env('BC_MY_API_KEY') }}" class="form-control" >
                                      </div>
                                      
                                      <div class="" align="right"> 
                                          <b>{{ __('messages.on_off') }}</b><br>             
                                          <label class="switch">
                                            <input id="bc_switch" type="checkbox" name="bc_switch"  value="{{ env('BC_SWITCH') }}" @if(env('BC_SWITCH') == 1){{'checked'}}@endif>
                                            <span id="" class="slider round" onclick="checkedOnOff('bc_switch')"></span>
                                          </label>
                                      </div>                                                     
                                  </div>                                                   
                              </div> 


                              <div class="col-md-6">
                                  <div class="card pad_20" >
                                      <h3 align="center"><img src="https://website-v3-assets.s3.amazonaws.com/assets/img/hero/Paystack-mark-white-twitter.png" height="60px"></img></h3>
                                      <h2 class="text-center">{{ __('messages.paystack_setup') }}</h2>
                                      <hr>
                                      <div class="form-group">
                                          <h5> {{ __('messages.paystk_pub_key') }} </h5>
                                          <input type="text" name="paystack_pub_key" value="{{ env('PAYSTACK_PUBLIC_KEY') }}" class="form-control" >
                                      </div>
                                      <div class="form-group">
                                          <h5> {{ __('messages.paystk_sec_key') }} </h5>
                                          <input type="text" name="paystack_secret" value="{{ env('PAYSTACK_SECRET_KEY') }}" class="form-control"  >
                                      </div>  
                                      <div class="form-group">
                                          <h5> {{ __('messages.paystk_mer_email') }} </h5>
                                          <input type="email" name="paystack_email" value="{{ env('MERCHANT_EMAIL') }}" class="form-control"  >
                                      </div>
                                      <div class="form-group">
                                          <h5> {{ __('Paystack Callback URL') }}</h5>
                                          <input type="text" name="" value="{{ env('APP_URL') }}/paystack/callbck" class="form-control" readonly>
                                      </div>
                                      <div class="" align="right"> 
                                          <b>{{ __('messages.on_off') }}</b><br>             
                                          <label class="switch">
                                            <input id="paystack_switch" type="checkbox" name="paystack_switch"  value="{{ env('PAYSTACK_SWITCH') }}" @if(env('PAYSTACK_SWITCH') == 1){{'checked'}}@endif>
                                            <span id="" class="slider round" onclick="checkedOnOff('paystack_switch')"></span>
                                          </label>
                                      </div>                                                     
                                  </div>                                                   
                              </div> 

                              <div class="col-md-6">
                                <div class="card pad_20" >
                                    <h3 align="center">
                                      <img align="center" src="/img/payeer.png" class="img-responsive" style="width: 45%;">
                                    </h3>
                                    <h2 class="text-center">{{ __('messages.payr_setup') }} </h2>
                                    <hr>
                                    <div class="form-group">
                                        <h5> {{ __('messages.payr_mer_id') }} </h5>
                                        <input type="text" name="payeer_id" value="{{ env('PAYEER_MID') }}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <h5> {{ __('messages.payr_secret') }} </h5>
                                        <input type="text" name="payeer_key" value="{{ env('PAYEER_KEY') }}" class="form-control">
                                    </div>
                                    <div class="" align="right"> 
                                        <b>{{ __('messages.on_off') }}</b><br>             
                                        <label class="switch">
                                          <input id="payeer_switch" type="checkbox" name="payeer_switch"  value="{{ env('PAYEER_SWITCH') }}" @if(env('PAYEER_SWITCH') == 1){{'checked'}}@endif>
                                          <span id="" class="slider round" onclick="checkedOnOff('payeer_switch')"></span>
                                        </label>
                                    </div>                                                     
                                </div>                                                   
                              </div> 

                              <div class="col-md-6">
                                <div class="card pad_20" >
                                    <h3 align="center">
                                      <img align="center" src="http://www.deminetsolution.biz/slides/slide4.jpg" class="img-responsive" style="width: 50%;">
                                    </h3>
                                    <h2 class="text-center">{{ __('messages.pm_setup') }}</h2>
                                    <hr>
                                    <div class="form-group">
                                        <h5> {{ __('messages.pm_act_id') }} </h5>
                                        <input type="text" name="pm_id" value="{{ env('PM_ACCOUNT') }}" class="form-control" placeholder="Perfect Account ID"  >
                                    </div>
                                    <div class="form-group">
                                        <h5> {{ __('messages.pm_comp_name') }} </h5>
                                        <input type="text" name="pm_name" value="{{ env('PM_COMPANY') }}" class="form-control" placeholder="Your Company Title" >
                                    </div>
                                    <div class="" align="right"> 
                                        <b>{{ __('messages.on_off') }}</b><br>             
                                        <label class="switch">
                                          <input id="pm_switch" type="checkbox" name="pm_switch"  value="{{ env('PM_SWITCH') }}" @if(env('PM_SWITCH') == 1){{'checked'}}@endif>
                                          <span class="slider round" onclick="checkedOnOff('pm_switch')"></span>
                                        </label>
                                    </div>                                                     
                                </div>                                                   
                              </div> 

                            </div>

                          </div>

                          <div class="p-5 tab-pane fade" id="widget_setting_tab" role="tabpanel" aria-labelledby="widget_setting_tab-tab">
                            <div class="row ">                               
                              <div   class="col-md-12 ">
                                  <div class="card pad_20">
                                      <h3><i class="fa fa-code fa-3x"></i>{{ __('messages.chat_wdget') }} </h3> 
                                      <!-- <h2 class="">Chat Widget</h2> -->
                                      <hr>
                                      <div class="form-group">
                                          <h5> {{ __('messages.wdget_insrt') }} </h5>
                                          <textarea name="chat_widget" class="form-control" rows="20" placeholder="Paste your widget code here" style="background-color: #EEE; border: 3px solid #999">@if($settings->chat_widget != null || $settings->chat_widget != ''){{$settings->chat_widget}}@endif</textarea>
                                      </div>                                      
                                  </div>
                              </div> 
                              
                            </div>

                          </div>

                        </div>

                        <div class="row margin_top50 mb-5"> 
                          <div   class="col-md-12">
                            <button class="btn btn-info float-right" onclick="load_post_ajax('/admin/update/site/settings', 'settings_form', 'admin_settings_form' )" > 
                              {{ __('messages.save_settings') }} 
                            </button>
                          </div>                                     
                        </div>

                      </form>                      
                    </div>
                  </div>

                  <div class="row "> 
                    <div class="col-md-6">
                      <div class="card pad_20">
                          <div class="form-group">
                            <h4>{{ __('messages.add_lang') }} </h4>
                          </div>
                          <hr>
                          <form action="{{route('add_lang')}}" method="post">
                            <div class="form-group">
                                <h5> {{ __('messages.lang_name') }} </h5>
                                <input type="text" name="lang_name" value="" required class="form-control"  >
                            </div>
                            <div class="form-group">
                                <h5> {{ __('messages.lang_abbr') }} </h5>
                                <input type="text" name="lang_code" value="" required class="form-control" >
                            </div>
                            <div class="form-group">                                          
                              <button class="btn btn-info">{{ __('messages.add') }}</button>
                            </div>
                          </form>                                          
                      </div>                                
                    </div>
                    <div class="col-md-6">
                      <div class="card pad_20">                                              
                        <table id="" class=" table table-stripped table-hover">
                            <thead>
                                <tr>                
                                    <th> {{ __('messages.lang_name') }} </th>
                                    <th> {{ __('messages.lang_abbr') }} </th>
                                    <th> {{ __('messages.actn') }} </th>   
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                    $activities = $lang;
                                ?>
                                @if(count($activities) > 0 )
                                    @foreach($activities as $activity)
                                        <tr>                                                            
                                            <td>{{$activity->lang_name}}</td>
                                            <td>{{$activity->lang_code}}</td>
                                            <td>
                                                <a class="btn btn-danger" href="{{route('lang_del', ['id' => $activity->id])}}"><i class="fa fa-times"></i></a>
                                            </td>                    
                                        </tr>
                                    @endforeach
                                @else
                                    
                                @endif
                            </tbody>
                        </table>                                        
                      </div>                                
                    </div>                               
                  </div>

                </div>

            </div>
@endSection