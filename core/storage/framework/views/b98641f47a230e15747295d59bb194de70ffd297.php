<?php ($deps = search_deposit()); ?>

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
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title col-sm-12"  >
                                            <?php echo e(__('messages.v_sprt_msg')); ?>                                             
                                        </div>
                                    </div>
                                     
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">                                        
                                        <table id="basic-datatables" class=" display  table table-striped table-hover" >
                                            <thead>
                                                <tr> 
                                                    <th><?php echo e(__('messages.tckt_id')); ?></th>
                                                    <th><?php echo e(__('messages.user_id')); ?></th> 
                                                    <th><?php echo e(__('messages.ttl')); ?></th>
                                                    <th><?php echo e(__('messages.sts')); ?></th>
                                                    <th><?php echo e(__('messages.actn')); ?></th>  
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                <?php if(!empty($tickets)): ?>
                                                    <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e($ticket->ticket_id); ?></td>
                                                            <td><?php echo e($ticket->user_id); ?></td>
                                                            <td><?php echo e($ticket->title); ?></td>
                                                            <td>
                                                                <?php if($ticket->status == 0): ?>
                                                                    <?php echo e(__('Closed')); ?>

                                                                <?php elseif($ticket->status == 1): ?>
                                                                    <?php echo e(__('Open')); ?>

                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <a title="View Chat" href="/support/<?php echo e($ticket->id); ?>" class="btn btn_blue">
                                                                    <i class="fab fa-teamspeak"></i>
                                                                    <?php if($ticket->state == 1 && $ticket->status != 0): ?>
                                                                        <?php ($rd = 1); ?>
                                                                    <?php endif; ?>
                                                                    <?php $__currentLoopData = $ticket->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php if($comment->state == 1 && $comment->sender != 'support'): ?>
                                                                            <?php ($rd = 1); ?>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php if(isset($rd) && $rd == 1): ?>
                                                                        <i class="fa fa-circle new_not"></i>
                                                                        <?php ($rd = 0); ?>
                                                                    <?php endif; ?>
                                                                </a>                                                                
                                                                <?php if($ticket->status == 0): ?>
                                                                    <a title="Delete Ticket" href="<?php echo e(route('support.delete', $ticket->id)); ?>" class="btn btn-danger">
                                                                        <i class="fa fa-times"></i>
                                                                    </a>
                                                                <?php else: ?>
                                                                    <a title="Close Ticket" href="<?php echo e(route('support.close', $ticket->id)); ?>" class="btn btn-warning">
                                                                        <i class="fas fa-stop-circle"></i>
                                                                    </a>
                                                                <?php endif; ?>
                                                            </td>                                                                                 
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                        <?php echo e($tickets->links()); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
            </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.atlantis.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gcibrokers/client.gcibrokers.net/core/resources/views/admin/ticket_view.blade.php ENDPATH**/ ?>