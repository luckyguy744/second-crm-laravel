<?php echo $__env->make('user.inc.fetch', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('content'); ?>
		<div class="main-panel">
			<div class="content">
			    <?php ($breadcome = __('messages.dasbrd')); ?>
				<?php echo $__env->make('user.atlantis.main_bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<div class="page-inner mt--5">
					<?php echo $__env->make('user.atlantis.overview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					<div id="prnt"></div>
					<div class="row">
						<div class="col-md-8">
							<div class="card">
								<div class="card-header">
									<div class="card-head-row">
										<div class="card-title"><?php echo e(__('messages.invstm_stat')); ?></div>
										<div class="card-tools">											
										</div>
									</div>
								</div>
								<div class="card-body">
									<div class="chart-container">
										<canvas id="statisticsChart2"></canvas>
									</div>
									<div id="myChartLegend2"></div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card card-primary">
								<div class="card-header">
									<div class="card-title"><?php echo e(__('messages.wthdrwl_stat')); ?> </div>
									<div class="card-category">
									    <?php
									        $total_wd = 0;
									        foreach($wd as $w)
									        {
    											$total_wd += $w->amount;
									        }
									    ?>
										<h1><?php echo e($settings->currency.' '. $total_wd); ?></h1>
									</div>
								</div>
								<div class="card-body pb-0">									
									<div class="pull-in">
										<canvas id="wd_stats"></canvas>
									</div>
								</div>
							</div>
							<div class="card">
								<div class="card-body pb-0">
									<div class="px-2 pb-2 pb-md-0 text-center">
										<div id="circles-logs"></div>
										<h6 class="fw-bold mt-3 mb-0"><?php echo e(__('messages.my_tot_actn')); ?></h6>
										<br>
									</div>									
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="card-title"><?php echo e(__('messages.avail_pckg')); ?> </div>
								</div>
								<div class="card-body pb-0">
									<?php echo $__env->make('user.inc.packages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
								</div>
							</div>
						</div>
					</div>

					<div class="row row-card-no-pd">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="card-head-row card-tools-still-right">
										<h4 class="card-title"><?php echo e(__('messages.usr_actcts')); ?></h4>
										<div class="card-tools">
											<button class="btn btn-icon btn-link btn-primary btn-xs"><span class="fa fa-angle-down"></span></button>
											<button class="btn btn-icon btn-link btn-primary btn-xs btn-refresh-card"><span class="fa fa-sync-alt"></span></button>
											<button class="btn btn-icon btn-link btn-primary btn-xs"><span class="fa fa-times"></span></button>
										</div>
									</div>
									<p class="card-category"><?php echo e(__('messages.all_actn_pfrm_by_u')); ?></p>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-12">
											<div class="card">												
												<div class="card-body">
													<div class="table-responsive">
														<table id="basic-datatables" class="display table table-striped 
														table-hover" >
															<thead>
																<tr>
																	<th><?php echo e(__('messages.actn')); ?></th>
																	<th><?php echo e(__('messages.date')); ?></th>
																</tr>
															</thead>															
															<tbody>																
																<?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																	<tr>
																		<td>
																			<?php echo e($log->action); ?>

																		</td>
																		<td><?php echo e($log->created_at); ?></td>
																	</tr>
																<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>																
															</tbody>
														</table>														
													</div>
													
												</div>
											</div>
										</div>
										
									</div>

								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>

			 <?php echo $__env->make('user.inc.confirm_inv', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>
			
<?php echo $__env->make('layouts.atlantis.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gcibrokers/client.gcibrokers.net/core/resources/views/user/index.blade.php ENDPATH**/ ?>