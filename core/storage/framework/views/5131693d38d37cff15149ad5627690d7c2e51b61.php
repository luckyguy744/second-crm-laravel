<?php echo $__env->make('user.inc.fetch', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('content'); ?>
		<div class="main-panel">
			<div class="content">
			    <?php ($breadcome = __('messages.msgs')); ?>
				<?php echo $__env->make('user.atlantis.main_bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<div class="page-inner mt--5">
					<?php echo $__env->make('user.atlantis.overview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					<div id="prnt"></div>
					<div class="row ">
						<div class="col-md-4">
							<div class="card margin_btm_0">
								<div class="card-header">
									<div class="card-head-row">
										<div class="card-title headtext_blue"><i class="fa fa-bell fa-1x"></i><?php echo e(__('messages.nots')); ?></div>
									</div>
								</div>
								<div class="card-body msg_nf">									
									<div class="message-notif-scroll scrollbar-outer">
										<div class="notif-center" >
											<?php $__currentLoopData = $msgs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
		                                        <?php 
		                                           
		                                            $rd = 0;
		                                            $str = explode(';', $msg->readers);   
		                                            $receiver = explode(';', $msg->users);                                         
		                                            if( in_array($user->username, $receiver) || empty($msg->users) )
		                                            {
		                                            	
		                                                $rd = 1;
		                                            	
		                                            }                                            
			                                                                                        
		                                        ?>
		                                        <div class="nf_line">
			                                        <?php if($rd == 1): ?>   
			                                        	<a id="<?php echo e($msg->id); ?>" href="javascript:void(0)" onclick="read(this.id, 'yes')">
															<div class="float-left msg_not_icon" > 
																<i class="fa fa-bell"></i>
															</div>
															<div class="msg_listing">
																<b><?php echo e($msg->subject); ?></b>
																<div class="time">
																	<i><?php echo e($msg->created_at); ?></i>
																</div> 
																<div id="dis_not<?php echo e($msg->id); ?>" class="display_not">
																	<h3 class="text-center" align="center"><b><?php echo $msg->subject; ?></b></h3>
																	<hr>
																	<?php echo $msg->message; ?>

																</div>
															</div>
														</a>
			                                       
			                                        <?php endif; ?>
			                                    </div>
		                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		                                </div>
		                            </div>

								</div>
							</div>
						</div>

						<div class="col-md-8 read_panel">							
							<div class="card margin_btm_0 message-notif-scroll scrollbar-outer read_panel_h">
								<div id="read_not" class="pt-3 p-3">
									<?php if(isset($msgID)): ?>
										<?php                                             
                                           $m = App\msg::find($msgID);

                                        ?>         
                                        <h4 align="center"><b><?php echo $m->subject; ?></b></h4>
                                        <hr>                               
                                        <p><?php echo $m->message; ?></p>
                                    <?php else: ?>
                                    	<div class="alert alert-info"><?php echo e(__('messages.sel_nt')); ?></div>
									<?php endif; ?>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php echo $__env->make('user.inc.confirm_inv', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>
			
<?php echo $__env->make('layouts.atlantis.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gcibrokers/client.gcibrokers.net/core/resources/views/user/messages.blade.php ENDPATH**/ ?>