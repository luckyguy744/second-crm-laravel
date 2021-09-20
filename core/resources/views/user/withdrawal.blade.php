@include('user.inc.fetch')
@extends('layouts.atlantis.layout')
@Section('content')
        <div class="main-panel">
            <div class="content">
                @php($breadcome = __('messages.wthdrwl'))
                @include('user.atlantis.main_bar')
                <div class="page-inner mt--5">
                    @include('user.atlantis.overview')
                    <div id="prnt"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title">{{ __('messages.wthdrwl_hstry') }}</div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">                                        
                                        <table class="display table table-striped table-hover" >
                                            <thead>
                                                <tr>                                                   
                                                    <th>{{ __('messages.date') }}</th> 
                                                    <th>{{ __('messages.pckg') }}</th>
                                                    <th>{{ __('messages.act') }}</th>
                                                    <th>{{ __('messages.amnt') }}</th>                                                   
                                                    <th>{{ __('messages.sts') }}</th>                                  
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $activities = App\withdrawal::where('user_id', $user->id)->orderby('id', 'desc')->get();
                                                ?>
                                                @if(count($activities) > 0 )
                                                    @foreach($activities as $activity)
                                                        <tr>
                                                            <td>{{$activity->created_at}}</td>
                                                            <td>{{$activity->package}}</td>
                                                            <td>{{$activity->account}}</td>
                                                            <td>{{$settings->currency.' '.$activity->amount}}</td>
                                                            <td>{{$activity->status}}</td>
                                                                                 
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
            </div>

            @include('user.inc.confirm_inv')

@endSection
            