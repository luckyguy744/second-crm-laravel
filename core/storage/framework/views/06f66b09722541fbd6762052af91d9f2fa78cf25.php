<div class="panel-header bg-primary-gradient" >
	<div class="page-inner py-5" style="background-color: <?php echo e($settings->header_color); ?>">
		<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
			<div>
				<h2 class="text-white pb-2 fw-bold">					
					<?php echo e(__('messages.hi_wlcm_supadm')); ?>  <?php echo e(ucfirst($adm->name)); ?>					
				</h2>	
				<p class="text-white"><?php echo e(str_replace('/', ' > ', ucfirst(Request::path()))); ?></p>			
			</div>
			<div class="ml-md-auto py-2 py-md-0">
				<?php ($role = Session::get('adm')); ?>
                <?php if($role->role == 3): ?>
					<a href="/admin/manage/investments" class="btn btn-white btn-border btn-round mr-2"><?php echo e(__('messages.investments')); ?></a>
					<a href="/admin/manage/deposits" class="btn btn-secondary btn-round"><?php echo e(__('messages.dpst')); ?></a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div><?php /**PATH /home/gcibrokers/client.gcibrokers.net/core/resources/views/admin/atlantis/main_bar.blade.php ENDPATH**/ ?>