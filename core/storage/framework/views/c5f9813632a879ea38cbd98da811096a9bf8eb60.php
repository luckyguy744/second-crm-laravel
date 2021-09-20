<?php echo $__env->make('user.inc.fetch', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-panel">
      <div class="content">
        <?php ($breadcome = __('messages.snd_fnd')); ?>
        <?php echo $__env->make('user.atlantis.main_bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="page-inner mt--5">
          <?php echo $__env->make('user.atlantis.overview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          <div id="prnt"></div>
          
          <div class="row">
            <div class="col-md-4">
              <?php if($settings->user_transfer == 1): ?>
                <div class="card">
                  <div class="card-header">
                    <div class="card-title"> <?php echo e(__('messages.fnd_trsfr')); ?> </div>
                  </div>
                  <div class="card-body pb-0">                 
                      <?php if(Session::has('err_send')): ?>
                          <div class="alert alert-danger">
                              <?php echo e(Session::get('err_send')); ?>

                          </div>
                          <?php echo e(Session::forget('err_send')); ?>

                      <?php endif; ?>
                      <div class="">                        
                          <form action="/user/send/fund" method="post" enctype="multipart/form-data">
                            <div class="form-group" align="left">                       
                                <input type="hidden" class="regTxtBox" name="_token" value="<?php echo e(csrf_token()); ?>">
                            </div>                                                    
                            <div class="input-group pad_top10" >
                              <div class="input-group-prepend" >
                                <span class="input-group-text "><i class="fa fa-user"></i></span>
                              </div>                        
                              <input type="text" class="form-control" name="usn"  required placeholder="<?php echo e(__('messages.username')); ?>" >
                            </div>
                            <div class="input-group pad_top10">
                              <div class="input-group-prepend" >
                                <span class=" input-group-text "><?php echo e($settings->currency); ?></span>
                              </div>                                                     
                              <input type="text" class="form-control" name="s_amt"  required placeholder="<?php echo e(__('messages.enter_amt_tosend')); ?>" >
                            </div>
                                          
                            <div class="form-group" align="">
                              <br><br>
                                <button class="btn btn_blue"><?php echo e(__('messages.send')); ?></button>
                                <br>
                            </div>                          
                          </form>  
                          <br><br>                    
                      </div>
                  </div>
                </div>
              <?php else: ?>
                <div class="alert alert-danger">
                  <?php echo e(__('messages.trn_fund_disble')); ?>

                </div>
              <?php endif; ?>
            </div>

            <div class="col-md-8">
              <div class="card">
                <div class="card-header">
                  <div class="card-title"><?php echo e(__('messages.trsfr_hstry')); ?> </div>
                </div>
                <div class="card-body">
                    <?php echo $__env->make('user.inc.transfer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
              </div>
            </div>
            
          </div> 

          <div class="row">
            
          </div>        
          
        </div>
      </div>

       <?php echo $__env->make('user.inc.confirm_inv', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.atlantis.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gcibrokers/client.gcibrokers.net/core/resources/views/user/send_money.blade.php ENDPATH**/ ?>