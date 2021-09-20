@include('user.inc.fetch')
@extends('layouts.atlantis.layout')
@Section('content')
        <div class="main-panel">
            <div class="content">
                @php($breadcome = __('messages.my_dwnlns'))
                @include('user.atlantis.main_bar')
                <div class="page-inner mt--5">
                    @include('user.atlantis.overview')
                    <div id="prnt"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title">                                            
                                            {{ __('messages.ref_link') }}
                                            <a href="/register/{{$user->username}}" class="text-danger" id="reflnk" >
                                                <small>{{env('APP_URL').__('/register/').$user->username}}</small>
                                            </a>                                            
                                        </div>                                       
                                    </div>
                                </div>                                
                            </div>
                        </div>                        
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">{{ __('messages.my_dwnlns') }}</div>
                                </div>
                                <div class="card-body pb-5">
                                    <?php
                                        $ref_levels = App\ref_set::all();
                                        $rsum = 0;
                                    ?>                    
                                        @foreach($ref_levels as $ref_level)
                                            <?php
                                                $activities = App\ref::where('username', $user->username)->where('level', $ref_level->id)->orderby('id', 'asc')->get();
                                                // $rsum += $activities
                                            ?>
                                            
                                            <div class="table-responsive mt-5">                                        
                                                <table id="basic-datatables" class="display table table-striped table-hover" >
                                                    <thead>
                                                        <tr>
                                                            <!-- <th data-field="state" data-checkbox="true"></th> -->
                                                            <th>{{ __('messages.nam') }}</th>
                                                            <th>{{ __('messages.username') }}</th>
                                                            <th>{{ __('messages.lvl') }}</th>
                                                            <th>{{ __('messages.amnt_ernd') }}</th>
                                                            <th>{{ __('messages.investments') }}</th>
                                                            <th>{{ __('messages.date_reg') }}</th>   
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                        @if(count($activities) > 0 )
                                                            @foreach($activities as $activity)
                                                                <?php  
                                                                    $ref_d = App\User::find($activity->user_id);                
                                                                ?>
                                                                <tr>                                                            
                                                                    <td>
                                                                        {{$ref_d->firstname}} {{$ref_d->lastname}}
                                                                    </td>
                                                                    <td>{{$ref_d->username}}</td>
                                                                    <td>{{$activity->level}}</td>
                                                                    <td>{{ env('CURRENCY').' '.$activity->amount}}</td>
                                                                    <td>
                                                                        <?php  
                                                                            $ref_inv = App\investment::where('user_id', $activity->user_id)->get();
                                                                            echo count($ref_inv);
                                                                        ?>
                                                                    </td>                                                            
                                                                    <td>{{substr($ref_d->created_at,0,10)}}</td>                     
                                                                </tr>
                                                                @php($rsum += $activity->amount)
                                                            @endforeach
                                                        @else
                                                            <tr>                                                    
                                                                <td colspan="6">{{ __('messages.no_data') }} </td>                     
                                                            </tr>
                                                        @endif
                                                    </tbody>                                                    
                                                </table>
                                                <br><br>
                                            </div>
                                                       
                                                    
                                        @endforeach   
                                   
                                                    
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            @include('user.inc.confirm_inv')

@endSection
            