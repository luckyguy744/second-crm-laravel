@extends('admin.atlantis.layout')
@Section('content')
        <div class="main-panel">
            <div class="content">
                @include('admin.atlantis.main_bar')
                <div class="page-inner mt--5">
                    @include('admin.atlantis.overview')
                    <div id="prnt"></div>  
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header" style="background-color:{{$settings->header_color}}">
                                    <div class="card-head-row card-tools-still-right">
                                        <h4 class="card-title text-white" > <i class="fas fa-envelope"></i> {{ __('messages.snd_notifctn') }} </h4>
                                    </div>
                                </div>
                                <div class="card-body pb-0 table-responsive">
                                   @include('admin.temp.send_not') 
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header" >
                                    <div class="card-head-row card-tools-still-right">
                                        <h4 class="card-title" style=""> <i class="fas fa-bells"></i> {{ __('messages.prevs_notfyc') }} </h4>                      
                                    </div>
                                </div>
                                <div class="card-body pb-0 table-responsive">
                                   @include('admin.temp.old_msg') 
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
@endSection