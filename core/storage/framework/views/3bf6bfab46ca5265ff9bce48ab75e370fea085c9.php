<?php
$msgs = App\msg::orderby('id', 'desc')->paginate(50); ?>
<table id="" class=" table table-stripped table-hover">
    <thead>
        <tr>
            <th>Subject</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $msgs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($msg->subject); ?></td>
                <td><?php echo e($msg->created_at); ?></td>
                <td>
                    <span>
                        <a id="<?php echo e($msg->id); ?>" href="javascript:void(0)"
                            onclick="load_get_ajax('/admin/message/edit/<?php echo e($msg->id); ?>', this.id, 'admEditMsg')">
                            <i class="fas fa-edit text-warning"></i>
                        </a>
                        <a id="<?php echo e($msg->id); ?>" href="javascript:void(0)"
                            onclick="load_get_ajax('/admin/message/delete/<?php echo e($msg->id); ?>', this.id, 'admDeleteMsg')">
                            <i class="fas fa-times text-danger"></i>
                        </a>
                    </span>
                    <div id="msg_cnts<?php echo e($msg->id); ?>" class="cont_display_none">
                        <?php echo $msg->message; ?>

                    </div>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<br><br>

<div id='del_msg_lang' class="cont_display_none">
    <?php echo e(__('messages.suc_msg')); ?>

</div>
<?php /**PATH /home/gcibrokers/client.gcibrokers.net/core/resources/views/admin/temp/old_msg.blade.php ENDPATH**/ ?>