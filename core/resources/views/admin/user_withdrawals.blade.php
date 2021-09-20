@php($wd = search_withdrawal())
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
                                        <h4 class="card-title text-white"> <i class="fas fa-arrow-alt-circle-down"></i> {{ __('messages.usr_wthdrwl') }} </h4>
                                        <div class="card-tools">
                                            <form action="/admin/search/Withdrawal" method="post">
                                                <div class="input-group">
                                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"> {{ __('messages.srch') }} </span>
                                                    </div>
                                                    <input type="text" name="search_val" class="form-control" placeholder="{{ __('messages.search_by') }}">
                                                    <div class="input-group-append">
                                                        <button class="btn"><i class="fa fa-search"></i></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>                                                                             
                                    </div>
                                </div>
                                <div class="card-body pb-0 table-responsive">
                                   @include('admin.temp.user_withdrawal') 
                                </div>
                                <div class="" align="">
                                    <span>
                                        {{$wd->links()}}
                                    </span>  
                                </div> 
                                <br><br>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>

@endSection