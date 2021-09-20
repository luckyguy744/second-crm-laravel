
            <table class="display table table-stripped table-hover">
                <thead>
                    <tr>
                       <th> <?php echo e(__('messages.adm_name')); ?> </th>
                       <th> <?php echo e(__('messages.pkg_min')); ?> </th>
                       <th> <?php echo e(__('messages.pkg_max')); ?> </th>
                       <th> <?php echo e(__('messages.intrs_precnt')); ?> </th>
                       <th> <?php echo e(__('messages.perd')); ?> </th>
                       <th> <?php echo e(__('messages.mthd')); ?> </th>
                       <th> <?php echo e(__('messages.wd_interval')); ?> </th>                       
                       <th> <?php echo e(__('messages.on_off')); ?> </th>
                       <th> <?php echo e(__('messages.mang')); ?> </th>                                                                          
                    </tr>
                </thead>
                <tbody>
                    
                    <?php if(count($packs) > 0 ): ?>
                        <?php $__currentLoopData = $packs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($dep->package_name); ?></td>
                                <td><?php echo e($dep->min); ?></td>
                                <td><?php echo e($dep->max); ?></td>
                                <td><?php echo e(round($dep->daily_interest*$dep->period*100,2)); ?></td>
                                <td><?php echo e($dep->period); ?></td>
                                <td>
                                  <?php if($dep->method == 1): ?>
                                    <?php echo e(__('messages.wrk_days')); ?>

                                  <?php elseif($dep->method == 0): ?>
                                    <?php echo e(__('messages.everyday')); ?>

                                  <?php endif; ?>
                                </td>
                                <td><?php echo e($dep->days_interval); ?></td>                                
                                <td>                                     
                                  <label class="switch" >
                                    <input type="checkbox" <?php if($dep->status == 1): ?><?php echo e('checked'); ?><?php endif; ?>>
                                    <span id="switch_pack<?php echo e($dep->id); ?>" class="slider round" onclick="act_deact_pack('<?php echo e($dep->id); ?>')"></span>
                                  </label>                                    
                                </td>
                                
                                <td>                                                                       
                                    <?php if($adm->role == 3 || $adm->role == 2): ?>
                                        <a id="<?php echo e($dep->id); ?>" title="Edit Package" href="javascript:void(0)" onclick="edit_pack(this.id, '<?php echo e($dep->min); ?>', '<?php echo e($dep->max); ?>', '<?php echo e(round($dep->daily_interest*$dep->period*100,2)); ?>', '<?php echo e($dep->withdrwal_fee); ?>', '<?php echo e(csrf_token()); ?>', '<?php echo e($dep->currency); ?>')"> 
                                            <span><i class="fa fa-edit btn btn-warning"></i></span>
                                        </a> 
                                        <a id="<?php echo e($dep->id); ?>" title="Delete Package" href="javascript:void(0)" onclick="load_get_ajax('/admin/delete/pack/<?php echo e($dep->id); ?>', this.id, 'admDeleteMsg') "> 
                                            <span><i class="fa fa-times btn btn-danger"></i></span>
                                        </a>
                                         
                                    <?php endif; ?>
                                </td>
                                               
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        
                    <?php endif; ?>
                </tbody>
            </table><?php /**PATH /home/gcibrokers/client.gcibrokers.net/core/resources/views/admin/temp/inv_pack.blade.php ENDPATH**/ ?>