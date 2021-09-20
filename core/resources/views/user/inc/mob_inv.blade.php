                
<div class="alert alert-info inv_alert_cont" >
    <div class="row inv_alert_top_row">
        <div class="col-xs-12 pad_top_5" align="center" >
            <h4 class="u_case">{{ __('messages.amt_pack') }} {{$in->package}}</h4>           
        </div>
    </div> 
    <div class="row color_blue_9">
        <div class="col-xs-6">
            {{ __('messages.cptl_c') }}
        </div>
        <div class="col-xs-6">
            {{($settings->currency)}} {{$in->capital}}
        </div>
    </div> 
    <div class="row" style="">
        <div class="col-xs-6">
            {{ __('messages.ivt_return') }}
        </div>
        <div class="col-xs-6">
            {{($settings->currency)}} {{$in->i_return}}
        </div>
    </div>  
    <div class="row" style="">
        <div class="col-xs-6">
            {{ __('messages.ivt_started') }}
        </div>
        <div class="col-xs-6">
            {{$in->date_invested}}
        </div>
    </div> 
    <div class="row" style="">
        <div class="col-xs-6">
            {{ __('messages.ivt_ending') }}
        </div>
        <div class="col-xs-6">
            {{$in->end_date}}
        </div>
    </div>
    <div class="row" style="">
        <div class="col-xs-6">
            {{ __('messages.ivt_days') }}
        </div>
        <div class="col-xs-6">
            {{$totalDays}}
        </div>
    </div>
    <div class="row" style="">
        <div class="col-xs-6">
           {{ __('messages.ivt_wdrn') }} 
        </div>
        <div class="col-xs-6">
            {{($settings->currency)}} {{$in->w_amt}}
        </div>
    </div> 
    <div class="row" style="">
        <div class="col-xs-6">
            {{ __('messages.sts :') }}
        </div>
        <div class="col-xs-6">
            {{$in->status}}
        </div>
    </div> 
    <div class="row" style="" align="center">
        <br>
        <div class="col-xs-12" align="center">
            <a title="Withdraw" href="javascript:void(0)" class="btn btn-info" onclick="wd('pack', '{{$in->id}}', '{{$ern}}', '{{$withdrawable}}', '{{$Edays}}', '{{$ended}}')">
                {{$settings->currency}} {{$ern}}
            </a>
        </div>
        {{ __('messages.clk_wdr') }}
    </div>                                                                     
</div>
        
