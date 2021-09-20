@php($deps = search_deposit())
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
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title col-sm-12"  >
                                            {{ __('messages.v_sprt_msg') }}                                             
                                        </div>
                                    </div>
                                     
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">                                        
                                        <table id="basic-datatables" class=" display  table table-striped table-hover" >
                                            <thead>
                                                <tr> 
                                                    <th>{{ __('messages.tckt_id') }}</th>
                                                    <th>{{ __('messages.user_id') }}</th> 
                                                    <th>{{ __('messages.ttl') }}</th>
                                                    <th>{{ __('messages.sts') }}</th>
                                                    <th>{{ __('messages.actn') }}</th>  
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                @if(!empty($tickets))
                                                    @foreach($tickets as $ticket)
                                                        <tr>
                                                            <td>{{$ticket->ticket_id}}</td>
                                                            <td>{{$ticket->user_id}}</td>
                                                            <td>{{$ticket->title}}</td>
                                                            <td>
                                                                @if($ticket->status == 0)
                                                                    {{__('Closed')}}
                                                                @elseif($ticket->status == 1)
                                                                    {{__('Open')}}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a title="View Chat" href="/support/{{$ticket->id}}" class="btn btn_blue">
                                                                    <i class="fab fa-teamspeak"></i>
                                                                    @if($ticket->state == 1 && $ticket->status != 0)
                                                                        @php($rd = 1)
                                                                    @endif
                                                                    @foreach($ticket->comments as $comment)
                                                                        @if($comment->state == 1 && $comment->sender != 'support')
                                                                            @php($rd = 1)
                                                                        @endif
                                                                    @endforeach
                                                                    @if(isset($rd) && $rd == 1)
                                                                        <i class="fa fa-circle new_not"></i>
                                                                        @php($rd = 0)
                                                                    @endif
                                                                </a>                                                                
                                                                @if($ticket->status == 0)
                                                                    <a title="Delete Ticket" href="{{ route('support.delete', $ticket->id) }}" class="btn btn-danger">
                                                                        <i class="fa fa-times"></i>
                                                                    </a>
                                                                @else
                                                                    <a title="Close Ticket" href="{{ route('support.close', $ticket->id) }}" class="btn btn-warning">
                                                                        <i class="fas fa-stop-circle"></i>
                                                                    </a>
                                                                @endif
                                                            </td>                                                                                 
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    
                                                @endif
                                            </tbody>
                                        </table>
                                        {{$tickets->links()}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
            </div>
@endSection