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
                                        <h4 class="card-title text-white"> 
                                            <i class="fas fa-plus"></i>{{ __('messages.add_ivt_pck') }} 
                                        </h4>
                                    </div>
                                </div>
                                <div class="card-body pb-0 table-responsive">
                                   <form id="add_new_pack" action="/admin/create/package" method="post" >
                                       @csrf()
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label for="package_name">{{ __('messages.pckg_name') }}</label>
                                                <input id="package_name" type="text" class="regTxtBox" name="package_name" value="" required autocomplete="package_name" autofocus placeholder="{{ __('messages.pckg_name') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <label for="min">{{ __('messages.min_ivt_val') }}</label>
                                                <input id="min" type="number" class="regTxtBox" name="min" value="" required autocomplete="min" autofocus placeholder="{{ __('messages.min_ivt_val') }}">
                                            </div>
                                             <div class="col-sm-6">
                                                <label for="max" class="">{{ __('messages.max_ivt_val') }}</label>
                                                <input id="max" type="number" class="regTxtBox" name="max" value="" required autocomplete="max" autofocus placeholder="{{ __('messages.max_ivt_val') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label for="daily_interest">{{ __('messages.pckg_interest') }}</label>
                                                <input id="daily_interest" step="0.1" type="number" class="regTxtBox" name="interest" value="" required autocomplete="daily_interest" autofocus placeholder="{{ __('messages.pckg_interest') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <label for="period">{{ __('messages.total_prd_ivt') }}</label>
                                                <input id="period" step="1" type="number" class="regTxtBox" name="period" value="" required autocomplete="period" autofocus placeholder="{{ __('messages.total_prd_ivt') }}">
                                            </div>
                                             <div class="col-sm-6">
                                                <label for="interval" class="">{{ __('messages.wdr_interval') }}</label>
                                                <input id="interval" type="number" class="regTxtBox" name="interval" value="" required autocomplete="interval" autofocus placeholder="{{ __('messages.wdr_interval') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label for="period">{{ __('messages.ivt_method') }}</label>
                                                <select name="inv_method" class="regTxtBox" required>
                                                    <option disabled selected>{{ __('messages.sel_method') }}</option>
                                                    <option value="0">{{ __('messages.cal_int_evry_day') }}</option>
                                                    <option value="1">{{ __('messages.cal_int_wrk_days') }}</option>
                                                </select>
                                            </div>                                             
                                        </div>
                                   </form>
                                   <div class="form-group row">
                                        <div class="col-sm-12 text-center">
                                            <br><br>
                                            <button class="btn btn-info btn_form" onclick="load_post_ajax('/admin/create/package', 'add_new_pack', 'add_pack')"><i class="fa fa-plus"></i> {{ __('messages.add') }} </button>
                                        </div>
                                    </div>
                                   
                                   <br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>

@endSection