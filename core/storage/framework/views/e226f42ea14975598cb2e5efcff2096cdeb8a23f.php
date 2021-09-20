<?php
    
    if(Session::has('val'))
    {
        $v = Session::get('val');
        $actInv = App\investment::where('user_id', $v)->orwhere('usn', 'like', '%'.$v.'%')->orwhere('capital', $v)->orwhere('status', $v)->orwhere('date_invested', 'like', '%'.$v.'%')->orderby('id', 'desc')->paginate(50);
        Session::forget('val');
    }
    else
    {
        $actInv = App\investment::orderby('id', 'desc')->paginate(50);
    }

?>
               
<table class="display table table-stripped table-hover">
    <thead>
        <tr>
            <th> <?php echo e(__('messages.actn')); ?> </th>
            <th> <?php echo e(__('messages.username')); ?> </th>
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
                        $ern  = intval($Edays)*floatval($in->interest)*intval($in->capital);
                        $withdrawable = $ern;
                                                             
                        $totalDays = getDays($in->date_invested, $in->end_date);
                        $ended = "yes";

                    }
                    else
                    {
                        $lastWD = $in->last_wd;
                        $enddate = (date('Y-m-d'));
                        $Edays = getDays($lastWD, $enddate);
                        $ern  = intval($Edays)*floatval($in->interest)*intval($in->capital);
                        $withdrawable = 0;
                        if ($Edays >= $in->days_interval)
                        {
                            $withdrawable = intval($in->days_interval)*intval($in->interest)*intval($in->capital);
                        }
                                                       
                        $totalDays = getDays($in->date_invested, date('Y-m-d'));
                        $ended = "no";
                    }

                ?>
                <tr class="">
                    <td>
                        <a title="Pause Investment" href="/admin/pause/user_inv/<?php echo e($in->id); ?>" > 
                            <span class=""><i class="fa fa-pause text-warning" ></i></span>
                        </a>                                    
                        <?php if($adm->role == 3): ?>
                            <a title="Activate Investment" href="/admin/activate/user_inv/<?php echo e($in->id); ?>" > 
                                <span><i class="fa fa-check text-success"></i></span>
                            </a>
                            <a title="Delete Investment" href="/admin/delete/user_inv/<?php echo e($in->id); ?>" > 
                                <span class=""><i class="fa fa-times text-danger"></i></span>
                            </a>
                        <?php endif; ?>
                    </td>   
                    <td><?php echo e($in->usn); ?></td>
                    <td><?php echo e($in->package); ?></td>
                    <td><?php echo e($in->currency); ?><?php echo e($in->capital); ?></td>
                    <td><?php echo e($in->currency); ?><?php echo e(round ($in->i_return, 2)); ?></td>
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
                        <?php if($in->currency == "" && $in->package != 'International'): ?>
                            N <?php echo e(round ($ern, 2)); ?> 
                        <?php elseif($in->currency == "" && $in->package = 'International'): ?>
                            $ <?php echo e(round ($ern, 2)); ?>

                        <?php else: ?>
                            <?php echo e($in->currency); ?> <?php echo e(round ($ern, 2)); ?>

                        <?php endif; ?>                              
                    </td>
                </tr>                            
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
        <?php else: ?>
            
        <?php endif; ?>
    </tbody>
    
</table>
<div class="" align="">
   <span> <?php echo e($actInv->links()); ?></span>  
</div><?php /**PATH /home/gcibrokers/client.gcibrokers.net/core/resources/views/admin/temp/user_invs.blade.php ENDPATH**/ ?>