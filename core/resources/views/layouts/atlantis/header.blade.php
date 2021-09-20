	<div class="wrapper">
		<div class="main-header">
			<!-- Logo Header -->
			<div class="logo-header" style="background-color: {{$settings->header_color}}">				
				<a href="/user/dashboard" class="text-white">
                    <img src="/img/{{$settings->site_logo}}" alt="{{$settings->site_title}}" class="header_logo" align="center"/>
                     <span id="title_collapse font_20" > {{$settings->site_title}}</span> 
                </a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i class="icon-menu text-white"></i>
					</span>
				</button>
				<button class="topbar-toggler more text-white"><i class="icon-options-vertical text-white"></i></button>
				<div class="nav-toggle">
					<button class="btn btn-toggle toggle-sidebar" onclick="title_collapse()">
					    &emsp; <i class="icon-menu text-white"></i>
					</button>
				</div>
				<script type="text/javascript">
					function title_collapse()
					{
						$("#title_collapse").toggle();
					}
				</script>
			</div>
			<!-- End Logo Header -->

			<!-- Navbar Header -->
			<nav class="navbar navbar-header navbar-expand-lg" style="background-color: {{$settings->header_color}}">
				
				<div class="container-fluid">
					<div class="collapse" id="search-nav">
						<form class="navbar-left navbar-form nav-search mr-md-3">							
						</form>
					</div>
					<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
						<li class="nav-item dropdown hidden-caret">
							<a class="dropdown-toggle text-white" data-toggle="dropdown" href="#" aria-expanded="false">
								<i class="fa fa-flag"></i> 
								@if(Session::has('locale'))
									{{ strtoupper(Session::get('locale')) }}
								@else
									{{ __('EN') }}
								@endif	
								&emsp;				
							</a>
							<ul class="dropdown-menu dropdown-adm animated fadeIn">
								<?php
                                    $activities = $lang;
                                ?>
                                @if(count($activities) > 0 )
                                    @foreach($activities as $activity)
                                        <li>
											<a class="dropdown-item" href="{{ url('locale/'.$activity->lang_code) }}">
												<span class="fa fa-flag"></span> &nbsp;{{ $activity->lang_name }}
											</a>
										</li>
                                    @endforeach
                                @else
                                    
                                @endif																
																
							</ul>
						</li>
						<li class="nav-item dropdown hidden-caret">
							<a class=" dropdown-toggle" href="#" id="messageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<?php                                  
	                                $msgs = App\msg::orderby('id', 'desc')->take(5)->get();
	                            ?>								
								<i class="fa fa-bell not_cont text-white">
									@foreach($msgs as $msg) 
                                        <?php 
                                            $rd = 0;
                                            $str = explode(';', $msg->readers);   
                                            $receiver = explode(';', $msg->users);                                         
                                            if( in_array($user->username, $receiver) || empty($msg->users) )
                                            {
                                            	if(!in_array($user->id, $str))
                                            	{
                                                	$rd = 1;
                                            	}
                                            }                                            
                                        ?>
                                        @if($rd == 1)   
                                        	<i class="fa fa-circle new_not"></i>
                                        @endif
                                    @endforeach
									
								</i> <span class="text-white"> {{ __('messages.nots') }} </span><i class="fa fa-chevron-down text-white"></i>
								&emsp;	
							</a>
							<ul class="dropdown-menu messages-notif-box animated fadeIn" aria-labelledby="messageDropdown">	
								<li>
									<div class="message-notif-scroll scrollbar-outer">
										<div class="notif-center">											
                                            @foreach($msgs as $msg)                                            	
                                                <?php 
                                                    $rd = 0;
		                                            $str = explode(';', $msg->readers);   
		                                            $receiver = explode(';', $msg->users);                                         
		                                            if( in_array($user->username, $receiver) || empty($msg->users) )
		                                            {
		                                            	if(!in_array($user->id, $str))
		                                            	{
		                                                	$rd = 1;
		                                            	}
		                                            }                                                   
                                                ?>
                                                @if($rd == 1) 
                                                	<a id="{{$msg->id}}" href="/notification/{{$msg->id}}" >
														<div class="notif-img"> 
															<i class="fa fa-bell fa-2x"></i>
														</div>
														<div class="notif-content " >
															<span class="subject"></span>
															<span class="block">
																{{ $msg->subject }}
															</span>
															<span class="time">{{ $msg->created_at }} ...</span> 
														</div>
													</a>
													@php($rd = 0) 
                                                @endif
                                            @endforeach
											
										</div>										
									</div>
									<div class="dropdown-divider"></div>
									<div align="center">
										<a href="/notifications"> &nbsp; {{ __('messages.view_all') }}</a>
										<br><br>
									</div>
								</li>
								
							</ul>
						</li>
						
						
						<li class="nav-item dropdown hidden-caret">
							<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
								<div class="avatar-sm">
									@if($user->img != '')
										<img src="/img/profile/{{ $user->img }}" alt="..." class="avatar-img rounded-circle">
									@else
										<img src="/img/any.png" alt="image profile" class="avatar-img rounded-circle" style="">
									@endif	
								</div>								
							</a>
							<ul class="dropdown-menu dropdown-user animated fadeIn">
								<div class="dropdown-user-scroll scrollbar-outer">
									<li>
										<div class="user-box">
											<div class="avatar-lg">
												@if($user->img != '')
													<img src="/img/profile/{{ $user->img }}" alt="..." class="avatar-img rounded-circle">
												@else
													<img src="/img/any.png" alt="image profile" class="avatar-img rounded" style="">
												@endif	
											</div>
											<a href="/{{$user->username}}/profile">
												<div class="u-text">
													<h4> {{ __('messages.hi') }} {{ $user->username }}</h4>
													<p class="text-muted">{{ $user->email }}</p>
												</div>
											</a>
										</div>
									</li>
									<li>
										<div class="dropdown-divider"></div>										
										<a class="dropdown-item" href="/{{$user->username}}/dashboard"><span class="fa fa-desktop"></span> &nbsp; {{ __('messages.dasbrd') }}</a>
										<a class="dropdown-item" href="/{{$user->username}}/wallet"><span class="fa fa-folder"></span>&nbsp; {{ __('messages.dpst') }}</a>
										<a class="dropdown-item" href="/{{$user->username}}/send_money"><span class="fa fa-paper-plane"></span>&nbsp; {{ __('messages.trsfr_fnd') }}</a>
										<a class="dropdown-item" href="/{{$user->username}}/investments"><span class="fa fa-wallet"></span>&nbsp; {{ __('messages.my_invstm') }} </a>
										<a class="dropdown-item" href="/{{$user->username}}/withdrawal"><span class="fa fa-download"></span>&nbsp; {{ __('messages.wthdrwl') }} </a>
										<a class="dropdown-item" href="/{{$user->username}}/downlines"><span class="fa fa-users"></span>&nbsp; {{ __('messages.dwnlns') }} </a>
										<a class="dropdown-item" href="{{route('ticket.index')}}">
											<span class="fab fa-teamspeak"></span>&nbsp; {{ __('messages.cntct_sppt') }}
											<?php                                  
				                                $msgs = App\ticket::With('comments')->orderby('id', 'desc')->get();
				                                $rd = 0;
				                            ?>
											@foreach($msgs as $msg)                                     
			                                    @foreach($msg->comments as $comment)
			                                    	@if($comment->state == 1 && $comment->sender == 'support')
			                                    		@php($rd = 1)
			                                    	@endif
			                                    @endforeach                                   
			                                @endforeach
			                                @if($rd == 1)   
			                                	<i class="fa fa-circle new_not text-danger"></i>
			                                @endif
										</a>
										
										<div class="dropdown-divider"></div>
										<a class="dropdown-item" href="/logout"><span class="fa fa-arrow-right"></span> &nbsp; {{ __('messages.logout') }}</a>

									</li>
								</div>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
			<!-- End Navbar -->
		</div>

		<!-- Sidebar -->
		<div class="sidebar sidebar-style-2">			
			<div class="sidebar-wrapper scrollbar scrollbar-inner">
				<div class="sidebar-content">
					<div class="user">
						<div class="avatar-sm float-left mr-2">
							@if($user->img != '')
								<img src="/img/profile/{{ $user->img }}" alt="..." class="avatar-img rounded-circle" >
							@else
								<img src="/img/any.png" alt="image profile" class="avatar-img rounded" >
							@endif	
						</div>
						<div class="info">
							<a data-toggle="collapse" href="/{{$user->username}}/profile" aria-expanded="true">
								<span>
									{{ ucfirst($user->username) }}
									<span class="user-level">{{ $user->email }}</span>									
								</span>
							</a>
							<div class="clearfix"></div>							
						</div>
					</div>
					<ul class="nav nav-primary">
						
						<li class="nav-item">
							<a href="/{{$user->username}}/dashboard">
								<i class="fas fa-layer-group"></i>
								<p>{{ __('messages.dasbrd') }} </p>								
							</a>							
						</li>
						<li class="nav-item">
							<a href="/{{$user->username}}/profile">
								<i class="fas fa-user"></i>
								<p>{{ __('messages.my_prfl') }} </p>								
							</a>							
						</li>
						<li class="nav-item">
							<a  href="/{{$user->username}}/wallet">
								<i class="fas fa-wallet"></i>
								<p>{{ __('messages.walt_dpst') }} </p>
							</a>							
						</li>
						<li class="nav-item">
							<a href="/{{$user->username}}/send_money">
								<i class="fas fa-paper-plane"></i>
								<p>{{ __('messages.trsfr_fnd') }} </p>
							</a>
						</li>
						<li class="nav-item">
							<a href="/{{$user->username}}/investments">
								<i class="fas fa-folder"></i>
								<p>{{ __('messages.my_invstm') }}</p>
							</a>							
						</li>
						
						<li class="nav-item">
							<a href="/{{$user->username}}/withdrawal">
								<i class="fas fa-download"></i>
								<p> {{ __('messages.wthdrwl') }}</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="/{{$user->username}}/downlines">
								<i class="fas fa-users"></i>
								<p> {{ __('messages.dwnlns') }} </p>
							</a>							
						</li>
						<li class="nav-item">
							<a href="{{route('ticket.index')}}">
								<i class="fab fa-teamspeak"></i>
								<p>{{ __('messages.cntct_sppt') }} </p>
								<?php                                  
	                                $msgs = App\ticket::With('comments')->where('user_id', $user->id)->get();
	                                $rd = 0;
	                            ?>
								@foreach($msgs as $msg)                                     
                                    @foreach($msg->comments as $comment)
                                    	@if($comment->state == 1 && $comment->sender == 'support')
                                    		@php($rd = 1)
                                    	@endif
                                    @endforeach                                   
                                @endforeach
                                @if($rd == 1)   
                                	<i class="fa fa-circle new_not text-danger"></i>
                                @endif	

							</a>							
						</li>

						<li class="nav-item">
							<a href="/logout">
								<i class="fas fa-arrow-right"></i>
								<p>{{ __('messages.logout') }} </p>
							</a>							
						</li>

						
					</ul>
				</div>
			</div>
		</div>
		<!-- End Sidebar -->