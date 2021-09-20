<?php $__env->startSection('content'); ?>
<body>
    <div>  
        <div class="fixedOeverlayBG" style="background-color: <?php echo e($settings->header_color); ?>"></div>
        <div class="">
            <div class="row login_row_cont">
                <div class="col-md-6 position_relative" >
                    <div class="logo_cont" align="center">
                        <img src="/img/<?php echo e($settings->site_logo); ?>" alt="<?php echo e($settings->site_title); ?>" class="login_logo">
                        <h1><?php echo e($settings->site_title); ?></h1> 
                        <p>                                                       
                            <h4><?php echo e($settings->site_descr); ?></h4>
                        </p>
                    </div>                    
                </div>
                <div class="col-md-6 bg_white">
                    <div class="login_fixed_panel">
                        <div class="row">
                            <div class="col-md-12" >
                                <div>                        
                                    <div class="">
                                        <div class="">
                                            <div align="center">
                                                <img src="/img/<?php echo e($settings->site_logo); ?>" alt="<?php echo e($settings->site_title); ?>" class="login_logo">
                                                <br>
                                                <h3 class="colhd"><i class="fa fa-user"></i> <?php echo e(__('messages.create_an_act')); ?></h3>
                                                <hr>
                                            </div>
                                        </div>

                                        <div class="reg_form_scroll scroll">
                                            <form method="POST" action="<?php echo e(route('register')); ?>">                                                
                                                <input id="csrf" type="hidden"  name="_token" value="<?php echo e(csrf_token()); ?>" >
                                                <div class="form-group row">                                                    
                                                    <div class="col-sm-6">
                                                        <input id="Fname" type="text" class="form-control <?php $__errorArgs = ['Fname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> regTxtBox" name="Fname" value="<?php echo e(old('Fname')); ?>" required autocomplete="Fname" autofocus placeholder="<?php echo e(__('messages.first_name')); ?>">
                                                        <?php $__errorArgs = ['Fname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <span class="invalid-feedback" role="alert alert-danger">
                                                                <strong><?php echo e($message); ?></strong>
                                                            </span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                     <div class="col-sm-6">
                                                        <input id="Lname" type="text" class="form-control <?php $__errorArgs = ['Lname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> regTxtBox" name="Lname" value="<?php echo e(old('Lname')); ?>" required autocomplete="Lname" autofocus placeholder="<?php echo e(__('messages.lst_nam')); ?>">

                                                        <?php $__errorArgs = ['Lname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <span class="invalid-feedback" role="alert alert-danger">
                                                                <strong><?php echo e($message); ?></strong>
                                                            </span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                </div>
                                                

                                                <div class="form-group row"> 
                                                    
                                                    <div class="col-sm-12">
                                                        <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> regTxtBox" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" placeholder="<?php echo e(__('messages.user_login_frm_email')); ?>">
                                                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <span class="invalid-feedback" role="alert alert-danger">
                                                                <strong><?php echo e($message); ?></strong>
                                                            </span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <input id="username" type="username" class="form-control <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> regTxtBox" name="username" value="<?php echo e(old('username')); ?>" required autocomplete="username" placeholder="<?php echo e(__('messages.username')); ?>">
                                                        <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <span class="invalid-feedback" role="alert alert-danger" >
                                                                <strong><?php echo e($message); ?></strong>
                                                            </span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-sm-6">
                                                        <input id="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> regTxtBox" name="password" required autocomplete="new-password" placeholder="<?php echo e(__('messages.admin_form_pwd')); ?>">
                                                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <span class="invalid-feedback" role="alert alert-danger" >
                                                                <strong><?php echo e($message); ?></strong>
                                                            </span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input id="password-confirm" type="password" class="form-control regTxtBox" name="password_confirmation" required autocomplete="new-password" placeholder="<?php echo e(__('messages.confrm_pwd')); ?>" >
                                                    </div>
                                                </div>


                                                <?php
                                                    $usn = App\User::where('username', Session::get('ref'))->get();
                                                ?>

                                                <div class="row">
                                                    <div class="">
                                                        <input id="ref" type="hidden" class="form-control" name="ref" value="<?php if(count($usn) > 0): ?><?php echo e(Session::get('ref')); ?><?php endif; ?>" >
                                                    </div>
                                                </div>

                                                <div class="">
                                                    <div class="" align="center">
                                                        <br><br>
                                                        <?php if($settings->user_reg == 1): ?>
                                                            <button type="submit" class="collc btn btn-primary">
                                                                <?php echo e(__('messages.register')); ?>

                                                            </button>
                                                        <?php else: ?>
                                                            <div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>
                                                                <?php echo e(__(messages.reg_disabled)); ?>

                                                            </div>
                                                        <?php endif; ?>
                                                        <br><br>
                                                    </div>
                                                </div>

                                                <div class="">
                                                    <div class="" align="center">
                                                       <p>
                                                          <strong> <?php echo e(__('messages.alrdy_have_act')); ?>? <a href="/login"><?php echo e(__('messages.login_btn')); ?></a></strong>
                                                       </p>                            
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
            <br><br>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.auth_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gcibrokers/client.gcibrokers.net/core/resources/views/auth/register.blade.php ENDPATH**/ ?>