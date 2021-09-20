@php($packs = search_pack())
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
                                        <h4 class="card-title text-white"> <i class="fas fa-briefcase"></i> {{ __('messages.ivt_pckgs') }} </h4>
                                        <div class="card-tools">
                                            <a href="/admin/create/package" class="btn btn-default"><i class="fa fa-plus"></i> {{ __('messages.add') }} </a>
                                        </div>                                                                       
                                    </div>
                                </div>
                                <div class="card-body pb-0 table-responsive">
                                   @include('admin.temp.inv_pack') 
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>

            @include('admin.inc.edit_pack')

@endSection