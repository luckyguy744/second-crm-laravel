 <title>Password Recovery - <?php echo e(env('APP_NAME')); ?></title>
<?php $__env->startSection('content'); ?>
<body>
    <div>
        <img src="/img/adult.jpg" class="fixedOverlayIMG">         
        <div class="fixedOeverlayBG"></div>
        <div class="container">
            <div class="row pad_T90">
                <div class="col-md-4"></div>
                <div class="col-md-4 card">
                    <div class="card-header" align="center">
                        <img src="/img/<?php echo e($settings->site_logo); ?>" alt="<?php echo e($settings->site_title); ?>" class="login_logo"> 
                        <br>
                        <h3><i class="fa fa-key"></i><?php echo e(__('messages.pwd_recovery2')); ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="">                    
                            <?php if(Session::has('msgType') && Session::get('msgType') == 'err'): ?>                                
                                <div class="alert alert-danger">
                                    <?php echo e(Session::get('status')); ?>

                                </div>
                                <?php echo e(Session::forget('msgType')); ?>

                                <?php echo e(Session::forget('status')); ?>


                            <?php elseif(Session::has('msgType') && Session::get('msgType') == 'suc'): ?>
                            
                                <div class="alert alert-success">
                                    <?php echo e(Session::get('status')); ?>

                                </div>
                                <?php echo e(Session::forget('msgType')); ?>

                                <?php echo e(Session::forget('status')); ?>                                
                            <?php else: ?>
                            <?php endif; ?>
                            <div>
                                <form method="POST" action="/user/request/change/pwd">
                                    <?php echo csrf_field(); ?>
                                    <div class="form-group row">
                                        <label for="email"><?php echo e(__('messages.user_login_frm_email')); ?></label>                                        
                                        <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus>

                                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class=" " align="center">
                                            <button type="submit" class="collcc btn btn-primary">
                                                <?php echo e(__('messages.reset_pwd_btn')); ?>

                                        </div>
                                        <br><br>                                     
                                    </div>
                                    <div class="form-group row mb-0">                                      
                                        <a href="/login">
                                            <i class="fa fa-arrow-left"></i> <?php echo e(__('messages.bck_to_login')); ?>

                                        </a>                                    
                                        <br><br>                                     
                                    </div>
                                     
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br><br>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.auth_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gcibrokers/client.gcibrokers.net/core/resources/views/auth/passwords/email.blade.php ENDPATH**/ ?>