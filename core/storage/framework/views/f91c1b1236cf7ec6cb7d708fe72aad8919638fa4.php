
            <table class="display table table-stripped table-hover" >
                <thead>
                    <tr>
                        <th> <?php echo e(__('messages.actn')); ?> </th>
                        <th> <?php echo e(__('messages.username')); ?> </th>
                        <th> <?php echo e(__('messages.amnt')); ?> </th>                        
                        <th> <?php echo e(__('messages.act_nam_txid')); ?> </th>
                        <th> <?php echo e(__('messages.act_wallet')); ?> </th>
                        <th> <?php echo e(__('messages.mthd')); ?> </th>
                        <th> <?php echo e(__('messages.date')); ?> </th>                        
                        <th> <?php echo e(__('messages.sts')); ?> </th>                                                                                
                    </tr>
                </thead>                
                <tbody>
                    
                    <?php if(count($deps) > 0 ): ?>
                        <?php $__currentLoopData = $deps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <a title="Reject Deposit" href="/admin/reject/user/payment/<?php echo e($dep->id); ?>" > 
                                        <span class=""><i class="fa fa-ban text-warning" ></i></span>
                                    </a>                                    
                                    <?php if($adm->role == 3): ?>
                                        <a title="Approve Deposit" href="/admin/approve/user/payment/<?php echo e($dep->id); ?>" > 
                                            <span><i class="fa fa-check text-success"></i></span>
                                        </a>
                                        <a title="Delete Deposit" href="/admin/delete/user/payment/<?php echo e($dep->id); ?>" > 
                                            <span class=""><i class="fa fa-times text-danger"></i></span>
                                        </a>
                                    <?php endif; ?>
                                </td>                                                            
                                <td><?php echo e($dep->usn); ?></td>
                                <td><?php echo e($dep->currency); ?> <?php echo e($dep->amount); ?></td>                                
                                <td><?php echo e($dep->account_name); ?></td>
                                <td><?php echo e($dep->account_no); ?></td>
                                <td><?php echo e($dep->bank); ?></td>
                                <td><?php echo e(substr($dep->created_at, 0, 10)); ?></td>                               
                                <td>
                                    <?php if($dep->status == 0): ?>
                                        <?php echo e(__('messages.pending')); ?>

                                    <?php elseif($dep->status == 1): ?>
                                        <?php echo e(__('messages.apprv')); ?>

                                    <?php elseif($dep->status == 2): ?>
                                        <?php echo e(__('messages.rejctd')); ?>

                                    <?php endif; ?>
                                </td>   
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="" align="">
               <span> <?php echo e($deps->links()); ?></span>  
            </div> 
            <br><br>
        <?php /**PATH /home/gcibrokers/client.gcibrokers.net/core/resources/views/admin/temp/user_deposits.blade.php ENDPATH**/ ?>