<?php echo $__env->make('user.inc.fetch', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('content'); ?>
        <div class="main-panel">
            <div class="content">
                <?php ($breadcome = 'My Profile'); ?>
                <?php echo $__env->make('user.atlantis.main_bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="page-inner mt--5">
                    <?php echo $__env->make('user.atlantis.overview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                                              <div class="card-title text-center"><?php echo e(__('Avatar')); ?></div>
                                              <div class="card-tools">                                            
                                              </div>
                                          </div>
                                      </div>
                                      <div class="card-body">
                                          <div class="chart-container">
                                              <div class="comment-phara">
                                                  <div class="comment-adminpr" align="center">
                                                      <a id="selectPic" href="javascript:void(0)"  >
                                                          <?php if($user->img == ""): ?>
                                                              <img class="avatar_img" src="/img/any.png">
                                                          <?php else: ?>
                                                              <img class="avatar_img" src="/img/profile/<?php echo e($user->img); ?>">
                                                          <?php endif; ?>
                                                      </a> 

                                                      <form id="form_profilepic" action="/user/upload/profile_pic" method="post" enctype="multipart/form-data">
                                                          <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                                          <input type="file" name="prPic" id="prPic" class="display_not">
                                                      </form>
                                                  </div>
                                                  <br>
                                                  
                                              </div>
                                              <div class="admin-comment-month" align="left" style="font-size: 16px;">
                                                  
                                                  <div align="center"><b> <?php echo e(ucfirst($user->firstname).' '.ucfirst($user->lastname)); ?> </b></div>
                                                  <hr>

                                                  <?php
                                                      $country = App\country::find($user->country);
                                                      $state = App\states::find($user->state);
                                                  ?>

                                                  <div align="center" style="">
                                                      <b>Referral link:</b><br>
                                                      <div style="color: #c60; font-size: 13px; word-wrap: break-word;">
                                                          <?php echo e(env('APP_URL').__('/register/').$user->username); ?>

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
                                              <div class="card-title"><?php echo e(__('Profile Settings')); ?></div>
                                              <div class="card-tools">                                            
                                              </div>
                                          </div>
                                      </div>
                                      <div class="card-body pb-0">
                                          <div class="datatable-dashv1-list custom-datatable-overright dashtwo-project-list-data">
                                            
                                              <div class="row">
                                                  <div class="col-lg-6">
                                                      <div class="form-group">
                                                          <label><?php echo e(__('First Name')); ?></label>
                                                          <input id="adr" type="text" value="<?php echo e(ucfirst($user->firstname)); ?>" class="form-control" name="fname" readonly>
                                                      </div>
                                                  </div>  
                                                  <div class="col-lg-6">
                                                      <div class="form-group">
                                                          <label><?php echo e(__('Last Name')); ?></label>
                                                          <input id="adr" type="text" value="<?php echo e(ucfirst($user->lastname)); ?>" class="form-control" name="lname" readonly>
                                                      </div>
                                                  </div>                               
                                                  
                                              </div>

                                              <div class="row">
                                                  <div class="col-lg-6">
                                                      <div class="form-group">
                                                          <label><?php echo e(__('Email Address')); ?></label>
                                                          <div class="input-group">                                                       
                                                              <input id="email" type="email" value="<?php echo e($user->email); ?>" class="form-control" name="email" readonly>
                                                          </div>
                                                          
                                                      </div>
                                                  </div>     

                                                  <div class="col-lg-6">
                                                      <div class="form-group">
                                                          <label><?php echo e(__('Username')); ?></label>
                                                          <div class="input-group">                                                       
                                                              <input id="usn" type="text" value="<?php echo e($user->username); ?>" class="form-control" name="usn" readonly>
                                                          </div>
                                                          
                                                      </div>
                                                  </div>                                             
                                                  
                                              </div>   

                                              <form class="" method="post" action="/user/update/profile">
                                                  
                                                  <div class="row">
                                                      <div class="col-lg-6">
                                                          <div class="form-group">
                                                              <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                                              <label><?php echo e(__('Country')); ?></label>
                                                              <select id="country" class="form-control" name="country" >
                                                                  <?php 
                                                                      $country = App\country::orderby('name', 'asc')->get();
                                                                      $phn_code = "";
                                                                  ?>
                                                                  <?php $__currentLoopData = $country; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                          <?php if($c->id == $user->country): ?>
                                                                              <?php ($cs = $c->id); ?>
                                                                              <?php ($phn_code = $c->phonecode); ?>
                                                                              <?php echo e('selected'); ?>

                                                                              <option selected  value="<?php echo e($c->id); ?>"><?php echo e($c->name); ?></option>
                                                                          <?php else: ?>
                                                                              <option value="<?php echo e($c->id); ?>"><?php echo e($c->name); ?></option>
                                                                          <?php endif; ?>
                                                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                  <?php if(!isset($cs)): ?>
                                                                          <option selected disabled><?php echo e(__('Select Country')); ?></option>
                                                                  <?php endif; ?>

                                                              </select>
                                                          </div>
                                                      </div>
                                                      <div class="col-lg-6">
                                                           <div class="form-group">
                                                              <label><?php echo e(__('State/Province')); ?></label>
                                                              <select  id="states" class="form-control" name="state" required>
                                                                  <?php if(isset($cs)): ?>
                                                                       <?php 
                                                                          $st = App\states::where('id', $user->state)->get();
                                                                      ?>
                                                                      <?php if(count($st) > 0): ?>
                                                                          <option selected value="<?php echo e($st[0]->id); ?>"><?php echo e($st[0]->name); ?></option>
                                                                      <?php else: ?>
                                                                          <option selected disabled><?php echo e(__('Select State')); ?></option>
                                                                      <?php endif; ?>
                                                                      
                                                                  <?php else: ?>
                                                                     <option selected disabled><?php echo e(__('Select State')); ?></option>
                                                                  <?php endif; ?>                                                           
                                                              </select>                                                        
                                                          </div>
                                                      </div>

                                                  </div>
                                                  <div class="row">
                                                      <div class="col-lg-6">
                                                          <div class="form-group">
                                                              <label><?php echo e(__('Address')); ?></label>
                                                              <input id="adr" type="text" class="form-control" value="<?php echo e($user->address); ?>" name="adr" required>
                                                          </div>
                                                      </div>  

                                                      <div class="col-lg-6">
                                                          <div class="form-group">
                                                              <label><?php echo e(__('Phone')); ?></label>
                                                              <div class="input-group">
                                                                  <div class="input-group-prepend">
                                                                      <span id="countryCode" class="input-group-text">
                                                                          <?php if(isset($phn_code)): ?>
                                                                              <?php echo e('+'.$phn_code); ?>

                                                                          <?php else: ?>
                                                                              
                                                                          <?php endif; ?>
                                                                      </span>
                                                                  </div>                                                            
                                                                  <input id="cCode" type="hidden" class="form-control" name="cCode" required>
                                                                  <input id="phone" type="text" class="form-control" value="<?php echo e(str_replace('+'.$phn_code,'',$user->phone)); ?>" name="phone" required>
                                                              </div>
                                                              
                                                          </div>
                                                      </div>  
                                                  </div>   
                                                  <div class="row">
                                                      <div class="col-lg-12">
                                                          <div class="form-group">
                                                              <button  class="collcc btn btn-info"><?php echo e(__('Update Profile')); ?></button>
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
                                        <div class="card-title"><?php echo e(__('Add Bank Details')); ?></div>
                                    </div>
                                    <div class="card-body">
                                        <form class="" method="post" action="/user/add/bank">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label><?php echo e(__('Bank Name')); ?></label>
                                                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                                        <input type="text" class="form-control" name="bname" required placeholder="Bank name">
                                                    </div>
                                                </div>
                                                  <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label><?php echo e(__('Account Name')); ?></label>
                                                        <input type="text" class="form-control" name="act_name" required placeholder="Account Name">
                                                    </div>
                                                </div>    
                                              
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label><?php echo e(__('Account Number')); ?></label>
                                                        <input type="text" class="form-control" name="actNo"  required placeholder="Account number">
                                                    </div>
                                                </div>
 
                                                
                                                     <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label><?php echo e(__('Routing/Swift/Iban Code')); ?></label>
                                                        <input type="text" class="form-control" name="swift_num" required placeholder="Routing/Swift/Iban Code">
                                                    </div>
                                                </div>  
                                                
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <button class="collcc btn btn-info"><?php echo e(__('Add Bank')); ?></button>
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
                                        <div class="card-title"><?php echo e(__('My Bank Details')); ?></div>
                                    </div>
                                    <div class="card-body pb-0 table-responsive" >
                                       <table id="basic-datatables" class="display table table-striped table-hover" >
                                            <thead>
                                                <tr>                                                
                                                    <th data-field="status" data-editable="true"><?php echo e(__('Bank Name')); ?></th>
                                                    <th data-field="phone" data-editable="true"><?php echo e(__('Acount Name')); ?></th>
                                                    <th data-field="date" data-editable="true"><?php echo e(__('Acount Number')); ?></th>
                                                    <th data-field="date" data-editable="true"><?php echo e(__('Bank Code')); ?></th>
                                                    <th data-field="company" >Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(count($mybanks) > 0): ?>
                                                    <?php $__currentLoopData = $mybanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e($bank->Bank_Name); ?></td>
                                                            <td><?php echo e($bank->Account_name); ?></td>
                                                            <td><?php echo e($bank->Account_number); ?></td>
                                                            <td><?php echo e($bank->Swift_number); ?></td>
                                                            <td>
                                                                <a class="btn btn-danger" href="/user/remove/bankaccount/<?php echo e($bank->id); ?>" title="Remove">
                                                                    <i class="fa fa-times"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
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
                                        <div class="card-title"><?php echo e(__('Add Crypto Wallet')); ?></div>
                                    </div>
                                    <div class="card-body">
                                        <form class="" method="post" action="/user/add/btc_wallet">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label><?php echo e(__('Coin Host')); ?></label>
                                                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                                        <input type="text" class="form-control" name="coin_host" required placeholder="Exp. Blockchain, Coinbase Paxful">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label><?php echo e(__('Wallet')); ?></label>
                                                        <input type="text" class="form-control" name="coin_wallet"  required placeholder="Wallet address">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <button class="collcc btn btn-info"><?php echo e(__('Add Wallet Address')); ?></button>
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
                                        <div class="card-title"><?php echo e(__('My Wallet Addresses')); ?></div>
                                    </div>
                                    <div class="card-body pb-0 table-responsive" >
                                       <table id="basic-datatables" class="display table table-striped table-hover" >
                                            <thead>
                                                <tr>                                                
                                                    <th><?php echo e(__('Coin')); ?></th>
                                                    <th><?php echo e(__('Coin Host')); ?></th>
                                                    <th><?php echo e(__('Wallet Address')); ?></th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(count($my_wallets) > 0): ?>
                                                    <?php $__currentLoopData = $my_wallets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e($bank->Account_name); ?></td>
                                                            <td><?php echo e($bank->Bank_Name); ?></td>
                                                            <td><?php echo e($bank->Account_number); ?></td>
                                                            <td>
                                                                <a class="btn btn-danger" href="/user/remove/bankaccount/<?php echo e($bank->id); ?>" title="Remove">
                                                                    <i class="fa fa-times"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
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
                              <?php if(count($kyc) > 0 && $kyc[0]->status == 0): ?>
                                <div class="col-sm-6">
                                  <div class="card">
                                    <div class="card-header">
                                        <div class="card-head-row">
                                            <div class="card-title"><?php echo e(__('Verification status')); ?></div>
                                            <div class="card-tools">                                            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-warning">
                                          <?php echo e(_('Your verification is under review. You will be notified shortly')); ?>

                                        </div>                                  
                                    </div>
                                  </div>
                                </div>
                              <?php elseif(count($kyc) > 0 && $kyc[0]->status == 1): ?>
                                <div class="col-sm-6">
                                  <div class="card">
                                    <div class="card-header">
                                        <div class="card-head-row">
                                            <div class="card-title"><?php echo e(__('Verification status')); ?></div>
                                            <div class="card-tools">                                            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-success">
                                          <?php echo e(_('You are fully verified')); ?>

                                        </div>                                  
                                    </div>
                                  </div>
                                </div>
                              <?php elseif(count($kyc) == 0): ?>
                                <form id="id_verify" class="" method="post" action="<?php echo e(route('kyc.kyc_upload')); ?>" enctype="multipart/form-data">
                                  <div class="row form-group">
                                    <div class="col-sm-6">
                                      <div class="card">
                                        <div class="card-header">
                                            <div class="card-title"><?php echo e(__('KYC Level Upgrade')); ?></div>
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
                                                    <!--  Hold a paper clearly written "<?php echo e(strtoupper(env('APP_URL'))); ?>" <br> and take a selfie with it. <br>Must show your full face and your arm raised.-->
                                                    <!--</p>-->
                                                    <img src="/img/any.png" class="" align="center">
                                                    <input type="file" class="form-control upload_inp mt-2" name="selfie" required>
                                                  </div>                                                
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                  <h3><?php echo e(__('Identity verification')); ?></h3> 
                                                  <p>
                                                    <?php echo e(__('Valid documents are: Country ID Card, Internattional Passport and Drivers Licence')); ?>

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
                                          <div class="card-title"><?php echo e(__('Proof of Address')); ?></div>
                                        </div>
                                        <div class="card-body">
                                          <div class="row">
                                            <div class="row">
                                              <div class="col-lg-12">
                                                
                                                  <div class="form-group">
                                                    <h3></h3> 
                                                    <p>
                                                      <?php echo e(__('Valid documents are: Utility bill and Bank statement')); ?>

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
                                        <button class="collcc btn btn-info float-right"><?php echo e(__('Upload')); ?></button>
                                      </div>
                                    </div>

                                  </div>
                                </form>
                              <?php endif; ?>
                            </div>
                            <!-- End of KYC -->


                            <!-- Security -->
                            <div class="p-5 tab-pane fade " id="sec" role="tabpanel" >
                              <div class="row form-group">

                                <div class="col-sm-6">
                                  <div class="card">
                                    <div class="card-header">
                                        <div class="card-title"><?php echo e(__('2FA Security')); ?></div>
                                    </div>
                                    <div class="card-body">
                                        
                                      <div class="row">
                                          <div id="sec_enable_div" class="col-lg-12">
                                            <div class="form-group ">
                                              <div>
                                                <label><?php echo e(__('Enable/Disable')); ?></label>
                                              </div>
                                                
                                              <div class="btn-group btn-group-toggle btn-lg p-0 ">
                                                <label class="btn <?php if($user->sec_2fa_status == 1): ?><?php echo e(__('btn-success text-white')); ?><?php else: ?><?php echo e(__('btn_grey')); ?><?php endif; ?>" onclick="s_2fa('enable')">
                                                  <input type="radio" name="options" autocomplete="off" > Enable
                                                </label>                                                    
                                                <label class="btn <?php if($user->sec_2fa_status == 1): ?><?php echo e(__('btn_grey')); ?><?php else: ?><?php echo e(__('btn-success text-white')); ?><?php endif; ?>" onclick="s_2fa('disable')">
                                                  <input type="radio" name="options" autocomplete="off" > Disable
                                                </label>
                                              </div>
                                              <div class="width_100per float-right">
                                                <small class="float-right mt-4">
                                                  <?php echo e(__('Current status: ')); ?> <?php if($user->sec_2fa_status == 1): ?><?php echo e(__('Enable')); ?><?php else: ?><?php echo e(__('Disable')); ?><?php endif; ?>
                                                </small>
                                              </div>
                                                  
                                            </div>
                                          </div>

                                          <div class="col-sm-12">
                                            <div id="google_2fa_cont" class="cont_display_none ">
                                              <div class="card-header">
                                                  <div class="card-title"><?php echo e(__('QR CODE')); ?></div>
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
                                                <form action="<?php echo e(route('user2fa.verify_2fa')); ?>" method="post">
                                                  <div class="form-group">
                                                    <input type="text" class="form-control" name="fa_code" required placeholder="6-digit OTP">
                                                    <input id="seccode" type="hidden" class="form-control" value="" name="seccode" required placeholder="">
                                                  </div>
                                                  <div class="form-group">
                                                    <button  class="collcc btn btn-info"><?php echo e(__('Activate (Disabled on Demo)')); ?></button>
                                                  </div>
                                                </form>                                        
                                                <br>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="col-sm-12">
                                            <div id="google_2fa_disable" class="cont_display_none ">
                                              <div class="card-header">
                                                  <div class="card-title"><?php echo e(__('Verify OTP')); ?></div>
                                              </div>
                                              <div id="qrcode_2fa_div" class="card-body pb-0 table-responsive text-center" >
                                                <div class="form-group">
                                                  <p>
                                                    Pleaae enter Google Authenticator OTP.
                                                  </p>
                                                </div> 
                                                <form action="<?php echo e(route('user2fa.disable_2fa')); ?>" method="post">
                                                  <div class="form-group">
                                                    <input type="text" class="form-control" name="fa_otp" required placeholder="6-digit OTP">
                                                  </div>
                                                  <div class="form-group">
                                                    <button class="collcc btn btn-info"><?php echo e(__('Disable')); ?></button>
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
                                            <div class="card-title"><?php echo e(__('Change Password')); ?></div>
                                            <div class="card-tools">                                            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form class="" method="post" action="/user/change/pwd">
                                            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                            <div class="form-group">
                                                <label><?php echo e(__('Old Password')); ?></label>
                                                <input type="password" class="form-control" name="oldpwd" placeholder="Your current password" required>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo e(__('New Password')); ?></label>
                                                <input type="password" class="form-control" name="newpwd" placeholder="New Password" required>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo e(__('Confirm Password')); ?></label>
                                                <input type="password" class="form-control" name="cpwd" placeholder="Confirm Password" required>
                                            </div>
                                            <div class="form-group" align="">
                                               <button class="collcc btn btn-info"><?php echo e(__('Update')); ?></button>
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
             <?php echo $__env->make('user.inc.confirm_inv', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.atlantis.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gcibrokers/client.gcibrokers.net/core/resources/views/user/profile.blade.php ENDPATH**/ ?>