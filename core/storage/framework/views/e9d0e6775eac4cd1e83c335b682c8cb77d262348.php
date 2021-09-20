<div class="sparkline8-graph dashone-comment  dashtwo-messages">
    <div class="comment-phara">
        <div class="row comment-adminpr">
            <?php                
                $invs = App\packages::where('status', 1)->orderby('id', 'asc')->get();                
            ?>
            <?php if($user->phone != ''): ?>
                <?php if(isset($invs) && count($invs) > 0): ?>
                    <?php $__currentLoopData = $invs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-sm-4">
                            <div class="panel card pack-container" style="" align="center">
                                <div class="panel-head" style="">
                                    <h3 class="txt_transform"><?php echo e($inv->package_name); ?> <?php echo e(__('messages.pckg')); ?></h3>
                                </div>
                                <div class="" align="center" >
                                    <br>
                                        <h4 class="u_case" >
                                            <strong><?php echo e(__('messages.ivt_prd')); ?></strong>
                                        </h4>
                                        <div style="font-size: 40px;">
                                            <b>
                                                <?php echo e($inv->period); ?>

                                            </b>
                                        </div>
                                        <span class="pk_num">
                                            <?php if($inv->method == 0): ?>
                                                <?php echo e(__('messages.days')); ?>

                                            <?php endif; ?>
                                            <?php if($inv->method == 1): ?>
                                                <?php echo e(__('messages.wrk_days')); ?>

                                            <?php endif; ?>
                                        </span>
                                </div>
                                <span align="center">..............................</span>
                                <div class="" align="center" style="">
                                        <h4 class="u_case" >
                                            <strong><?php echo e(__('messages.min_invstm')); ?></strong>
                                        </h4>
                                        <span class="pk_num"><?php echo e($settings->currency); ?> <?php echo e($inv->min); ?></span>
                                        <h4 class="u_case">
                                            <strong><?php echo e(__('messages.max_invstm')); ?></strong>
                                        </h4>
                                        <span class="pk_num"><?php echo e($settings->currency); ?> <?php echo e($inv->max); ?></span>
                                </div>                                                    
                                
                                <span align="center">..............................</span>
                                <div class="" align="center">
                                    <h4 class="u_case">
                                        <strong><?php echo e(__('messages.tot_intst')); ?></strong>
                                    </h4>         
                                     <span class="pk_num"><?php echo e(round($inv->daily_interest*$inv->period*100, 2)); ?>%</span>
                                </div>
                                <div class="" align="center">
                                    <h4 class="u_case">
                                       <strong> <?php echo e(__('messages.wthdrwls_intvl')); ?></strong>
                                    </h4> 
                                    <span class="pk_num"><?php echo e($inv->days_interval); ?> <?php echo e(__('messages.days')); ?></span>
                                </div>
                                <div class="" align="center">
                                    <p><?php echo e(__('messages.capt_invst_elsp')); ?></p>
                                </div>
                                <div class="" align="center">
                                        <a id="<?php echo e($inv->id); ?>" href="javascript:void(0)" class="collcc btn btn-info" onclick="confirm_inv('<?php echo e($inv->id); ?>', '<?php echo e($inv->package_name); ?>', '<?php echo e($inv->period); ?>', '<?php echo e($inv->daily_interest); ?>', '<?php echo e($inv->min); ?>', '<?php echo e($inv->max); ?>', '<?php echo e($user->wallet); ?>')">
                                            <?php echo e(__('messages.invst')); ?>

                                        </a>
                                        <br><br>
                                </div>
    
                            </div>
                        </div>
                                                                          
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php else: ?>
                <div class="alert alert-warning">
                    <a href="/<?php echo e($user->username); ?>/profile#userdet"><?php echo e(__('messages.pls_udt_prf')); ?></a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div><?php /**PATH /home/gcibrokers/client.gcibrokers.net/core/resources/views/user/inc/packages.blade.php ENDPATH**/ ?>