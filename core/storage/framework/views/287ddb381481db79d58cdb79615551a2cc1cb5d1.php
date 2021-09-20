<div id="div_withdrawal" class="container popmsgContainer" >
    <div class="row wd_row_pad" >
      <div class="col-md-4">&emps;</div>
      <div class="col-md-4 card popmsg-mobile pop_invest_col" align="Center">        
        <div class="card-header" style="">
          <h3> <?php echo e(__('messages.wthdrwl')); ?> </h3>
          <h5><?php echo e(__('messages.total_ern')); ?> <?php echo e($settings->currency); ?> <span id="earned"></span></h5>  
          <small>Days: <span id="days" class="text-danger" ></span></small>     
        </div>
        <div class="card-body pt-0" >                
          
          <form id="wd_formssss" action="/user/wdraw/earning" method="post">
              <div class="form-group" align="left">                       
                  <input type="hidden" class="form-control" name="_token" value="<?php echo e(csrf_token()); ?>">
                  <input id="inv_id" type="hidden" class="form-control" name="p_id" value="">
                  <input id="ended" type="hidden" class="form-control" name="ended" value="">
              </div>
              <div align="left">
                <label><?php echo e(__('messages.wthdrbl_amnt')); ?> </label>
              </div>
              <div class="input-group">                
                <div class="input-group-prepend " >
                  <span class="input-group-text " ><?php echo e($settings->currency); ?></span>
                </div>                                     
                <input id="withdrawable_amt" type="text" value="" readonly class="bg_white form-control" name="amt"  required >
              </div>
              <div class="form-group">
                <br><br>
                  <button class="btn btn-info"> <?php echo e(__('messages.wthdrw')); ?> </button>
                  <span style="">            
                    <a id="div_withdrawal_close" href="javascript:void(0)" class="btn btn-danger"> <?php echo e(__('messages.cncl')); ?> </a>        
                  </span>
                  <br>
              </div>
          </form>
        </div>
        <!-- close btn -->
        <script type="text/javascript">
          $('#div_withdrawal_close').click( function(){
            $('#div_withdrawal').hide();
          });        
        </script>
        <!-- end close btn -->
      </div>

    </div>
  </div><?php /**PATH /home/gcibrokers/client.gcibrokers.net/core/resources/views/user/inc/withdrawal.blade.php ENDPATH**/ ?>