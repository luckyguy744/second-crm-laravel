
<div id="succ" class="container popmsgContainer">
    <div class="row" style="padding: 5% 2%;">
      <div class="col-md-4">&emps;</div>

      <div class="col-md-4 popmsg-mobile" style=" border-radius: 7px; background-color: #FFF; min-height: 200px;" align="Center">
        <!-- <span style="float: right; margin-top: -40px; margin-right: -40px; z-index: 10; ">            
          <a id="succ_close" href="javascript:void(0)" class="btn btn-danger">X</a>        
        </span> -->
        <div class="panel-heading" style="">
          <h3>{{ __('messages.tkt_msg') }}</h3>               
          <hr>
        </div>
        <div id="" style="margin-top: -30px; padding: 15px">
                
                <p align="center" style="color:green">
                    <i class="fa fa-check-circle fa-4x"></i><br>
                      {{ __('messages.succfl') }}
                    <br>
                </p>
        </div>

        <div>
          <span style="">            
            <a id="succ_close" href="javascript:void(0)" class="btn btn-success"> {{ __('messages.msg_okay') }}</a>        
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
    <div class="row" style="padding: 5% 2%;">
      <div class="col-md-4">&emps;</div>

      <div class="col-md-4 popmsg-mobile" style="border-radius: 7px; background-color: #FFF; min-height: 200px;" align="Center">
        <!-- <span style="float: right; margin-top: -40px; margin-right: -40px; z-index: 10; ">            
          <a id="succ_close" href="javascript:void(0)" class="btn btn-danger">X</a>        
        </span> -->
        <div class="panel-heading" style="">
          <h3>{{ __('messages.tkt_msg') }}</h3>               
          <hr>
        </div>
        <div id="" style="margin-top: -30px; padding: 15px">
                
                <p align="center" style="color:#903;">
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

 


  <div id="readmsg" class="container popmsgContainer" style="">
    <div class="row" style="padding: 5% 2%;">
      <div class="col-md-4">&emps;</div>

      <div class="col-md-4 popmsg-mobile" style=" background-color: #FFF; padding: 0px; " align="Center">
        <!-- <span style="float: right; margin-top: -40px; margin-right: -40px; z-index: 10; ">            
          <a id="succ_close" href="javascript:void(0)" class="btn btn-danger">X</a>        
        </span> -->        
          <div class="sparkline8-list shadow-reset mg-tb-30" style="margin: 0px; border-radius: 7px; ">
              <div class="sparkline8-hd" >
                  <div class="main-sparkline8-hd">
                      <h1>{{ __('messages.read_msg') }}</h1>
                      <!-- <div class="sparkline8-outline-icon">
                          <span class="sparkline8-collapse-link"><i class="fa fa-chevron-up"></i></span>
                          <span><i class="fa fa-wrench"></i></span>
                          <span class="sparkline8-collapse-close"><i class="fa fa-times"></i></span>
                      </div> -->
                  </div>
              </div>
              <div class=" ">
                  <div class="" >
                      <div class="scroll" style="height: 300px; padding: 15px;">
                          <p id="msgC" align="justify">
                            
                          </p>                       

                      </div>
                      
                  </div>
                  
              </div>
          
        </div>

        <div>
          <span style=""> 
          <br>           
            <a id="readmsg_close" href="javascript:void(0)" class="btn btn-danger">{{ __('messages.close') }}</a>        
          </span>
          <br><br>
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