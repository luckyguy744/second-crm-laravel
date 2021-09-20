<div class="row mt--2">
	<div class="col-md-6">
		<div class="card full-height">
			<div class="card-body">
				<div class="card-title">{{ __('messages.stats_summ') }}</div>
				<div class="card-category">{{ __('messages.stat_of_d_systm') }}</div>
				<div class="d-flex flex-wrap justify-content-around pb-2 pt-4">
					<div class="px-2 pb-2 pb-md-0 text-center">
						<div id="circles-1"></div>
						<h6 class="fw-bold mt-3 mb-0">{{ __('messages.users') }}</h6>
            <span>{{ __('messages.inactive') }}: {{count($users->where('status', '!=', '1'))}}</span>
					</div>
					<div class="px-2 pb-2 pb-md-0 text-center">
            <?php
                $inv = App\investment::orderby('id', 'desc')->get();
                $cap = 0;
                $cap2 = 0;
            ?>                        
						<div id="circles-2"></div>
						<h6 class="fw-bold mt-3 mb-0">{{ __('messages.investments') }}</h6>
            <span>{{ __('messages.inactive') }}: {{count($inv->where('status', '!=', 'Active'))}}</span>
					</div>
					<div class="px-2 pb-2 pb-md-0 text-center">
            <?php
                $deposits = App\deposits::orderby('id', 'desc')->get();
                $dep = 0;
                $dep2 = 0;
            ?>           
						<div id="circles-3"></div>
						<h6 class="fw-bold mt-3 mb-0">{{ __('messages.dpsts') }}</h6>
            			<span>{{ __('messages.inactive') }}: {{count($deposits->where('status', '!=', '1'))}}</span>
					</div>
				</div>
			</div>
		</div>
	</div>

  @foreach($inv as $in)     
    @php($cap = $cap + intval($in->capital) )
  @endforeach 

 <?php
 $deposits = App\deposits::where('status', 1)-> orderby('id', 'desc')->get();
 ?>        
  @foreach($deposits as $in)
    @php($dep += $in->amount)  
  @endforeach

 <?php
 $wd = App\withdrawal::where('status', 'Approved')-> orderby('id', 'desc')->get();
 ?> 
  @foreach($wd as $in)    
    @php($wd_bal += $in->amount )       
  @endforeach 

	<div class="col-md-6">
		<div class="card full-height">
			<div class="card-body">
				<div class="card-title"><h2>{{ __('messages.bal_summ') }}</h2></div>
				<div class="row py-3 @if($adm->role < 2) {{blur_cnt}}@endif" style="position: relative;">
					<div class="col-md-6 d-flex flex-column justify-content-around">						
						<div style="border-bottom: 1px solid #CCC;">							
							<h4 class="fw-bold text-uppercase text-success op-8">{{ __('messages.wd_ivt') }}</h4>
							<h3 class="fw-bold">{{$settings->currency}} {{ $cap }}</h3>
							<div class="colhd" style="font-size: 10px; margin-top: -10px;">&emsp;</div>
							<br>						
						</div>						
					  <div class="clearfix"><br></div>						
						<div>					
						   
							<h4 class="fw-bold text-uppercase text-success op-8">{{ __('messages.dpsts') }}</h4>
							<h3 class="fw-bold">{{$settings->currency}} {{ $dep }}</h3>
							<div class="colhd" style="font-size: 10px; margin-top: -10px;">&emsp;</div>
							<br>									
						</div>
					</div>

					<div class="col-md-6">
						<div style="border-bottom: 1px solid #CCC;">
							<h4 class="fw-bold text-uppercase text-success op-8">{{ __('messages.wthdrwls') }}</h4>
							<h3 class="fw-bold">{{$settings->currency}} {{$wd_bal}}</h3>
							<div class="colhd" style="font-size: 10px; margin-top: -10px;">&emsp;</div>	
							<br>	
						</div>
					</div>
				</div>		       
			</div>
		</div>
	</div>
</div>