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
                                        <h4 class="card-title text-white" > <i class="fas fa-envelope"></i> <?php echo e(__('messages.snd_notifctn')); ?> </h4>
                                    </div>
                                </div>
                                <div class="card-body pb-0 table-responsive">
                                   <?php echo $__env->make('admin.temp.send_not', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header" >
                                    <div class="card-head-row card-tools-still-right">
                                        <h4 class="card-title" style=""> <i class="fas fa-bells"></i> <?php echo e(__('messages.prevs_notfyc')); ?> </h4>                      
                                    </div>
                                </div>
                                <div class="card-body pb-0 table-responsive">
                                   <?php echo $__env->make('admin.temp.old_msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.atlantis.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gcibrokers/client.gcibrokers.net/core/resources/views/admin/send_notification.blade.php ENDPATH**/ ?>