@php($deps = search_deposit())
@extends('admin.atlantis.layout')
@Section('content')
        <div class="main-panel">
            <div class="content">
                @include('admin.atlantis.main_bar')
                <div class="page-inner mt--5">
                   
                    <div id="prnt"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title col-sm-12"  >{{ __('messages.tkt_chat') }} 
                                            <!-- <span class="float-right"><a data-target="#open_ticket" data-toggle="modal" href="javascript:void(0)" class="btn btn_blue text-white"><i class="fas fa-plus-circle "></i> Open Ticket</a></span> -->
                                        </div>
                                    </div>
                                     
                                </div>
                                <div class="card-body position_relative" >                                    
                                    <div class='p-2 text-center bg_white chat_msg'>
                                        <strong>{{ __('messages.tkt_iss_msg') }}</strong><br>
                                        {{$ticket_view->msg}}
                                    </div>                                    
                                    <div class="pl-3 pr-3 chat_container">                                        
                                        <div id="chat_msg_container" class=" pt-1 chat_msg_container pl-4 scroll" > 
                                            @if(!empty($ticket_view))
                                                @foreach($comments as $comment)
                                                    @if($comment->sender == "user")
                                                        <div class="row col-sm-12">
                                                            <p class="mg_top_30">
                                                                <img src="/img/profile/{{$user->img }}" alt="..." class="avatar_chat rounded-circle">
                                                            </p>
                                                            <div class="talk-bubble tri-right left-top">
                                                              <div class="talktext">
                                                                <p>
                                                                    {{$comment->message}} 
                                                                </p>
                                                                <p class="font_10 float-right"><i>{{$comment->created_at}}</i></p>
                                                              </div>
                                                            </div>  
                                                            
                                                        </div> 
                                                    @else
                                                        <div class="row col-sm-12 d-flex justify-content-end">
                                                            <div class="talk-bubble tri-right right-top ">
                                                              <div class="talktext">
                                                                <p class="p-0">
                                                                    {{$comment->message}}
                                                                </p>
                                                                <small class="font_10 p-0"><i>{{$comment->created_at}}</i></small>
                                                              </div>
                                                            </div>
                                                            <p class="mg_top_30">
                                                               <img src="/img/logo.png" alt="..." class="avatar_chat rounded-circle">
                                                            </p>             
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="col-sm-12 mt-5">
                                            <form id="comment_form" class="form-horizontal" method="POST" role="form" action="{{ route('support.comment') }}" >
                                                <div class="form-group {{ $errors->has('amount') ? ' has-error' : '' }}">
                                                    <div class="input-group"> 
                                                        <input id="ticket_id" type="hidden" class="form-control" name="ticket_id" value="{{$ticket_view->id}}" required autofocus>
                                                        <input id="msg_entry" type="text" class="form-control msg_entry" name="msg" autofocus placeholder="{{ __('messages.yr_msg') }} ">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text btn_blue">
                                                                <button type="submit" onclick="post_comment('support')" class="btn btn_blue"><i class="fab fa-telegram-plane"></i></button>
                                                            </span>
                                                        </div>                   
                                                    </div>
                                                </div>                                            
                                                <div class="form-group">                                                                                
                                                     
                                                </div>
                                            </form>
                                            <audio id="buzzer" src="/sound/swiftly.mp3" type="audio/mp3"></audio> 
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
<script type="text/javascript">    
    $(document).ready(function(){
        var timeout = 5000;
        setInterval(function() {
            load_chat_adm();
            $("#chat_msg_container").animate({ scrollTop: $('#chat_msg_container')[0].scrollHeight }, 1000); 
        }, timeout);
        $("#chat_msg_container").animate({ scrollTop: $('#chat_msg_container')[0].scrollHeight }, 1000); 
    });                                                    
</script>
@endSection