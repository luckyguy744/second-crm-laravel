<?php
    
    $actInv = App\investment::where('user_id', $user->id)->orderby('id', 'desc')->get();

    $refs = App\ref::where('username', $user->username)->orderby('id', 'desc')->get();
    $ref_amt = 0;
    foreach($refs as $ref)
    {
       $ref_amt += $ref->amount;
    }
    $ref_bal = $ref_amt - $user->ref_bal;

    $totalEarning = 0;   
    $currentEarning = 0;
    $workingDays = 0;
    

    foreach($actInv as $inv)
    {
        $totalElapse = getDays(date('y-m-d'), $inv->end_date);
        if($totalElapse == 0)
        {
            $lastWD = $inv->last_wd;
            $enddate = ($inv->end_date);
            $workingDays = getDays($lastWD, $enddate);
            $currentEarning += $workingDays*$inv->interest*$inv->capital;
        }
        else
        {
            $sd = $inv->last_wd;
            $ed = date('Y-m-d');
            $workingDays = getDays($sd, $ed);
            $currentEarning += $workingDays*$inv->interest*$inv->capital;
        }
    }
?>


<div class="table-responsive">            
    <table id="basic-datatables" class="display table table-striped table-hover">
        <thead class="web-table">
            <tr>                
               <th> <?php echo e(__('messages.pckg')); ?> </th>
               <th> <?php echo e(__('messages.cptl')); ?> </th>
               <th> <?php echo e(__('messages.ivt_return')); ?> </th>
               <th> <?php echo e(__('messages.dt_invstd')); ?> </th> 
               <th> <?php echo e(__('messages.elps')); ?> </th>  
               <th> <?php echo e(__('messages.days_spnt')); ?> </th> 
               <th> <?php echo e(__('messages.ivt_wdrn')); ?> </th>  
               <th> <?php echo e(__('messages.sts')); ?> </th>
               <th> <?php echo e(__('messages.erng')); ?> </th>                                   
            </tr>
        </thead>
        
        <tbody class="web-table">
            
            <?php if(count($actInv) > 0 ): ?>
                <?php $__currentLoopData = $actInv; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $in): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php

                        $totalElapse = getDays(date('y-m-d'), $in->end_date);
                        if($totalElapse == 0)
                        {
                            $lastWD = $in->last_wd;
                            $enddate = ($in->end_date);
                            $Edays = getDays($lastWD, $enddate);
                            $ern  = $Edays*$in->interest*$in->capital;
                            $withdrawable = $ern;
                                                                 
                            $totalDays = getDays($in->date_invested, $in->end_date);
                            $ended = "yes";

                        }
                        else
                        {
                            $lastWD = $in->last_wd;
                            $enddate = (date('Y-m-d'));
                            $Edays = getDays($lastWD, $enddate);
                            $ern  = $Edays*$in->interest*$in->capital;
                            $withdrawable = 0;
                            if ($Edays >= $in->days_interval)
                            {
                                $withdrawable = $in->days_interval*$in->interest*$in->capital;
                            }
                                                           
                            $totalDays = getDays($in->date_invested, date('Y-m-d'));
                            $ended = "no";
                        }

                    ?>
                    <tr class="">
                        <td><?php echo e($in->package); ?></td>
                        <td><?php echo e($in->capital); ?></td>
                        <td><?php echo e($in->i_return); ?></td>
                        <td><?php echo e($in->date_invested); ?></td>
                        <td><?php echo e($in->end_date); ?></td> 
                        <td>
                            <?php if($in->status != 'Expired'): ?>
                                <?php echo e($totalDays); ?>

                            <?php else: ?>
                                0
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($in->w_amt); ?></td> 
                        <td><?php echo e($in->status); ?></td>
                        <td>
                            <a title="Withdraw" href="javascript:void(0)" onclick="wdnone('<?php echo e($in->id); ?>', '<?php echo e($ern); ?>', '<?php echo e($withdrawable); ?>', '<?php echo e($Edays); ?>', '<?php echo e($ended); ?>')">
                                <?php echo e($user->currency); ?> <?php echo e($ern); ?>

                            </a>
                        </td>           
                    </tr>
                    
                    
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                
            <?php endif; ?>
        </tbody>
    </table>

    
</div>
    
<div class="mobile_table container messages-scrollbar" >
            <?php if(count($actInv) > 0 ): ?>
                <?php $__currentLoopData = $actInv; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $in): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php

                        $totalElapse = getDays(date('y-m-d'), $inv->end_date);
                        if($totalElapse == 0)
                        {
                            $lastWD = $in->last_wd;
                            $enddate = ($in->end_date);
                            $Edays = getDays($lastWD, $enddate);
                            $ern  = $Edays*$in->interest*$in->capital;
                            $withdrawable = $ern;
                                                                 
                            $totalDays = getDays($in->date_invested, $in->end_date);
                            $ended = "yes";

                        }
                        else
                        {
                            $lastWD = $in->last_wd;
                            $enddate = (date('Y-m-d'));
                            $Edays = getDays($lastWD, $enddate);
                            $ern  = $Edays*$in->interest*$in->capital;
                            $withdrawable = 0;
                            if ($Edays >= $in->days_interval)
                            {
                                $withdrawable = $in->days_interval*$in->interest*$in->capital;
                            }
                                                           
                            $totalDays = getDays($in->date_invested, date('Y-m-d'));
                            $ended = "no";
                        }

                    ?>
                        
                    <div class="alert alert-info margin_top_10 pad_top_0 font_14" >
                        <div class="row admin_usr_inv_row" >
                            <div class="col-xs-12 pad_top_5" align="center" >
                                <h4 class="u_case"> <?php echo e(__('messages.pckg :')); ?>  <?php echo e($in->package); ?></h4>
                               
                            </div>
                        </div> 
                        <div class="row color_blue_9">
                            <div class="col-xs-6">
                                <?php echo e(__('messages.cptl_c')); ?> 
                            </div>
                            <div class="col-xs-6">
                                <?php echo e($in->capital); ?>

                            </div>
                        </div> 
                        <div class="row" style="">
                            <div class="col-xs-6">
                                <?php echo e(__('messages.ivt_return')); ?> 
                            </div>
                            <div class="col-xs-6">
                                <?php echo e($in->i_return); ?>

                            </div>
                        </div>  
                        <div class="row" style="">
                            <div class="col-xs-6">
                                <?php echo e(__('messages.ivt_started')); ?> 
                            </div>
                            <div class="col-xs-6">
                                <?php echo e($in->date_invested); ?>

                            </div>
                        </div> 
                        <div class="row" style="">
                            <div class="col-xs-6">
                                <?php echo e(__('messages.ivt_ending')); ?> 
                            </div>
                            <div class="col-xs-6">
                                <?php echo e($in->end_date); ?>

                            </div>
                        </div>
                        <div class="row" style="">
                            <div class="col-xs-6">
                                <?php echo e(__('messages.ivt_days')); ?> 
                            </div>
                            <div class="col-xs-6">
                                <?php echo e($totalDays); ?>

                            </div>
                        </div>
                        <div class="row" style="">
                            <div class="col-xs-6">
                                <?php echo e(__('messages.ivt_wdrn')); ?> 
                            </div>
                            <div class="col-xs-6">
                                <?php echo e($in->w_amt); ?>

                            </div>
                        </div> 
                        <div class="row" style="">
                            <div class="col-xs-6">
                                <?php echo e(__('messages.sts :')); ?> 
                            </div>
                            <div class="col-xs-6">
                                <?php echo e($in->status); ?>

                            </div>
                        </div> 
                        <div class="row" style="">
                            <br>
                            <div class="col-xs-12" align="center">
                                <a title="Withdraw" href="javascript:void(0)" class="btn btn-info" onclick="wd('<?php echo e($in->id); ?>', '<?php echo e($ern); ?>', '<?php echo e($withdrawable); ?>', '<?php echo e($Edays); ?>', '<?php echo e($ended); ?>')">
                                    <?php echo e($user->currency); ?> <?php echo e($ern); ?>

                                </a>
                            </div>
                        </div>                                                                     
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                
            <?php endif; ?>
</div>
<?php /**PATH /home/gcibrokers/client.gcibrokers.net/core/resources/views/admin/temp/user_inv.blade.php ENDPATH**/ ?>