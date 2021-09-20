<div class="sparkline9-list shadow-reset mg-tb-30">    
    <div class="sparkline9-graph dashone-comment">
        <div class="datatable-dashv1-list custom-datatable-overright dashtwo-project-list-data">
            <form action="/admin/addNew/admin" method="post">
              <input id="token" type="hidden" class="form-control" name="_token" value="<?php echo e(csrf_token()); ?>">
              
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text " ><i class="fa fa-user"></i></span>
                </div>
                  <input type="text" class="form-control" name="Name" placeholder="<?php echo e(__('messages.entr_sff_name')); ?>" required>
              </div>
              <br>
              <div class="input-group">  
                <div class="input-group-prepend">              
                  <span class="input-group-text "><i class="fa fa-envelope"></i></span>
                </div>
                  <input id="" type="email" class="form-control" name="email" placeholder="<?php echo e(__('messages.entr_stf_email')); ?>" required>
              </div>
              <br>
              <div class="input-group"> 
                <div class="input-group-prepend">               
                  <span class="input-group-text "><i class="fa fa-key"></i></span>
                </div>
                  <input id="" type="password" class="form-control" name="pwd" placeholder="<?php echo e(__('messages.entr_pwd')); ?>" required>
              </div>
              <br>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text "><i class="fa fa-user"></i></span>
                </div>
                                    
                  <select name="role" class="form-control" required>
                      <option selected disabled=""><?php echo e(__('messages.sel_role')); ?></option>
                      <option value="1"><?php echo e(__('messages.suprt')); ?></option>
                      <option value="2"><?php echo e(__('messages.mngr')); ?></option>
                      <option value="3"><?php echo e(__('messages.admn')); ?></option>
                  </select>
              </div>
              <br>
              
              <div class="form-group">
                <br>
                  <button class="collb btn btn-info"><?php echo e(__('messages.add_adm_dod')); ?></button>
                  <br>
              </div>              
            </form>
        </div>
    </div>
</div><?php /**PATH /home/gcibrokers/client.gcibrokers.net/core/resources/views/admin/temp/add_new_admin.blade.php ENDPATH**/ ?>