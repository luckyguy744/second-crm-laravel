<?php
    $trans = App\fund_transfer::where('from_usr',$user->username)->orwhere('to_usr', $user->username)->orderby('id','desc')->get();
?>
<div class="table-responsive"><table id="basic-datatables" class="display table table-striped table-hover" >
        <thead>
            <tr>                
                <th><?php echo e(__('messages.sndr')); ?></th>
                <th><?php echo e(__('messages.reicvr')); ?></th>
                <th><?php echo e(__('messages.amnt')); ?></th>
                <th><?php echo e(__('messages.date')); ?></th>                                                    
            </tr>
        </thead>
        <tbody>
            
            <?php if(count($trans) > 0 ): ?>
                <?php $__currentLoopData = $trans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($activity->from_usr); ?></td>
                        <td><?php echo e($activity->to_usr); ?></td>
                        <td><?php echo e($settings->currency.' '.$activity->amt); ?></td>   
                        <td><?php echo e($activity->created_at); ?></td> 
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                
            <?php endif; ?>
        </tbody>
    </table>
</div>
       <?php /**PATH /home/gcibrokers/client.gcibrokers.net/core/resources/views/user/inc/transfer.blade.php ENDPATH**/ ?>