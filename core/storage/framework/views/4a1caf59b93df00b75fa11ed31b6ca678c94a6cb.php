<?php ($user_data = user_details_data($id)); ?>
<?php ($user = $user_data['user']); ?>
<?php ($dt = $user_data['dt']); ?>

<?php $__env->startSection('content'); ?>
        <div class="main-panel">
            <div class="content">
                <?php echo $__env->make('admin.atlantis.main_bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="page-inner mt--5">
                    <?php echo $__env->make('admin.atlantis.overview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <div id="prnt"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header" style="background-color:<?php echo e($settings->header_color); ?>">
                                    <div class="card-head-row card-tools-still-right">
                                        <h4 class="card-title text-white"> <?php echo e(__('messages.usr_det_adm')); ?> </h4>
                                        <div class="card-tools">
                                            <a href="/admin/block/user/<?php echo e($user->id); ?>" > 
                                                <span class=""><i class="fa fa-ban btn btn-warning" ></i></span>
                                            </a>
                                            <a href="/admin/activate/user/<?php echo e($user->id); ?>" > 
                                                <span><i class="fa fa-check btn btn-success"></i></span>
                                            </a>
                                            <?php if($adm->role != 1): ?>
                                                <a href="/admin/delete/user/<?php echo e($user->id); ?>" > 
                                                    <span class=""><i class="fa fa-times btn btn-danger"></i></span>
                                                </a>
                                            <?php endif; ?>
                                        </div>                                                                             
                                    </div>
                                </div>
                                <div class="card-body">                                    
                                    <div class="row pad_top_20">
                                        <div class="col-lg-6">
                                            <div class="form-group" align="center">
                                                <?php if($user->img == ""): ?>
                                                    <img class="img-responsive" src="/img/any.png" width="200px" height="200px">
                                                <?php else: ?>
                                                    <img class="img-responsive" src="/img/profile/<?php echo e($user->img); ?>" width="200px" height="200px">
                                                <?php endif; ?>
                                            </div>

                                            <div class="form-group" align="center">
                                               <a href="javascript:void(0)" data-toggle="modal" data-target="#add_fund_modal" class="btn btn-success"><i class="fa fa-plus"></i> <?php echo e(__('messages.add_fund')); ?> </a> 
                                               <a href="javascript:void(0)" data-toggle="modal" data-target="#remove_fund_modal"class="btn btn-danger" ><i class="fa fa-minus"></i> <?php echo e(__('messages.Rem_fund')); ?> </a>
                                            </div>

                                        </div>  
                                        <div class="col-lg-6">
                                            <div class="card full-height">
                                                <div class="card-body">
                                                    <div class="card-title">
                                                        <h2 class=""><b> <?php echo e(__('messages.act_sumry')); ?> </b></h2>
                                                    </div>
                                                    <hr>
                                                    <div class="row py-3 <?php if($adm->role < 2): ?> <?php echo e(blur_cnt); ?><?php endif; ?> position_relative">
                                                        <div class="col-md-6 d-flex flex-column justify-content-around">
                                                            <div class="border_btm_1">
                                                                <h4 class="fw-bold  text-info op-8"> <?php echo e(__('messages.wlt_bal')); ?> </h4>
                                                                <h3 class="fw-bold"><?php echo e($settings->currency); ?> <?php echo e(round($user->wallet,2)); ?></h3>
                                                                <div class="colhd margin_top_n10 font_10">&emsp;</div>
                                                            </div>                      
                                                          <div class="clearfix"><br></div>                      
                                                            <div>                           
                                                                <h4 class="fw-bold text-info op-8"> <?php echo e(__('messages.refrrl_bns')); ?> </h4>
                                                                <h3 class="fw-bold"><?php echo e($settings->currency); ?> <?php echo e(round ($user->ref_bal, 2)); ?></h3>
                                                                <div class="colhd margin_top_n10 font_10 ">&emsp;</div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="border_btm_1" >
                                                                <h4 class="fw-bold text-info op-8"> <?php echo e(__('messages.date_create')); ?> </h4>
                                                                <?php echo e($dt->format('Y-m-d')); ?>

                                                                <div class="colhd margin_top_n10 font_10">&emsp;</div> 
                                                                <br>    
                                                            </div>
                                                            <div class="clearfix"><br></div> 
                                                            <div>
                                                                <h4 class="fw-bold text-info op-8"> <?php echo e(__('messages.sts')); ?> </h4>       
                                                                <span class="fa fa-circle" style="color: green;"></span>
                                                                <span class="">
                                                                <?php if($user->status == 1 || $user->status == 'Active'): ?> 
                                                                    <?php echo e(__('messages.sts_active')); ?>

                                                                <?php elseif($user->status == 2 || $user->status == 'Blocked'): ?> 
                                                                    <?php echo e(__('messages.blck')); ?>

                                                                <?php elseif($user->status == 0 || $user->status == 'Inactive'): ?> 
                                                                    <?php echo e(__('messages.not_active')); ?>

                                                                <?php endif; ?>
                                                                </span> 
                                                               
                                                                <div class="colhd margin_top_n10 font_10" >&emsp;</div> 
                                                                <br>    
                                                            </div>

                                                        </div>

                                                    </div>             
                                                </div>
                                            </div>                                            
                                            
                                        </div>                               
                                        
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label> <?php echo e(__('messages.first_name')); ?> </label>
                                                <input id="adr" type="text" value="<?php echo e(ucfirst($user->firstname)); ?>" class="form-control" name="fname" readonly>
                                            </div>
                                        </div>  
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label> <?php echo e(__('messages.lst_nam')); ?> </label>
                                                <input id="adr" type="text" value="<?php echo e(ucfirst($user->lastname)); ?>" class="form-control" name="lname" readonly>
                                            </div>
                                        </div>                               
                                        
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label> <?php echo e(__('messages.user_login_frm_email')); ?> </label>
                                                <div class="input-group">                                                       
                                                    <input id="email" type="email" value="<?php echo e($user->email); ?>" class="form-control" name="email">
                                                </div>
                                                
                                            </div>
                                        </div>     

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label> <?php echo e(__('messages.username')); ?> </label>
                                                <div class="input-group">                                                       
                                                    <input id="usn" type="text" value="<?php echo e($user->username); ?>" class="form-control" name="usn" readonly>
                                                </div>
                                                
                                            </div>
                                        </div>                                             
                                        
                                    </div>   

                                    <form class="" method="post" action="/admin/update/user/profile">
                                        
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                                    <input type="hidden" name="uid" value="<?php echo e($user->id); ?>">
                                                    <label> <?php echo e(__('messages.cntry')); ?> </label>
                                                    <select id="country" class="form-control" name="country" >
                                                        <?php 
                                                            $country = App\country::orderby('name', 'asc')->get();
                                                        ?>
                                                        <?php ($phn_code = ''); ?>
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
                                                                <option selected disabled><?php echo e(__('messages.select_country')); ?></option>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                 <div class="form-group">
                                                    <label> <?php echo e(__('messages.state_prvc')); ?> </label>
                                                    <select  id="states" class="form-control" name="state" required>
                                                        <?php if(isset($cs)): ?>
                                                            <?php 
                                                                $st = App\states::where('id', $user->state)->get();
                                                            ?>
                                                            <?php if(count($st) > 0): ?>
                                                                <option selected value="<?php echo e($st[0]->id); ?>"><?php echo e($st[0]->name); ?></option>
                                                            <?php else: ?>
                                                                <option selected disabled><?php echo e(__('messages.select_state')); ?> </option>
                                                            <?php endif; ?>
                                                            
                                                        <?php else: ?>
                                                           <option selected disabled><?php echo e(__('messages.select_state')); ?> </option>
                                                        <?php endif; ?>                                                           
                                                    </select>                                                        
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label> <?php echo e(__('messages.adr')); ?> </label>
                                                    <input id="adr" type="text" class="form-control" value="<?php echo e($user->address); ?>" name="adr" required>
                                                </div>
                                            </div>  

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label> <?php echo e(__('messages.phn')); ?> </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span id="countryCode" class="input-group-text">
                                                                <?php if(isset($phn_code)): ?>
                                                                    <?php echo e('+'.$phn_code); ?>

                                                                <?php else: ?>
                                                                    +1
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
                                                       <button class="collb btn btn-info"> <?php echo e(__('messages.save')); ?> </button>
                                                </div>
                                            </div>              
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title"> <?php echo e(__('messages.rst_usr_pwd')); ?> </div>
                                </div>
                                <div class="card-body pb-0">
                                    <form class="" method="post" action="/admin/change/user/pwd">
                                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                        <input type="hidden" name="uid" value="<?php echo e($user->id); ?>">
                                        <div class="form-group">
                                            <label> <?php echo e(__('messages.new_pwd')); ?> </label>
                                            <input type="password" class="form-control" name="newpwd"  required>
                                        </div>
                                        <div class="form-group">
                                            <label> <?php echo e(__('messages.cnfrm_pwd')); ?> </label>
                                            <input type="password" class="form-control" name="cpwd"  required>
                                        </div>
                                            <div class="form-group" align="left">
                                               <button class="collb btn btn-info"> <?php echo e(__('messages.save')); ?> </button>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> 

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title"> <?php echo e(__('messages.usr_inv')); ?> </div>
                                </div>
                                <div class="card-body pb-0">
                                    <?php echo $__env->make('admin.temp.user_inv', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <br><br>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title"> <?php echo e(__('messages.wthdrwl_hstry')); ?> </div>
                                </div>
                                <div class="card-body pb-0 table-responsive">
                                    <?php echo $__env->make('admin.temp.user_wd_history', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <br><br>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title"> <?php echo e(__('messages.referrals')); ?> </div>
                                </div>
                                <div class="card-body pb-0 table-responsive">
                                    <?php echo $__env->make('admin.temp.user_ref', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <br><br>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title"> <?php echo e(__('messages.bnk_act')); ?> </div>
                                </div>
                                <div class="card-body pb-0 table-responsive">
                                    <table  id="" class="display table table-stripped table-hover">
                                        <thead>
                                            <tr>
                                                <th> <?php echo e(__('messages.bnk_nam')); ?> </th>
                                                <th> <?php echo e(__('messages.act_numb')); ?> </th>
                                                <th> <?php echo e(__('messages.act_nam')); ?> </th>
                                                <th> <?php echo e(__('messages.swt_nam')); ?> </th>
                                                <th> <?php echo e(__('messages.actn')); ?> </th>
                                            </tr>
                                        </thead>                                        
                                        <tbody>
                                            <?php 
                                                 $mybanks = App\banks::where('user_id', $user->id)->get();
                                            ?>
                                            <?php if(count($mybanks) > 0): ?>
                                                <?php $__currentLoopData = $mybanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($bank->Bank_Name); ?></td>
                                                        <td><?php echo e($bank->Account_name); ?></td>
                                                        <td><?php echo e($bank->Account_number); ?></td>
                                                        <td><?php echo e($bank->Swift_number); ?></td>
                                                        <td>
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
            </div>

            <div class="modal fade" id="add_fund_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel"><b><?php echo e(__('messages.add_fund')); ?></b></h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo e(route('admin_add_fund')); ?>">
                                <div class="row"> 
                                    <div class="col-md-12">
                                        <h5><i class="fas fa-thumbtack"></i> <?php echo e(__('messages.enter_amt')); ?> </h5>
                                        <input type="text" name="amt" value="" class="form-control" placeholder="Amount" required >
                                        <input type="hidden" name="uid" value="<?php echo e($user->id); ?>" class="form-control" required >
                                    </div> 
                                    <div class="col-sm-12 mt-3">
                                        <input type="submit" class="btn btn-primary" value="<?php echo e(__('messages.add_fund')); ?>">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                                                        
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="remove_fund_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel"><b><?php echo e(__('messages.Rem_fund')); ?></b></h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo e(route('admin_remove_fund')); ?>">
                                <div class="row"> 
                                    <div class="col-md-12">
                                        <h5><i class="fas fa-thumbtack"></i> <?php echo e(__('messages.enter_amt')); ?> </h5>
                                        <input type="text" name="amt" value="" class="form-control" placeholder="Amount" required >
                                        <input type="hidden" name="uid" value="<?php echo e($user->id); ?>" class="form-control" required >
                                    </div> 
                                    <div class="col-sm-12 mt-3">
                                        <input type="submit" class="btn btn-danger" value="<?php echo e(__('messages.Rem_fund')); ?>">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                                                        
                        </div>
                    </div>
                </div>
            </div>
<?php $__env->stopSection(); ?>
            
<?php echo $__env->make('admin.atlantis.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gcibrokers/client.gcibrokers.net/core/resources/views/admin/user_details.blade.php ENDPATH**/ ?>