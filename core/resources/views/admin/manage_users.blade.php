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
                                    <h4 class="card-title text-white" > {{ __('messages.all_usrs') }} </h4>
                                    <div class="card-tools">
                                       <form action="/admin/search/user" method="post">
                                            <div class="input-group">
                                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"> {{ __('messages.srch') }} </span>
                                                </div>
                                                <input type="text" name="search_val" class="form-control" placeholder="{{ __('messages.search_by') }} ">
                                                <div class="input-group-append" style="padding: 0px;">
                                                    <button class="fa fa-search btn"></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>                                                                             
                                </div>
                                @php($users_table = search_users())                               
                                <p class="card-category text-white" > {{ __('messages.all_regstrd_usrs') }} </p>
                            </div>
                            <div class="card-body">
                                
                                <div class="table-responsive">
                                    <table id="" class="table  table-hover" >
                                        <thead>
                                            <tr>
                                                <th><i class="fa fa-eye"></i></th>
                                                <th>{{ __('messages.nam') }}</th>
                                                <th>{{ __('messages.username') }}</th>
                                                <th>{{ __('messages.admin_frm_email') }}</th>
                                                <th>{{ __('messages.phn') }}</th>
                                                <th>{{ __('messages.sts') }}</th>
                                            </tr>
                                        </thead>                                        
                                        <tbody>
                                            
                                            @if(count($users_table) > 0 )
                                                @foreach($users_table as $user)
                                                    <tr>
                                                        <td>
                                                            <a class="btn btn-info" href="/admin/view/userdetails/{{$user->id}}" title="{{ __('messages.v_usr_det') }}">
                                                                <i class="fa fa-eye"> VIEW</i>
                                                            </a>
                                                        </td>
                                                        <td>{{$user->firstname}} {{$user->lastname}}</td>
                                                        <td>{{$user->username}}</td>
                                                        <td>{{$user->email}}</td>  
                                                        <td>{{$user->phone}}</td>
                                                        <td>
                                                            @if($user->status == 1 || $user->status == 'Active')
                                                                {{'Active'}}
                                                             @elseif($user->status == 0 || $user->status == 'Not Active')
                                                             {{'Not Active'}}
                                                             @else
                                                             {{'Blocked'}}
                                                            @endif
                                                        </td>                                     
                                                    </tr>
                                                @endforeach
                                            @else
                                                
                                            @endif
                                        </tbody>
                                    </table>
                                    <div class="" align="">
                                       <span> {{$users_table->links()}}</span>  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endSection