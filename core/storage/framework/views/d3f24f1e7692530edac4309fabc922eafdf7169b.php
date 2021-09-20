<?php echo $__env->make('user.inc.fetch', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('content'); ?>
        <div class="main-panel">
            <div class="content">
                <?php ($breadcome = __('messages.my_invstm')); ?>
                <?php echo $__env->make('user.atlantis.main_bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="page-inner mt--5">
                    <?php echo $__env->make('user.atlantis.overview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <div id="prnt"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title"><?php echo e(__('messages.my_invstm')); ?></div>                                       
                                    </div>
                                </div>
                                <div class="card-body ">  
                                    <div class="table-responsive web-table">
                                        <table class="display table table-hover" >
                                            <thead>
                                                <tr>
                                                    <th><?php echo e(__('messages.pckg')); ?></th>
                                                    <th><?php echo e(__('messages.cptl')); ?></th>
                                                    <th><?php echo e(__('messages.date')); ?></th> 
                                                    <th><?php echo e(__('messages.elps')); ?></th>  
                                                    <th><?php echo e(__('messages.days_spnt')); ?></th> 
                                                    <th><?php echo e(__('messages.sts')); ?></th>
                                                    <th><?php echo e(__('messages.tot_erng')); ?></th>  
                                                    <th><?php echo e(__('messages.actn')); ?></th> 
                                                </tr>
                                            </thead>
                                            <tbody class="web-table">                                                
                                                <?php if(count($actInv) > 0 ): ?>
                                                    <?php $__currentLoopData = $actInv; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $in): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php
                                                           
                                                            if($in->method == 1)
                                                            {
                                                                $totalElapse = getWorkingDays(date('Y-m-d'), $in->end_date);
                                                            }
                                                            else
                                                            {
                                                                $totalElapse = getDays(date('Y-m-d'), $in->end_date);
                                                            }
                                                            if($totalElapse == 0)
                                                            {
                                                                $lastWD = $in->last_wd;
                                                                $enddate = $in->end_date;

                                                                if($in->method == 1)
                                                                {
                                                                    $Edays = getWorkingDays($lastWD, $enddate);
                                                                    $totalDays = getWorkingDays($in->date_invested, $in->end_date);
                                                                }
                                                                else
                                                                {
                                                                    $Edays = getDays($lastWD, $enddate);
                                                                    $totalDays = getDays($in->date_invested, $in->end_date);
                                                                }

                                                                $ern  = $Edays*$in->interest*$in->capital;
                                                                $withdrawable = $ern;                                                                
                                                                $ended = "yes";
                                                            }
                                                            else
                                                            {
                                                                $lastWD = $in->last_wd;
                                                                $enddate = date('Y-m-d');                                                                
                                                                if($in->method == 1)
                                                                {
                                                                    $Edays = getWorkingDays($lastWD, $enddate);
                                                                    $totalDays = getWorkingDays($in->date_invested, date('Y-m-d'));
                                                                }
                                                                else
                                                                {
                                                                    $Edays = getDays($lastWD, $enddate);
                                                                    $totalDays = getDays($in->date_invested, date('Y-m-d'));
                                                                }
                                                                $ern  = $Edays*$in->interest*$in->capital;
                                                                $withdrawable = 0;
                                                                if ($Edays >= $in->days_interval)
                                                                {
                                                                    $withdrawable = $Edays*$in->interest*$in->capital;
                                                                }
                                                                $ended = "no";
                                                            }
                                                        ?>
                                                        <tr class="">
                                                            <td><?php echo e($in->package); ?></td>
                                                            <td><?php echo e(($settings->currency)); ?> <?php echo e($in->capital); ?></td>     
                                                            <td><?php echo e($in->date_invested); ?></td>
                                                            <td><?php echo e($in->end_date); ?></td> 
                                                            <td><?php echo e($totalDays); ?></td>
                                                            <td><?php echo e($in->status); ?></td>
                                                            <td><?php echo e($settings->currency); ?> <?php echo e(number_format((float)$ern, 2)); ?> </td>
                                                            <td>
                                                                <a title="<?php echo e(__('messages.wthdrw')); ?>" href="javascript:void(0)" class="btn btn-info" onclick="wd('pack', '<?php echo e($in->id); ?>', '<?php echo e($ern); ?>', '<?php echo e($withdrawable); ?>', '<?php echo e($Edays); ?>', '<?php echo e($ended); ?>')">
                                                                    <i class="fas fa-arrow-down"></i>
                                                                </a>                                                                
                                                            </td>           
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                        <div class="text-right col-md-12"><?php echo e($actInv->links()); ?></div>
                                    </div>

                                    <div class="mobile_table container messages-scrollbar" >
                                                    
                                        <?php if(count($actInv) > 0 ): ?>
                                            <?php $__currentLoopData = $actInv; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $in): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php

                                                    if($in->method == 1)
                                                    {
                                                        $totalElapse = getWorkingDays(date('Y-m-d'), $in->end_date);
                                                    }
                                                    else
                                                    {
                                                        $totalElapse = getDays(date('Y-m-d'), $in->end_date);
                                                    }
                                                    if($totalElapse == 0)
                                                    {
                                                        $lastWD = $in->last_wd;
                                                        $enddate = $in->end_date;

                                                        if($in->method == 1)
                                                        {
                                                            $Edays = getWorkingDays($lastWD, $enddate);
                                                            $totalDays = getWorkingDays($in->date_invested, $in->end_date);
                                                        }
                                                        else
                                                        {
                                                            $Edays = getDays($lastWD, $enddate);
                                                            $totalDays = getDays($in->date_invested, $in->end_date);
                                                        }

                                                        $ern  = $Edays*$in->interest*$in->capital;
                                                        $withdrawable = $ern;                                                                
                                                        $ended = "yes";
                                                    }
                                                    else
                                                    {
                                                        $lastWD = $in->last_wd;
                                                        $enddate = date('Y-m-d');                                                                
                                                        if($in->method == 1)
                                                        {
                                                            $Edays = getWorkingDays($lastWD, $enddate);
                                                            $totalDays = getWorkingDays($in->date_invested, date('Y-m-d'));
                                                        }
                                                        else
                                                        {
                                                            $Edays = getDays($lastWD, $enddate);
                                                            $totalDays = getDays($in->date_invested, date('Y-m-d'));
                                                        }
                                                        $ern  = $Edays*$in->interest*$in->capital;
                                                        $withdrawable = 0;
                                                        if ($Edays >= $in->days_interval)
                                                        {
                                                            $withdrawable = $Edays*$in->interest*$in->capital;
                                                        }
                                                        $ended = "no";
                                                    }

                                                ?>
                                                 
                                                <?php echo $__env->make('user.inc.mob_inv', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>                                
                                                
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            
                                        <?php endif; ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title"><?php echo e(__('messages.avail_pckg')); ?></div>
                                </div>
                                <div class="card-body pb-0">
                                    <?php echo $__env->make('user.inc.packages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                   
                    
                </div>
            </div>

    <?php echo $__env->make('user.inc.confirm_inv', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('user.inc.withdrawal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>
            
<?php echo $__env->make('layouts.atlantis.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gcibrokers/client.gcibrokers.net/core/resources/views/user/my_investment.blade.php ENDPATH**/ ?>