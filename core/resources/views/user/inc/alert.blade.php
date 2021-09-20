<div id="succ" class="container popmsgContainer">
    <div class="row wd_row_pad">
      <div class="col-md-4">&emps;</div>
      <div class="col-md-4 popmsg-mobile pop_msg_col" align="Center">
        <div class="panel-heading">
          <h3>{{ __('messages.tkt_msg') }}</h3>               
          <hr>
        </div>
        <div class="pop_msg_contnt">                
          <p align="center" class="textd-success">
              <i class="fa fa-check-circle fa-4x"></i><br>
              <span id="succ_msg"></span>
              <br>
          </p>
        </div>

        <div>
          <span style="">            
            <a id="succ_close" href="javascript:void(0)" class="btn btn-success">{{ __('messages.msg_okay') }}</a>        
          </span>
          <br><br><br><br>
        </div>
        <!-- close btn -->
        <script type="text/javascript">
          $('#succ_close').click( function(){
            $('#succ').hide();
          });        
        </script>
        <!-- end close btn -->
      </div>

    </div>
  </div>

  <div id="errr" class="container popmsgContainer" >
    <div class="row wd_row_pad" >
      <div class="col-md-4">&emps;</div>
      <div class="col-md-4 popmsg-mobile pop_msg_col"  align="Center">
        <div class="panel-heading" style="">
          <h3>{{ __('messages.tkt_msg') }}</h3>               
          <hr>
        </div>
        <div class="pop_msg_contnt">                
            <p align="center" class="text-danger">
                <i class="fa fa-ban fa-4x"></i><br>
                <span id="errr_msg"></span>
                <br>
            </p>
        </div>

        <div>
          <span style="">            
            <a id="errr_close" href="javascript:void(0)" class="btn btn-danger">{{ __('messages.msg_okay') }}</a>        
          </span>
          <br><br><br><br>
        </div>
        <!-- close btn -->
        <script type="text/javascript">
          $('#errr_close').click( function(){
            $('#errr').hide();
          });        
        </script>
        <!-- end close btn -->
      </div>

    </div>
  </div>
  
  <div id="readmsg" class="container popmsgContainer" >
    <div class="row wd_row_pad">
      <div class="col-md-4">&emps;</div>
      <div class="col-md-4 popmsg-mobile pop_read_msg"  align="Center">
            <span class="">            
                <a id="readmsg_close" href="javascript:void(0)" class="btn btn-danger">{{ __('X') }}</a>        
            </span>   
          <div class="sparkline8-list shadow-reset mg-tb-30" >
              <div class="sparkline8-hd" >
                  <div class="main-sparkline8-hd">
                      <h1>{{ __('messages.read_msg') }}</h1>
                  </div>
              </div>
              <div class="">
                  <div class="" >
                      <div class="scroll pop_scroll_height" >
                          <p id="msgC" align="justify">
                            
                          </p>
                      </div>
                      
                  </div>
                  
              </div>
          
        </div>

        <!-- close btn -->
        <script type="text/javascript">
          $('#readmsg_close').click( function(){
            $('#readmsg').hide();
          });        
        </script>
        <!-- end close btn -->

      </div>

    </div>
  </div>