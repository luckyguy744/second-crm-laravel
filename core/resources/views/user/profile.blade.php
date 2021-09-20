@include('user.inc.fetch')
@extends('layouts.atlantis.layout')
@Section('content')
        <div class="main-panel">
            <div class="content">
                @php($breadcome = 'My Profile')
                @include('user.atlantis.main_bar')
                <div class="page-inner mt--5">
                    @include('user.atlantis.overview')
                    <div id="prnt"></div>
                    <div class="row">
                       <div class="col-sm-12 card">
                        
                          <ul class="nav nav-tabs mt-5" id="myTab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="profile-tab" data-toggle="pill" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Profile</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="bank-tab" data-toggle="pill" href="#bank" role="tab" aria-controls="bank" aria-selected="false">Banks</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="wallet-tab" data-toggle="pill" href="#wallet" role="tab" aria-controls="wallet" aria-selected="false">Wallets</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="kyc-tab" data-toggle="pill" href="#kyc" role="tab" aria-controls="kyc" aria-selected="false">KYC</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="sec-tab" data-toggle="pill" href="#sec" role="tab" aria-controls="sec" aria-selected="false">Security</a>
                            </li>
                                                        
                          </ul>

                          <div class="tab-content" id="pills-tabContent">

                            <!-- profile panel -->

                            <div class="p-5 tab-pane fade show active" id="profile" role="tabpanel" >
                              <div class=" row form-group">                                            
                                                                                                                             
                                <div class="col-md-4">
                                  <div class="card">
                                      <div class="card-header">
                                          <div class="card-head-row">
                                              <div class="card-title text-center">{{ __('Avatar') }}</div>
                                              <div class="card-tools">                                            
                                              </div>
                                          </div>
                                      </div>
                                      <div class="card-body">
                                          <div class="chart-container">
                                              <div class="comment-phara">
                                                  <div class="comment-adminpr" align="center">
                                                      <a id="selectPic" href="javascript:void(0)"  >
                                                          @if($user->img == "")
                                                              <img class="avatar_img" src="/img/any.png">
                                                          @else
                                                              <img class="avatar_img" src="/img/profile/{{ $user->img }}">
                                                          @endif
                                                      </a> 

                                                      <form id="form_profilepic" action="/user/upload/profile_pic" method="post" enctype="multipart/form-data">
                                                          <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                          <input type="file" name="prPic" id="prPic" class="display_not">
                                                      </form>
                                                  </div>
                                                  <br>
                                                  
                                              </div>
                                              <div class="admin-comment-month" align="left" style="font-size: 16px;">
                                                  
                                                  <div align="center"><b> {{ucfirst($user->firstname).' '.ucfirst($user->lastname)}} </b></div>
                                                  <hr>

                                                  <?php
                                                      $country = App\country::find($user->country);
                                                      $state = App\states::find($user->state);
                                                  ?>

                                                  <div align="center" style="">
                                                      <b>Referral link:</b><br>
                                                      <div style="color: #c60; font-size: 13px; word-wrap: break-word;">
                                                          {{env('APP_URL').__('/register/').$user->username}}
                                                      </div>
                                                      <br>                                               
                                                  </div>
                                                                                 
                                              </div>
                                          </div>                                    
                                      </div>
                                  </div>                                  
                                </div>

                                <div class="col-md-8">                            
                                  <div class="card">
                                      <div class="card-header">
                                          <div class="card-head-row">
                                              <div class="card-title">{{ __('Profile Settings') }}</div>
                                              <div class="card-tools">                                            
                                              </div>
                                          </div>
                                      </div>
                                      <div class="card-body pb-0">
                                          <div class="datatable-dashv1-list custom-datatable-overright dashtwo-project-list-data">
                                            
                                              <div class="row">
                                                  <div class="col-lg-6">
                                                      <div class="form-group">
                                                          <label>{{ __('First Name') }}</label>
                                                          <input id="adr" type="text" value="{{ucfirst($user->firstname)}}" class="form-control" name="fname" readonly>
                                                      </div>
                                                  </div>  
                                                  <div class="col-lg-6">
                                                      <div class="form-group">
                                                          <label>{{ __('Last Name') }}</label>
                                                          <input id="adr" type="text" value="{{ucfirst($user->lastname)}}" class="form-control" name="lname" readonly>
                                                      </div>
                                                  </div>                               
                                                  
                                              </div>

                                              <div class="row">
                                                  <div class="col-lg-6">
                                                      <div class="form-group">
                                                          <label>{{ __('Email Address') }}</label>
                                                          <div class="input-group">                                                       
                                                              <input id="email" type="email" value="{{$user->email}}" class="form-control" name="email" readonly>
                                                          </div>
                                                          
                                                      </div>
                                                  </div>     

                                                  <div class="col-lg-6">
                                                      <div class="form-group">
                                                          <label>{{ __('Username') }}</label>
                                                          <div class="input-group">                                                       
                                                              <input id="usn" type="text" value="{{$user->username}}" class="form-control" name="usn" readonly>
                                                          </div>
                                                          
                                                      </div>
                                                  </div>                                             
                                                  
                                              </div>   

                                              <form class="" method="post" action="/user/update/profile">
                                                  
                                                  <div class="row">
                                                      <div class="col-lg-6">
                                                          <div class="form-group">
                                                              <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                              <label>{{ __('Country') }}</label>
                                                              <select id="country" class="form-control" name="country" >
                                                                  <?php 
                                                                      $country = App\country::orderby('name', 'asc')->get();
                                                                      $phn_code = "";
                                                                  ?>
                                                                  @foreach($country as $c)
                                                                          @if($c->id == $user->country)
                                                                              @php($cs = $c->id)
                                                                              @php($phn_code = $c->phonecode)
                                                                              {{'selected'}}
                                                                              <option selected  value="{{$c->id}}">{{$c->name}}</option>
                                                                          @else
                                                                              <option value="{{$c->id}}">{{$c->name}}</option>
                                                                          @endif
                                                                  @endforeach
                                                                  @if(!isset($cs))
                                                                          <option selected disabled>{{ __('Select Country') }}</option>
                                                                  @endif

                                                              </select>
                                                          </div>
                                                      </div>
                                                      <div class="col-lg-6">
                                                           <div class="form-group">
                                                              <label>{{ __('State/Province') }}</label>
                                                              <select  id="states" class="form-control" name="state" required>
                                                                  @if(isset($cs))
                                                                       <?php 
                                                                          $st = App\states::where('id', $user->state)->get();
                                                                      ?>
                                                                      @if(count($st) > 0)
                                                                          <option selected value="{{$st[0]->id}}">{{$st[0]->name}}</option>
                                                                      @else
                                                                          <option selected disabled>{{ __('Select State') }}</option>
                                                                      @endif
                                                                      
                                                                  @else
                                                                     <option selected disabled>{{ __('Select State') }}</option>
                                                                  @endif                                                           
                                                              </select>                                                        
                                                          </div>
                                                      </div>

                                                  </div>
                                                  <div class="row">
                                                      <div class="col-lg-6">
                                                          <div class="form-group">
                                                              <label>{{ __('Address') }}</label>
                                                              <input id="adr" type="text" class="form-control" value="{{$user->address}}" name="adr" required>
                                                          </div>
                                                      </div>  

                                                      <div class="col-lg-6">
                                                          <div class="form-group">
                                                              <label>{{ __('Phone') }}</label>
                                                              <div class="input-group">
                                                                  <div class="input-group-prepend">
                                                                      <span id="countryCode" class="input-group-text">
                                                                          @if(isset($phn_code))
                                                                              {{'+'.$phn_code}}
                                                                          @else
                                                                              
                                                                          @endif
                                                                      </span>
                                                                  </div>                                                            
                                                                  <input id="cCode" type="hidden" class="form-control" name="cCode" required>
                                                                  <input id="phone" type="text" class="form-control" value="{{str_replace('+'.$phn_code,'',$user->phone)}}" name="phone" required>
                                                              </div>
                                                              
                                                          </div>
                                                      </div>  
                                                  </div>   
                                                  <div class="row">
                                                      <div class="col-lg-12">
                                                          <div class="form-group">
                                                              <button  class="collcc btn btn-info">{{ __('Update Profile') }}</button>
                                                          </div>
                                                      </div>                                                
                                                      
                                                  </div>
                                              </form>
                                          </div>                                
                                      </div>
                                  </div>
                                </div>

                              </div>
                            </div>

                            <!-- end of profile panel -->

                            <!-- Banks panel -->

                            <div class="p-5 tab-pane fade " id="bank" role="tabpanel" >
                              <div class="row form-group">
                                <div class="col-sm-12">
                                  <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">{{ __('Add Bank Details') }}</div>
                                    </div>
                                    <div class="card-body">
                                        <form class="" method="post" action="/user/add/bank">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>{{ __('Bank Name') }}</label>
                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                        <input type="text" class="form-control" name="bname" required placeholder="Bank name">
                                                    </div>
                                                </div>
                                                  <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>{{ __('Account Name') }}</label>
                                                        <input type="text" class="form-control" name="act_name" required placeholder="Account Name">
                                                    </div>
                                                </div>    
                                              
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>{{ __('Account Number') }}</label>
                                                        <input type="text" class="form-control" name="actNo"  required placeholder="Account number">
                                                    </div>
                                                </div>
 
                                                
                                                     <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>{{ __('Routing/Swift/Iban Code') }}</label>
                                                        <input type="text" class="form-control" name="swift_num" required placeholder="Routing/Swift/Iban Code">
                                                    </div>
                                                </div>  
                                                
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <button class="collcc btn btn-info">{{ __('Add Bank') }}</button>
                                                    </div>
                                                </div>                                                
                                                
                                            </div>
                                        </form>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-sm-12">
                                  <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">{{ __('My Bank Details') }}</div>
                                    </div>
                                    <div class="card-body pb-0 table-responsive" >
                                       <table id="basic-datatables" class="display table table-striped table-hover" >
                                            <thead>
                                                <tr>                                                
                                                    <th data-field="status" data-editable="true">{{ __('Bank Name') }}</th>
                                                    <th data-field="phone" data-editable="true">{{ __('Acount Name') }}</th>
                                                    <th data-field="date" data-editable="true">{{ __('Acount Number') }}</th>
                                                    <th data-field="date" data-editable="true">{{ __('Bank Code') }}</th>
                                                    <th data-field="company" >Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($mybanks) > 0)
                                                    @foreach($mybanks as $bank)
                                                        <tr>
                                                            <td>{{$bank->Bank_Name}}</td>
                                                            <td>{{$bank->Account_name}}</td>
                                                            <td>{{$bank->Account_number}}</td>
                                                            <td>{{$bank->Swift_number}}</td>
                                                            <td>
                                                                <a class="btn btn-danger" href="/user/remove/bankaccount/{{$bank->id}}" title="Remove">
                                                                    <i class="fa fa-times"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                        <br><br>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <!-- End of bank Panel -->

                            <!-- wallets -->
                            <div class="p-5 tab-pane fade " id="wallet" role="tabpanel" >
                              <div class="row form-group">
                                <div class="col-sm-12">
                                  <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">{{ __('Add Crypto Wallet') }}</div>
                                    </div>
                                    <div class="card-body">
                                        <form class="" method="post" action="/user/add/btc_wallet">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>{{ __('Coin Host') }}</label>
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="text" class="form-control" name="coin_host" required placeholder="Exp. Blockchain, Coinbase Paxful">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>{{ __('Wallet') }}</label>
                                                        <input type="text" class="form-control" name="coin_wallet"  required placeholder="Wallet address">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <button class="collcc btn btn-info">{{ __('Add Wallet Address') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-sm-12">
                                  <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">{{ __('My Wallet Addresses') }}</div>
                                    </div>
                                    <div class="card-body pb-0 table-responsive" >
                                       <table id="basic-datatables" class="display table table-striped table-hover" >
                                            <thead>
                                                <tr>                                                
                                                    <th>{{ __('Coin') }}</th>
                                                    <th>{{ __('Coin Host') }}</th>
                                                    <th>{{ __('Wallet Address') }}</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($my_wallets) > 0)
                                                    @foreach($my_wallets as $bank)
                                                        <tr>
                                                            <td>{{$bank->Account_name}}</td>
                                                            <td>{{$bank->Bank_Name}}</td>
                                                            <td>{{$bank->Account_number}}</td>
                                                            <td>
                                                                <a class="btn btn-danger" href="/user/remove/bankaccount/{{$bank->id}}" title="Remove">
                                                                    <i class="fa fa-times"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                        <br><br>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            
                            <!-- End of wallets -->
                            
                            <!-- KYC -->
                            <div class="p-5 tab-pane fade " id="kyc" role="tabpanel" >
                              @if(count($kyc) > 0 && $kyc[0]->status == 0)
                                <div class="col-sm-6">
                                  <div class="card">
                                    <div class="card-header">
                                        <div class="card-head-row">
                                            <div class="card-title">{{ __('Verification status') }}</div>
                                            <div class="card-tools">                                            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-warning">
                                          {{ _('Your verification is under review. You will be notified shortly') }}
                                        </div>                                  
                                    </div>
                                  </div>
                                </div>
                              @elseif(count($kyc) > 0 && $kyc[0]->status == 1)
                                <div class="col-sm-6">
                                  <div class="card">
                                    <div class="card-header">
                                        <div class="card-head-row">
                                            <div class="card-title">{{ __('Verification status') }}</div>
                                            <div class="card-tools">                                            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-success">
                                          {{ _('You are fully verified') }}
                                        </div>                                  
                                    </div>
                                  </div>
                                </div>
                              @elseif(count($kyc) == 0)
                                <form id="id_verify" class="" method="post" action="{{ route('kyc.kyc_upload') }}" enctype="multipart/form-data">
                                  <div class="row form-group">
                                    <div class="col-sm-6">
                                      <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">{{ __('KYC Level Upgrade') }}</div>
                                        </div>
                                        <div class="card-body">

                                          <div class="row">
                                            <div class="col-lg-12">
                                                <div id="selfie" class="">
                                                  <div class="form-group" align="center">                                              
                                                    <h3>Upload Selfie</h3> 
                                                    <hr>
                                                    <p class="text-warning " align="left">
                                                     Take a selfie of yourself holding your ID with your full face clearly shown
                                                    </p>
                                                    <!--<p class="text-warning " align="left">-->
                                                    <!--  Hold a paper clearly written "{{ strtoupper(env('APP_URL')) }}" <br> and take a selfie with it. <br>Must show your full face and your arm raised.-->
                                                    <!--</p>-->
                                                    <img src="/img/any.png" class="" align="center">
                                                    <input type="file" class="form-control upload_inp mt-2" name="selfie" required>
                                                  </div>                                                
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                  <h3>{{ __('Identity verification') }}</h3> 
                                                  <p>
                                                    {{ __('Valid documents are: Country ID Card, Internattional Passport and Drivers Licence') }}
                                                  </p> 
                                                </div>
                                                <div class="form-group mt-4">                                              
                                                  <label>Card Type</label>                                                  
                                                  <select id="card_select" name="cardtype" class="form-control" required="required">
                                                    <option selected disabled >Select ID type</option>
                                                    <option value="idcard_op">Country/State ID</option>
                                                    <option value="passport_op">International Passport</option>
                                                    <option value="driver_op">Driver's Licence</option>
                                                  </select>
                                                </div>
                                                <hr>
                                                <div id="card_cont" class="cont_display_none">
                                                  <div class="form-group mt-3">                                              
                                                    <label>Card Front</label> 
                                                    <br>
                                                    <img src="/img/id_temp_front.png" class="img_card_temp" width="100%">                                                 
                                                    <input type="file" class="form-control upload_inp mt-2" name="id_front" >
                                                  </div>

                                                  <hr>
                                                  <div class="form-group mt-3">                                              
                                                    <label>Card Back</label>
                                                    <br>
                                                    <img src="/img/id_tem_bac.png" class="img_card_temp" width="100%">                                                   
                                                    <input type="file" class="form-control mt-2" name="id_back" >
                                                  </div>
                                                </div>
                                                
                                                <div id="pass_cont" class="cont_display_none">
                                                  <div class="form-group">                                              
                                                    <label>Passport Front</label> 
                                                    <br>
                                                    <img src="/img/id_temp_front.png" class="img_card_temp" width="100%">                                                  
                                                    <input type="file" class="form-control upload_inp mt-2" name="pas_id_front" >
                                                  </div>                                                
                                                </div>
                                              
                                            </div>
                                          </div>

                                        </div>
                                      </div>
                                    </div> 

                                    <div class="col-sm-6">
                                      <div class="card">
                                        <div class="card-header">
                                          <div class="card-title">{{ __('Proof of Address') }}</div>
                                        </div>
                                        <div class="card-body">
                                          <div class="row">
                                            <div class="row">
                                              <div class="col-lg-12">
                                                
                                                  <div class="form-group">
                                                    <h3></h3> 
                                                    <p>
                                                      {{ __('Valid documents are: Utility bill and Bank statement') }}
                                                    </p>                                                   
                                                    <input type="file" class="form-control" name="utility_doc" required >
                                                  </div>

                                              </div>
                                            </div>
                                          </div>

                                        </div>
                                      </div>
                                          
                                    </div> 

                                    <div class="col-sm-12 mt-5">
                                      <div class="form-group">
                                        <button class="collcc btn btn-info float-right">{{ __('Upload') }}</button>
                                      </div>
                                    </div>

                                  </div>
                                </form>
                              @endif
                            </div>
                            <!-- End of KYC -->


                            <!-- Security -->
                            <div class="p-5 tab-pane fade " id="sec" role="tabpanel" >
                              <div class="row form-group">

                                <div class="col-sm-6">
                                  <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">{{ __('2FA Security') }}</div>
                                    </div>
                                    <div class="card-body">
                                        
                                      <div class="row">
                                          <div id="sec_enable_div" class="col-lg-12">
                                            <div class="form-group ">
                                              <div>
                                                <label>{{ __('Enable/Disable') }}</label>
                                              </div>
                                                
                                              <div class="btn-group btn-group-toggle btn-lg p-0 ">
                                                <label class="btn @if($user->sec_2fa_status == 1){{__('btn-success text-white')}}@else{{__('btn_grey')}}@endif" onclick="s_2fa('enable')">
                                                  <input type="radio" name="options" autocomplete="off" > Enable
                                                </label>                                                    
                                                <label class="btn @if($user->sec_2fa_status == 1){{__('btn_grey')}}@else{{__('btn-success text-white')}}@endif" onclick="s_2fa('disable')">
                                                  <input type="radio" name="options" autocomplete="off" > Disable
                                                </label>
                                              </div>
                                              <div class="width_100per float-right">
                                                <small class="float-right mt-4">
                                                  {{__('Current status: ')}} @if($user->sec_2fa_status == 1){{__('Enable')}}@else{{__('Disable')}}@endif
                                                </small>
                                              </div>
                                                  
                                            </div>
                                          </div>

                                          <div class="col-sm-12">
                                            <div id="google_2fa_cont" class="cont_display_none ">
                                              <div class="card-header">
                                                  <div class="card-title">{{ __('QR CODE') }}</div>
                                              </div>
                                              <div id="qrcode_2fa_div" class="card-body pb-0 table-responsive text-center" >
                                                <div class="form-group" align="center">
                                                  <img id="img_2fa" src="" class="qr_code_img " align="center">
                                                </div>
                                                <div class="form-group">
                                                  <p>
                                                    Scan the QR CODE with Google Authenticator and enter the coe dispayed in the box below.
                                                  </p>
                                                </div> 
                                                <form action="{{ route('user2fa.verify_2fa') }}" method="post">
                                                  <div class="form-group">
                                                    <input type="text" class="form-control" name="fa_code" required placeholder="6-digit OTP">
                                                    <input id="seccode" type="hidden" class="form-control" value="" name="seccode" required placeholder="">
                                                  </div>
                                                  <div class="form-group">
                                                    <button  class="collcc btn btn-info">{{ __('Activate (Disabled on Demo)') }}</button>
                                                  </div>
                                                </form>                                        
                                                <br>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="col-sm-12">
                                            <div id="google_2fa_disable" class="cont_display_none ">
                                              <div class="card-header">
                                                  <div class="card-title">{{ __('Verify OTP') }}</div>
                                              </div>
                                              <div id="qrcode_2fa_div" class="card-body pb-0 table-responsive text-center" >
                                                <div class="form-group">
                                                  <p>
                                                    Pleaae enter Google Authenticator OTP.
                                                  </p>
                                                </div> 
                                                <form action="{{ route('user2fa.disable_2fa') }}" method="post">
                                                  <div class="form-group">
                                                    <input type="text" class="form-control" name="fa_otp" required placeholder="6-digit OTP">
                                                  </div>
                                                  <div class="form-group">
                                                    <button class="collcc btn btn-info">{{ __('Disable') }}</button>
                                                  </div>
                                                </form>                                        
                                                <br>
                                              </div>
                                            </div>
                                          </div>
                                         
                                      </div>
                                        
                                    </div>
                                  </div>
                                </div>

                                <div class="col-sm-6">
                                  <div class="card">
                                    <div class="card-header">
                                        <div class="card-head-row">
                                            <div class="card-title">{{ __('Change Password') }}</div>
                                            <div class="card-tools">                                            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form class="" method="post" action="/user/change/pwd">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            <div class="form-group">
                                                <label>{{ __('Old Password') }}</label>
                                                <input type="password" class="form-control" name="oldpwd" placeholder="Your current password" required>
                                            </div>
                                            <div class="form-group">
                                                <label>{{ __('New Password') }}</label>
                                                <input type="password" class="form-control" name="newpwd" placeholder="New Password" required>
                                            </div>
                                            <div class="form-group">
                                                <label>{{ __('Confirm Password') }}</label>
                                                <input type="password" class="form-control" name="cpwd" placeholder="Confirm Password" required>
                                            </div>
                                            <div class="form-group" align="">
                                               <button class="collcc btn btn-info">{{ __('Update') }}</button>
                                            </div>
                                        </form>                                    
                                    </div>
                                  </div>
                                </div>

                              </div>
                            </div>
                            <!-- End of Security -->
                          </div>
                      </div>

                    </div>

                </div>
            </div>
             @include('user.inc.confirm_inv')
@endSection