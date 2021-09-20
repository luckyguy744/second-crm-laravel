@php($adm_users = search_adm())
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
                                        <h4 class="card-title text-white">{{ __('messages.adm_usrs') }}</h4>                                        
                                    </div>
                                    <p class="card-category text-white pl-2">
                                        {{ __('messages.all_adm_usrs') }}
                                    </p>
                                </div>
                                <div class="card-body">                    
                                    <div class="table-responsive">
                                        @include('admin.temp.admin')  
                                    </div>  
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header" style="background-color:{{$settings->header_color}}">
                                    <div class="card-head-row card-tools-still-right">
                                        <h4 class="card-title pl-2 text-white">{{ __('messages.add_nw_usrs') }}</h4>                                        
                                    </div>
                                    <p class="card-category text-white pl-2">
                                        {{ __('messages.cret_nw_admn_usrs') }}
                                    </p>
                                </div>
                                <div class="card-body">                    
                                    <div class="table-responsive">
                                        @include('admin.temp.add_new_admin')  
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
@endSection