<?php
    $user = Auth::User();  
    $myInv = App\investment::where('user_id', $user->id)->orderby('id', 'desc')->get();
    $actInv = App\investment::where('user_id', $user->id)->where('state', 0)->orderby('id', 'desc')->get();
?>


@extends('inc.layout')

@Section('content')

<body class="materialdesign">
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- Header top area start-->
    <div class="wrapper-pro">
        @include('inc.sidebar')
        <!-- Header top area start-->
        <div class="content-inner-all">
            <!-- header -->
            @include('inc.headbar')
            <!-- Header top area end-->

            <!-- searchbar-->
             @include('inc.searchbar')
            <!-- end searchbar -->

           
            
            <!-- income order visit user Start -->
                 @include('user.inc.act_summary')
            <!-- income order visit user End -->



            
            <div class="feed-mesage-project-area">
                <div class="container-fluid">
                    <div class="row">
                        
                        <div class="col-lg-8">
                            <div class="sparkline9-list shadow-reset mg-tb-30">
                                <div class="sparkline9-hd">
                                    <div class="main-sparkline9-hd">
                                        <h1>{{ __('messages.usr_actcts') }}</h1>
                                        <!-- <div class="sparkline9-outline-icon">
                                            <span class="sparkline9-collapse-link"><i class="fa fa-chevron-up"></i></span>
                                            <span><i class="fa fa-wrench"></i></span>
                                            <span class="sparkline9-collapse-close"><i class="fa fa-times"></i></span>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="sparkline9-graph dashone-comment">
                                    <div class="datatable-dashv1-list custom-datatable-overright dashtwo-project-list-data">
                                        <div id="toolbar1">
                                            <!-- <select class="form-control">
                                                <option value="">Export Basic</option>
                                                <option value="all">Export All</option>
                                                <option value="selected">Export Selected</option>
                                            </select> -->
                                            
                                        </div>
                                        <table id="table1" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-resizable="true" data-cookie="true" data-page-size="5" data-page-list="[5, 10, 15, 20, 25]" data-cookie-id-table="saveId" data-show-export="true">
                                            <thead>
                                                <tr>
                                                    <!-- <th data-field="state" data-checkbox="true"></th> -->
                                                    <th data-field="id">{{ __('messages.id') }}</th>
                                                    <th data-field="status" >{{ __('messages.actn') }}</th>
                                                    <th data-field="date" >{{ __('messages.date') }}</th>                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $activities = App\activities::where('user_id', $user->id)->get();

                                                ?>
                                                @if(count($activities) >0 )
                                                    @foreach($activities as $activity)
                                                        <tr>
                                                            <!-- <td></td> -->
                                                            <td>{{$activity->id}}</td>
                                                            <td>{{$activity->action}}</td>
                                                            <td>{{$activity->created_at}}</td>                     
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="sparkline8-list shadow-reset mg-tb-30">
                                <div class="sparkline8-hd">
                                    <div class="main-sparkline8-hd">
                                        <h1>{{ __('messages.ivt_pckgs') }}</h1>
                                        <!-- <div class="sparkline8-outline-icon">
                                            <span class="sparkline8-collapse-link"><i class="fa fa-chevron-up"></i></span>
                                            <span><i class="fa fa-wrench"></i></span>
                                            <span class="sparkline8-collapse-close"><i class="fa fa-times"></i></span>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="sparkline8-graph dashone-comment  dashtwo-messages">
                                    <div class="comment-phara">
                                        <div class="row comment-adminpr">
                                            <?php
                                                if($user->currency == 'N')
                                                {
                                                    $invs = App\packages::where('id', '!=', 3)->orderby('id', 'asc')->get();
                                                }
                                                elseif($user->currency == '$')
                                                {
                                                    $invs = App\packages::where('id', 3)->orderby('id','asc')->get();
                                                }

                                            ?>
                                            @if(isset($invs) && count($invs) > 0)
                                                @foreach($invs as $inv)
                                                    @include('user.inc.packages')                                                    
                                                @endforeach
                                            @else
                                                <div class="alert alert-warning">
                                                    {{ __('messages.updt_b4_ivt') }}
                                                </div>
                                            @endif
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-4">
                            <div class="sparkline8-list shadow-reset mg-tb-30">
                                <div class="sparkline8-hd">
                                    <div class="main-sparkline8-hd">
                                        <h1>{{ __('messages.msgs') }}</h1>
                                        <!-- <div class="sparkline8-outline-icon">
                                            <span class="sparkline8-collapse-link"><i class="fa fa-chevron-up"></i></span>
                                            <span><i class="fa fa-wrench"></i></span>
                                            <span class="sparkline8-collapse-close"><i class="fa fa-times"></i></span>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="sparkline8-graph dashone-comment messages-scrollbar dashtwo-messages">
                                    <div class="comment-phara">
                                        <div class="comment-adminpr">
                                            <a class="dashtwo-messsage-title" href="#"></a>
                                            <p class="comment-content">
                                               
                                            </p>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="feed-mesage-project-area">
                <div class="container-fluid">
                    <div class="row">
                        
                        <div class="col-lg-8">
                            
                                
                                
                            
                        </div>
                        <div class="col-lg-4">
                            
                        </div>
                    </div>
                </div>
            </div>




            
        </div>
    </div>

   
   @if (Session::has('info'))
   
    <script type="text/javascript">
        alert('{{Session::get("info")}}');
    </script>
    {{Session::forget('info')}}
   @endif

    <script type="text/javascript">
        var app = new Vue({
          el: '#app',
          data: {
            message: 'Hello Vue!'
          }
        })
    </script>
@endSection