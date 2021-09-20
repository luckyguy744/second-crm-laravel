<?php
    $st = App\site_settings::find(1);
?>
<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
	<title><?php echo e(__('messages.req_confirm')); ?></title>
</head>
<body>
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4" style="border:1px solid #CCC; padding:5%; ">
            <div align="">
        		<img src="<?php echo e(env('APP_URL')); ?>/img/<?php echo e($st->site_logo); ?>" style="height:100px; width:100px;" align="center">
        	</div>
        	<h3 align=""><?php echo e(__('messages.hi')); ?>, <?php echo e($md['usr']); ?>, </h3>
        	<p>
        	    <?php echo e(__('messages.reg_str_msg')); ?> <a href="<?php echo e(env('APP_URL')); ?>"><b><?php echo e(env('APP_NAME')); ?></b></a>
                <br>
        		<?php echo e(__('messages.reg_msg_cont')); ?>.
                <br><br>
        		<a class="btn btn-info" href="<?php echo e(env('APP_URL')); ?>/registration/confirm/<?php echo e($md['usr']); ?>/<?php echo e($md['token']); ?>">
                    <b><?php echo e(__('messages.confirm_reg')); ?></b>
                </a>
        	</p>
        	<p>
        		<i class="fa fa-certificate"></i><?php echo e(env('APP_NAME')); ?>.
        	</p>
        </div>
    </div>
	
</body>
</html><?php /**PATH /home/gcibrokers/client.gcibrokers.net/core/resources/views/mail/regconfirm.blade.php ENDPATH**/ ?>