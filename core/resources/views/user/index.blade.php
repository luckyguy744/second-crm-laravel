@include('user.inc.fetch')
@extends('layouts.atlantis.layout')
@Section('content')
		<div class="main-panel">
			<div class="content">
			    @php($breadcome = __('messages.dasbrd'))
				@include('user.atlantis.main_bar')
				<div class="page-inner mt--5">
					@include('user.atlantis.overview')
					<div id="prnt"></div>
					<div class="row">
						<div class="col-md-8">
							<div class="card">
								<div class="card-header">
									<div class="card-head-row">
										<div class="card-title">{{ __('messages.invstm_stat') }}</div>
										<div class="card-tools">											
										</div>
									</div>
								</div>
								<div class="card-body">
									<div class="chart-container">
										<canvas id="statisticsChart2"></canvas>
									</div>
									<div id="myChartLegend2"></div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card card-primary">
								<div class="card-header">
									<div class="card-title">{{ __('messages.wthdrwl_stat') }} </div>
									<div class="card-category">
									    <?php
									        $total_wd = 0;
									        foreach($wd as $w)
									        {
    											$total_wd += $w->amount;
									        }
									    ?>
										<h1>{{$settings->currency.' '. $total_wd}}</h1>
									</div>
								</div>
								<div class="card-body pb-0">									
									<div class="pull-in">
										<canvas id="wd_stats"></canvas>
									</div>
								</div>
							</div>
							<div class="card">
								<div class="card-body pb-0">
									<div class="px-2 pb-2 pb-md-0 text-center">
										<div id="circles-logs"></div>
										<h6 class="fw-bold mt-3 mb-0">{{ __('messages.my_tot_actn') }}</h6>
										<br>
									</div>									
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="card-title">{{ __('messages.avail_pckg') }} </div>
								</div>
								<div class="card-body pb-0">
									@include('user.inc.packages')
								</div>
							</div>
						</div>
					</div>

					<div class="row row-card-no-pd">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="card-head-row card-tools-still-right">
										<h4 class="card-title">{{ __('messages.usr_actcts') }}</h4>
										<div class="card-tools">
											<button class="btn btn-icon btn-link btn-primary btn-xs"><span class="fa fa-angle-down"></span></button>
											<button class="btn btn-icon btn-link btn-primary btn-xs btn-refresh-card"><span class="fa fa-sync-alt"></span></button>
											<button class="btn btn-icon btn-link btn-primary btn-xs"><span class="fa fa-times"></span></button>
										</div>
									</div>
									<p class="card-category">{{ __('messages.all_actn_pfrm_by_u') }}</p>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-12">
											<div class="card">												
												<div class="card-body">
													<div class="table-responsive">
														<table id="basic-datatables" class="display table table-striped 
														table-hover" >
															<thead>
																<tr>
																	<th>{{ __('messages.actn') }}</th>
																	<th>{{ __('messages.date') }}</th>
																</tr>
															</thead>															
															<tbody>																
																@foreach( $logs as $log)
																	<tr>
																		<td>
																			{{ $log->action }}
																		</td>
																		<td>{{ $log->created_at }}</td>
																	</tr>
																@endforeach																
															</tbody>
														</table>														
													</div>
													
												</div>
											</div>
										</div>
										
									</div>

								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>

			 @include('user.inc.confirm_inv')

@endSection
			