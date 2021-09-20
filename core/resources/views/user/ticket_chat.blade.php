@include('user.inc.fetch')
@extends('layouts.atlantis.layout')
@Section('content')
        <div class="main-panel">
            <div class="content">
                @php($breadcome = __('messages.tkt_sprt'))
                @include('user.atlantis.main_bar')
                <div class="page-inner mt--5">                    
                    <div id="prnt"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title col-sm-12"  >{{ __('messages.tkt_chat') }}                                             
                                        </div>
                                    </div>
                                     
                                </div>
                                <div class="card-body position_relative" >                                    
                                    <div class='p-2 text-center bg_white chat_msg'>
                                        <strong>{{ __('messages.tkt_iss_msg')}}</strong><br>
                                        {{$ticket_view->msg}}
                                    </div>                                    
                                    <div class="pl-3 pr-3 chat_container">                                        
                                        <div id="chat_msg_container" class=" pt-1 chat_msg_container scroll scrollbar-inner "> 
                                            @if(!empty($ticket_view))
                                                @foreach($comments as $comment)
                                                    @if($comment->sender == "user")

                                                        <div class="row col-sm-12 d-flex justify-content-end">  
                                                            <div class="talk-bubble tri-right right-top">
                                                              <div class="talktext">
                                                                <p>
                                                                    {{$comment->message}} 
                                                                </p>
                                                                <p class="font_10 float-left"><i>{{$comment->created_at}}</i></p>
                                                              </div>
                                                            </div>  
                                                            <p class="mg_top_30">
                                                                <img src="/img/profile/{{$user->img }}" alt="..." class="avatar_chat rounded-circle">
                                                            </p>                                                                      
                                                        </div>                                                       
                                                    @else
                                                        <div class="row col-sm-12">
                                                            <p class="mg_top_30">
                                                               <img src="/img/logo.png" alt="..." class="avatar_chat rounded-circle">
                                                            </p>
                                                            <div class="talk-bubble tri-right left-top">
                                                              <div class="talktext">
                                                                <p class="p-0">
                                                                    {{$comment->message}}
                                                                </p>
                                                                <small class="font_10 p-0 float-right"><i>{{$comment->created_at}}</i></small>
                                                              </div>
                                                            </div>              
                                                        </div> 
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="col-sm-12 mt-5">
                                            <form id="comment_form" class="form-horizontal" method="POST" role="form" action="{{ route('ticket.comment') }}" >
                                                <div class="form-group {{ $errors->has('amount') ? ' has-error' : '' }}">
                                                    <div class="input-group"> 
                                                        <input id="ticket_id" type="hidden" class="form-control" name="ticket_id" value="{{$ticket_view->id}}" required autofocus>
                                                        <input type="text" id="msg_entry" class="form-control msg_entry" name="msg" autofocus placeholder="Your Message">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text btn_blue">
                                                                <button type="submit" class="btn btn_blue" onclick="post_comment('user')"><i class="fab fa-telegram-plane"></i></button>
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

            @include('user.inc.confirm_inv')

            <!-- Modal -->
            <div class="modal fade" id="open_ticket" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">{{ __('messages.open_tkt') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true" class="text-danger">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form class="form-horizontal" method="POST" role="form" action="{{ route('ticket.create') }}" >
                        @csrf
                        <div class="form-group {{ $errors->has('amount') ? ' has-error' : '' }}">
                            <label class="control-label">{{ __('messages.ttl') }}</label>                            
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pen-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" name="title" value="" required autofocus>                    
                            </div>
                        </div>
                        <div class="form-group ">
                            <label class="control-label">{{ __('messages.tkt_msg') }}</label>                            
                            <div class="input-group">                               
                                <textarea name="msg" class="form-control" required></textarea>                                                   
                            </div>
                        </div>
                        <div class="form-group">                                                                                                           
                            <button type="submit" class="btn btn-primary">{{ __('messages.tkt_sbmt') }}</button>  
                        </div>
                    </form>
                  </div>
                  
                </div>
              </div>
            </div>

<script type="text/javascript">    
    $(document).ready(function(){
        var timeout = 5000;
        setInterval(function() {
            load_chat();  
            $("#chat_msg_container").animate({ scrollTop: $('#chat_msg_container')[0].scrollHeight }, 1000);           
        }, timeout);
    }); 
    $("#chat_msg_container").animate({ scrollTop: $('#chat_msg_container')[0].scrollHeight }, 1000);                                                   
</script>

@endSection
            