
<?php $__env->startSection('content'); ?>
        <div class="main-panel">
            <div class="content">
                <?php echo $__env->make('admin.atlantis.main_bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="page-inner mt--5"> 
                    <div class="row mt--2">
                        <div class="col-md-6">
                            <div class="card full-height">
                                <div class="card-body">
                                    <div class="card-title"> <?php echo e(__('messages.prfl')); ?> </div>  
                                    <hr>                                 
                                    <div class="row">
                                        <div class="col-4">
                                            <?php if($adm->img == ""): ?>
                                                <img src="/img/adminAvatar/any.png" alt="avatar" class="admin_usr_img_size">
                                            <?php else: ?>
                                                <img src="/img/adminAvatar/<?php echo e($adm->img); ?>" alt="avatar" class="admin_usr_img_size">
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-8">
                                            <div class="row">
                                                <div class="col-8"><h5><b> <?php echo e(__('messages.nam')); ?> </b>: <?php echo e($adm->name); ?></h5></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12"><h5><b> <?php echo e(__('messages.admin_frm_email')); ?> </b>: <?php echo e($adm->email); ?></h5></div>
                                            </div>
                                            <div class="row">
                                        <div class="col-md-8"><h6><b> <?php echo e(__('messages.lvl')); ?> </b>: <?php echo e($adm->role); ?></h6></div>                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12"><h6><b> <?php echo e(__('messages.crtd_on')); ?> </b>: <?php echo e($adm->created_at); ?> </h6></div>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card full-height">
                                <div class="card-body" style="">
                                    <div id="circles-admLevel" align="center"></div><br>
                                    <h5 align="center"> <?php echo e(__('messages.act_lvl')); ?> </h5>             
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="prnt"></div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title"> <?php echo e(__('messages.chng_pwd')); ?> </div>                                       
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form action="/admin/change/pwd" method="post">
                                        <input id="token" type="hidden" class="form-control" name="_token" value="<?php echo e(csrf_token()); ?>">                                          
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text " ><i class="fa fa-key"></i></span>
                                            </div>
                                              <input type="Password" class="form-control" name="oldpwd" placeholder="<?php echo e(__('messages.old_pwd')); ?> " required>
                                          </div>
                                          <br>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text "><i class="fa fa-key"></i></span>
                                            </div>
                                              <input id="" type="password" class="form-control" name="newpwd" placeholder="<?php echo e(__('messages.new_pwd')); ?> " required>
                                        </div>
                                          <br>
                                        <div class="input-group"> 
                                            <div class="input-group-prepend">               
                                              <span class="input-group-text "><i class="fa fa-key"></i></span>
                                            </div>
                                              <input id="" type="password" class="form-control" name="cpwd" placeholder="<?php echo e(__('messages.confrm_pwd')); ?> " required>
                                        </div>
                                          <br>
                                          
                                        <div class="form-group">
                                            <br>
                                              <button class="collb btn btn-info"> <?php echo e(__('messages.updt_pwd')); ?> </button>
                                              <br>
                                        </div>                                          
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.atlantis.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gcibrokers/client.gcibrokers.net/core/resources/views/admin/profile.blade.php ENDPATH**/ ?>