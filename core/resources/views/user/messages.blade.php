@include('user.inc.fetch')
@extends('layouts.atlantis.layout')
@Section('content')
		<div class="main-panel">
			<div class="content">
			    @php($breadcome = __('messages.msgs'))
				@include('user.atlantis.main_bar')
				<div class="page-inner mt--5">
					@include('user.atlantis.overview')
					<div id="prnt"></div>
					<div class="row ">
						<div class="col-md-4">
							<div class="card margin_btm_0">
								<div class="card-header">
									<div class="card-head-row">
										<div class="card-title headtext_blue"><i class="fa fa-bell fa-1x"></i>{{ __('messages.nots') }}</div>
									</div>
								</div>
								<div class="card-body msg_nf">									
									<div class="message-notif-scroll scrollbar-outer">
										<div class="notif-center" >
											@foreach($msgs as $msg) 
		                                        <?php 
		                                           
		                                            $rd = 0;
		                                            $str = explode(';', $msg->readers);   
		                                            $receiver = explode(';', $msg->users);                                         
		                                            if( in_array($user->username, $receiver) || empty($msg->users) )
		                                            {
		                                            	
		                                                $rd = 1;
		                                            	
		                                            }                                            
			                                                                                        
		                                        ?>
		                                        <div class="nf_line">
			                                        @if($rd == 1)   
			                                        	<a id="{{$msg->id}}" href="javascript:void(0)" onclick="read(this.id, 'yes')">
															<div class="float-left msg_not_icon" > 
																<i class="fa fa-bell"></i>
															</div>
															<div class="msg_listing">
																<b>{{ $msg->subject }}</b>
																<div class="time">
																	<i>{{ $msg->created_at }}</i>
																</div> 
																<div id="dis_not{{$msg->id}}" class="display_not">
																	<h3 class="text-center" align="center"><b>{!! $msg->subject !!}</b></h3>
																	<hr>
																	{!! $msg->message !!}
																</div>
															</div>
														</a>
			                                       
			                                        @endif
			                                    </div>
		                                    @endforeach
		                                </div>
		                            </div>

								</div>
							</div>
						</div>

						<div class="col-md-8 read_panel">							
							<div class="card margin_btm_0 message-notif-scroll scrollbar-outer read_panel_h">
								<div id="read_not" class="pt-3 p-3">
									@if(isset($msgID))
										<?php                                             
                                           $m = App\msg::find($msgID);

                                        ?>         
                                        <h4 align="center"><b>{!! $m->subject !!}</b></h4>
                                        <hr>                               
                                        <p>{!! $m->message !!}</p>
                                    @else
                                    	<div class="alert alert-info">{{__('messages.sel_nt')}}</div>
									@endif

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			@include('user.inc.confirm_inv')

@endSection
			