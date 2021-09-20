<?php
  $totalEarning = 0;    
  $currentEarning = 0;
  $workingDays = 0;
     
  foreach($actInv as $inv)
  {
    if($inv->method == 1)
    {
      $totalElapse = getWorkingDays(date('y-m-d'), $inv->end_date);
    }
    else
    {
      $totalElapse = getDays(date('y-m-d'), $inv->end_date);
    }

    if($totalElapse == 0)
    {
      $lastWD = $inv->last_wd;
      $enddate = ($inv->end_date);
      
      $getDays = getDays($lastWD, $enddate);

      if($inv->method == 1)
      {
        $getDays = getWorkingDays($lastWD, $enddate);
      }
      else
      {
        $getDays = getDays($lastWD, $enddate);
      }
      $currentEarning += $getDays*$inv->interest*$inv->capital;
      
    }
    else
    {
      $sd = $inv->last_wd;
      $ed = date('Y-m-d');
      $getDays = getDays($sd, $ed);

      if($inv->method == 1)
      {
        $getDays = getWorkingDays($sd, $ed);
      }
      else
      {
        $getDays = getDays($sd, $ed);
      }
      $currentEarning += $getDays*$inv->interest*$inv->capital;
    }
  }
?>

<div class="row mt--2">
	<div class="col-md-6">
		<div class="card full-height">
			<div class="card-body">
				<div class="card-title"><?php echo e(__('messages.ovral_stat')); ?></div>
				<div class="card-category"></div>
				<div class="d-flex flex-wrap justify-content-around pb-2 pt-4">
					<div class="px-2 pb-2 pb-md-0 text-center">
						<div id="circles-1"></div>
						<h6 class="fw-bold mt-3 mb-0"><?php echo e(__('messages.investments')); ?></h6>
					</div>
					<div class="px-2 pb-2 pb-md-0 text-center">
						<div id="circles-2"></div>
						<h6 class="fw-bold mt-3 mb-0"><?php echo e(__('messages.wthdrwls')); ?></h6>
					</div>
					<div class="px-2 pb-2 pb-md-0 text-center">
						<div id="circles-3"></div>
						<h6 class="fw-bold mt-3 mb-0"><?php echo e(__('messages.dwnlns')); ?></h6>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="card full-height">
			<div class="card-body">
				<div class="card-title"><h2><?php echo e(__('messages.bal')); ?></h2></div>
				<div class="row py-3">
					<div class="col-md-6 d-flex flex-column justify-content-around">
						<a id="wd_bal" title="Click to withdraw" href="javascript:void(0)" >
							<div class="border_btm">							
								<h4 class="fw-bold text-uppercase text-success op-8"><?php echo e(__('messages.walt')); ?></h4>
								<h3 class="fw-bold"><?php echo e($settings->currency); ?> <?php echo e(round($user->wallet, 2)); ?></h3>
								<div class="colhd margin_n10"><?php echo e(__('messages.clk_to_wthd_fnd')); ?></div>	
								<br>						
							</div>
						</a>
						<div class="clearfix"><br></div>
						<a id="wd_ref_bal" title="Click to withdraw" href="javascript:void(0)">
							<div>							
								<h4 class="fw-bold text-uppercase text-success op-8"><?php echo e(__('messages.refrrl_bns')); ?></h4>
								<h3 class="fw-bold"><?php echo e($settings->currency); ?> <?php echo e(round($user->ref_bal, 2)); ?></h3>
								<div class="colhd margin_n10" ><?php echo e(__('messages.clk_to_wthd_fnd')); ?></div>	
								<br>									
							</div>
						</a>
					</div>

					<div class="col-md-6">
            <a href="#">
  						<div class="border_btm">
  							<h4 class="fw-bold text-uppercase text-success op-8"><?php echo e(__('messages.erng')); ?></h4>
  							<h3 class="fw-bold"><?php echo e($settings->currency); ?> <?php echo e(round($currentEarning, 2)); ?></h3>
  							<div class="colhd margin_n10" >&emsp;</div>	
  							<br>	
  						</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="wallet_wd" class="container popmsgContainer" >
    <div class="row padding_per_2_2">
      <div class="col-md-4">&emps;</div>
      <div class="col-md-4 popmsg-mobile card" align="Center">        
        <div class="card-title">
          <br>
          <h3><b><?php echo e(__('messages.wallet_wdrl')); ?></b></h3>
          <h5 class="text-danger"><b><?php echo e(__('messages.av_bal')); ?></b></h5> 
          			<h3 class="fw-bold"><?php echo e($settings->currency); ?> <?php echo e(round($user->wallet, 2)); ?></h3>

          <hr>
        </div>
        <div class="card-body">
            <?php echo e(__('messages.bank_select_wdr')); ?>

            <form id="wd_formssss" action="/user/wallet/wd" method="post">
                <div class="form-group" align="left">                       
                    <input type="hidden" class="form-control" name="_token" value="<?php echo e(csrf_token()); ?>">
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend " >
                      <span class="input-group-text span_bg"><?php echo e($settings->currency); ?></span>
                    </div>                        
                    <input id="wd_amt" type="text" class="form-control" name="amt"  required placeholder="<?php echo e(__('messages.enter_amt')); ?>" >
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group" >                   
                    <div class="input-group-prepend " >
                      <span class="input-group-text span_bg"><i class="fa fa-home" ></i></span>
                    </div>
                    <select name="bank" class="form-control" required>
                        <?php 
                          $banks = App\banks::where('user_id', $user->id)->get();
                        ?>
                        <?php if(count($banks) > 0): ?>
                            <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option><?php echo e($bank->Account_name.' '.$bank->Account_number.' '.$bank->Bank_Name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <br><br>
                    <button class="collb btn btn-info"><?php echo e(__('messages.wthdrw')); ?></button>
                    <span style="">            
                      <a id="wallet_wd_close" href="javascript:void(0)" class="collcc btn btn-danger"><?php echo e(__('messages.cncl')); ?></a>        
                    </span>
                    <br>
                </div>
            </form>
        </div>  
        <!-- close btn -->
        <script type="text/javascript">
          $('#wallet_wd_close').click( function(){
            $('#wallet_wd').hide();
          });        
        </script>
        <!-- end close btn -->
      </div>

    </div>
</div>

<div id="ref_wd" class="container popmsgContainer" >
    <div class="row padding_per_2_2">
      <div class="col-md-4">&emps;</div>
      <div class="col-md-4 popmsg-mobile card" align="Center">        
        <div class="panel-heading" style="">
          <br>
          <h3><b><?php echo e(__('messages.ref_wdr')); ?></b></h3>
          <h5 class="text-danger"><b><?php echo e(__('messages.total_ern')); ?></b> <?php echo e($settings->currency.' '.$user->ref_bal); ?></h5>         
          <hr>
        </div>
        <div id="" >
              <?php echo e(__('messages.bank_select_wdr')); ?>

             <form id="wd_formssss" action="/user/ref/wd" method="post">
                <div class="form-group" align="left">                       
                    <input type="hidden" class="form-control" name="_token" value="<?php echo e(csrf_token()); ?>">
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend " >
                      <span class="input-group-text span_bg"><?php echo e($settings->currency); ?></span>
                    </div>                        
                    <input id="ref_amt" type="text" class="form-control" name="amt"  required placeholder="Enter Amount to withdraw" >
                  </div>
                </div>
                 <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend " >
                      <span class="input-group-text span_bg"><i class="fa fa-home"></i></span>
                    </div> 
                    <select name="bank" class="form-control" required>
                        <?php 
                          $banks = App\banks::where('user_id', $user->id)->get();
                        ?>
                          <?php if(count($banks) > 0): ?>
                              <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option><?php echo e($bank->Account_name.' '.$bank->Account_number.' '.$bank->Bank_Name); ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          <?php endif; ?>

                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <br><br>
                    <button class="collb btn btn-info"><?php echo e(__('messages.wthdrw')); ?></button>
                    <span style="">            
                      <a id="ref_wd_close" href="javascript:void(0)" class="collcc btn btn-danger"><?php echo e(__('messages.cncl')); ?></a>        
                    </span>
                    <br>
                </div>
            </form>
        </div> 
        <!-- close btn -->
        <script type="text/javascript">
          $('#ref_wd_close').click( function(){
            $('#ref_wd').hide();
          });        
        </script>
        <!-- end close btn -->

      </div>

    </div>
  </div><?php /**PATH /home/gcibrokers/client.gcibrokers.net/core/resources/views/user/atlantis/overview.blade.php ENDPATH**/ ?>