<title>Verify Account - <?php echo e(env('APP_NAME')); ?></title>
<?php $__env->startSection('content'); ?>
<body>
    <div class="verify_form_cont">
        <img src="/img/adult.jpg" class="fixedOverlayIMG">         
        <div class="fixedOeverlayBG"></div>
        <div class="container">
            <div class="row pad_T90">
                <div class="col-md-4"></div>
                <div class="col-md-4">                    
                    <div class="very_form_div">                        
                        <div class="panel ">
                            <div class="card-header">
                                <div align="center">
                                     <img src="/img/<?php echo e($settings->site_logo); ?>" alt="<?php echo e($settings->site_title); ?>" class="login_logo">                 
                                    <br>
                                    <h3 class="colhd"><i class="fa fa-key"></i><?php echo e(__('messages.user_verify_call')); ?> </h3>
                                    <hr>
                                </div>
                            </div>
                            <div class="panel-body" style="">
                                <?php if(Session::has('msgType') && Session::get('msgType') == 'err'): ?>
                                
                                    <div class="alert alert-danger">
                                        <?php echo e(Session::get('status')); ?>

                                    </div>
                                    <?php echo e(Session::forget('status')); ?>

                                    <?php echo e(Session::forget('msgType')); ?>

                                    
                                <?php elseif(Session::has('msgType') && Session::get('msgType') == 'suc'): ?>
                                
                                    <div class="alert alert-success">
                                        <?php echo e(Session::get('status')); ?>

                                    </div>
                                    <?php echo e(Session::forget('status')); ?>

                                    <?php echo e(Session::forget('msgType')); ?>

                                <?php else: ?>
                                
                                    <div class="alert alert-danger">
                                       <p>
                                           <?php echo e(__('messages.invalid_access')); ?>

                                       </p>
                                    </div>
                                     
                                <?php endif; ?>

                                <div class="form-group row mb-0">
                                    <div class="" align="center">
                                       <p>
                                           <strong><a href="/login" class="collcc btn btn-warning"><?php echo e(__('messages.bck_to_login')); ?></a></strong>
                                       </p>                            
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('inc.auth_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gcibrokers/client.gcibrokers.net/core/resources/views/auth/act_verify.blade.php ENDPATH**/ ?>