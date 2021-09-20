<?php echo $__env->make('user.inc.fetch', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('content'); ?>
        <div class="main-panel">
            <div class="content">
                <?php ($breadcome = __('messages.wthdrwl')); ?>
                <?php echo $__env->make('user.atlantis.main_bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="page-inner mt--5">
                    <?php echo $__env->make('user.atlantis.overview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <div id="prnt"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title"><?php echo e(__('messages.wthdrwl_hstry')); ?></div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">                                        
                                        <table class="display table table-striped table-hover" >
                                            <thead>
                                                <tr>                                                   
                                                    <th><?php echo e(__('messages.date')); ?></th> 
                                                    <th><?php echo e(__('messages.pckg')); ?></th>
                                                    <th><?php echo e(__('messages.act')); ?></th>
                                                    <th><?php echo e(__('messages.amnt')); ?></th>                                                   
                                                    <th><?php echo e(__('messages.sts')); ?></th>                                  
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $activities = App\withdrawal::where('user_id', $user->id)->orderby('id', 'desc')->get();
                                                ?>
                                                <?php if(count($activities) > 0 ): ?>
                                                    <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e($activity->created_at); ?></td>
                                                            <td><?php echo e($activity->package); ?></td>
                                                            <td><?php echo e($activity->account); ?></td>
                                                            <td><?php echo e($settings->currency.' '.$activity->amount); ?></td>
                                                            <td><?php echo e($activity->status); ?></td>
                                                                                 
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
            </div>

            <?php echo $__env->make('user.inc.confirm_inv', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>
            
<?php echo $__env->make('layouts.atlantis.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gcibrokers/client.gcibrokers.net/core/resources/views/user/withdrawal.blade.php ENDPATH**/ ?>