<?php
    $acts = App\adminLog::orderby('id', 'desc')->paginate(50);
?>

<table id="basic-datatables" class="display table table-stripped table-hover">
    <thead>
        <tr>            
            <th> <?php echo e(__('messages.id')); ?> </th>
            <th> <?php echo e(__('messages.admn')); ?> </th>
            <th> <?php echo e(__('messages.actn')); ?> </th>
            <th> <?php echo e(__('messages.date')); ?> </th>                                                              
        </tr>
    </thead>
    <tbody>
        <?php if(count($acts) > 0 ): ?>
            <?php $__currentLoopData = $acts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>                                                            
                    <td><?php echo e($dep->id); ?></td>
                    <td><?php echo e($dep->admin); ?></td>
                    <td><?php echo e($dep->action); ?></td>
                    <td><?php echo e($dep->created_at); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <tr>                                                            
                <td><?php echo e(__('messages.no_data')); ?></td>                                        
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<!--<div align="center">-->
<!--   <span> <?php echo e($acts->links()); ?></span>  -->
<!--</div>--><?php /**PATH /home/gcibrokers/client.gcibrokers.net/core/resources/views/admin/temp/user_log.blade.php ENDPATH**/ ?>