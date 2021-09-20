<table class="display table table-stripped table-hover">
    <thead>
        <tr>                       
            <th> <?php echo e(__('messages.adm_name')); ?> </th>
            <th> <?php echo e(__('messages.admin_frm_email')); ?> </th>
            <th> <?php echo e(__('messages.rol')); ?> </th>
            <th> <?php echo e(__('messages.sts')); ?> </th>                        
            <th> <?php echo e(__('messages.mang')); ?> </th>                                                                          
        </tr>
    </thead>
    <tbody>        
        <?php if(count($adm_users) > 0 ): ?>
            <?php $__currentLoopData = $adm_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr> 
                    <td><?php echo e($dep->name); ?></td>
                    <td><?php echo e($dep->email); ?></td>
                    <td>
                        <?php if($dep->role == 1): ?>
                        <?php echo e($dep->role = "Support"); ?>

                        <?php elseif($dep->role == 2): ?>
                        <?php echo e($dep->role = "Manager"); ?>

                         <?php else: ?>
                         <?php echo e($dep->role = "Admin"); ?>

                        <?php endif; ?>
                    </td> 
                    <td><?php echo e($dep->status); ?></td>                   
                    <td>
                        <a title="Ban User" href="/admin/ban/admuser/<?php echo e($dep->id); ?>" > 
                            <span class=""><i class="fa fa-ban text-warnig" ></i></span>
                        </a>       
                        <a title="Activate User" href="/admin/activate/admuser/<?php echo e($dep->id); ?>" > 
                            <span><i class="fa fa-check text-success"></i></span>
                        </a>                             
                        <?php if($adm->role == 3): ?>                                        
                            <a title="Delete User" href="/admin/delete/admuser/<?php echo e($dep->id); ?>" > 
                                <span class=""><i class="fa fa-times text-danger"></i></span>
                            </a>
                        <?php endif; ?>
                    </td>
                                   
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <tr>                                                            
                <td><?php echo e(__('messages.no_data')); ?> </td>                                        
            </tr>
        <?php endif; ?>
    </tbody>
</table>
      <?php /**PATH /home/gcibrokers/client.gcibrokers.net/core/resources/views/admin/temp/admin.blade.php ENDPATH**/ ?>