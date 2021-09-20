<?php $__env->startSection('content'); ?>
<body>
    <div style="">
        <img src="/img/adult.jpg" class="fixedOverlayIMG">         
        <div style="position: fixed; left: 0px; top: 0px; height:100%; width: 100%; background-color: <?php echo e($settings->header_color); ?>"></div>
        <div class="">
            <div class="row admin_login_row">
                <div class="col-md-6 position_relative" >
                    <div class="admin_login_title" align="center">
                        <img src="/img/<?php echo e($settings->site_logo); ?>" alt="<?php echo e($settings->site_title); ?>" class="login_logo">
                        <h1><?php echo e($settings->site_title); ?></h1> 
                        <p>                                                       
                            <h4> <?php echo e(__('messages.admin_login_title')); ?> </h4>
                        </p>
                    </div>                    
                </div>
                <div class="col-md-6 bg_white">
                    <div class="login_fixed_panel">
                        <div class="row">
                            <div class="col-md-12" >
                                <div style="">                        
                                    <div class="panel" align="center">
                                        <img src="/img/<?php echo e($settings->site_logo); ?>" alt="<?php echo e($settings->site_title); ?>" class="login_logo">
                                        <br><br>
                                        <h4 align="center"><b> <?php echo e(__('messages.admin_login_frm_title')); ?></b> </h4> 
                                        <div id="errMsg" class="card-header alert alert-danger cont_display_none" align="center">         
                                        </div>

                                        <?php if(Session::has('err2') ): ?>         
                                            <script type="text/javascript">            
                                                $('#errMsg').html("<?php echo e(Session::get('err2')); ?>");
                                                $('#errMsg').show();
                                            </script>
                                            <?php echo e(Session::forget('err2')); ?>

                                        <?php endif; ?>

                                        <div class="panel-body" style="padding: 5px 10%;">
                                            <form method="POST" action="/dhadmin/login">                        
                                                <input id="csrf" type="hidden"  name="_token" value="<?php echo e(csrf_token()); ?>" >
                                                <div class="form-group row" >
                                                    <b><?php echo e(__('messages.admin_frm_email')); ?></b>
                                                    <div class="input-group">
                                                        <input id="" type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" class="form-control">
                                                        <div class="input-group-prepend bg_ash">
                                                            <span class="input-group-text"><i class="fa fa-envelope "></i></span>
                                                        </div>
                                                        <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus placeholder="<?php echo e(__('messages.admin_frm_email')); ?>">

                                                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <span class="invalid-feedback text-danger" role="alert" >
                                                                <?php echo e($message); ?>

                                                            </span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                </div>

                                                <div class="form-group row ">
                                                    <b><?php echo e(__('messages.admin_form_pwd')); ?></b>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend bg_ash">
                                                            <span class="input-group-text"><i class="fa fa-key"></i></span>
                                                        </div>
                                                        <input id="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required autocomplete="current-password" placeholder="<?php echo e(__('messages.admin_form_pwd')); ?>">

                                                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <span class="invalid-feedback text-danger" role="alert" >
                                                                <?php echo e($message); ?>

                                                            </span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-0 pt-0 pb-0">
                                                    <div class="col-md-12" align="center">
                                                        <button type="submit" class="btn btn-primary">
                                                            <?php echo e(__('messages.login_btn')); ?>

                                                        </button>                               
                                                    </div>
                                                    <div class="col-md-12 mt-5" align="center">
                                                        <strong><a href="" class="btn border" data-target="#reset_pwd_modal" data-toggle="modal"><i class="fa fa-key"></i> <?php echo e(__('messages.pwd_recovery')); ?></a></strong>
                                                    </div>                            
                                                </div>
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
    </div>
    <div class="modal fade" id="reset_pwd_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="padding-top:70px" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel"><b><?php echo e(__('messages.pwd_recovery')); ?></b></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?php echo e(route('admin_reset_pwd')); ?>">
                        <div class="row"> 
                            <div class="col-md-12">
                                <input type="text" name="admin_email" value="" class="form-control" placeholder="<?php echo e(__('messages.admin_frm_email')); ?>" required >                               
                            </div> 
                            <div class="col-sm-12 mt-3">
                                <input type="submit" class="btn btn-primary" value="Reset">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                                                
                </div>
            </div>
        </div>
    </div>
    
    <div class="floating_lang_div" style="display:none">
       <select id="lang_select" class="lang_select_input">
            <?php
                $activities = $lang;
            ?>
            <?php if(count($activities) > 0 ): ?>
                <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($activity->lang_code); ?>" <?php if(Session::get('locale') == $activity->lang_code): ?>) <?php echo e(__('selected')); ?> <?php endif; ?>><i class="fa fa-flag"></i><?php echo e(strtoupper($activity->lang_code)); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <?php echo e(__('No language')); ?>

            <?php endif; ?>      
            
        </select>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.auth_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gcibrokers/client.gcibrokers.net/core/resources/views/admin/login.blade.php ENDPATH**/ ?>