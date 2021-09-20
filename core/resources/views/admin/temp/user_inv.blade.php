<?php
    
    $actInv = App\investment::where('user_id', $user->id)->orderby('id', 'desc')->get();

    $refs = App\ref::where('username', $user->username)->orderby('id', 'desc')->get();
    $ref_amt = 0;
    foreach($refs as $ref)
    {
       $ref_amt += $ref->amount;
    }
    $ref_bal = $ref_amt - $user->ref_bal;

    $totalEarning = 0;   
    $currentEarning = 0;
    $workingDays = 0;
    

    foreach($actInv as $inv)
    {
        $totalElapse = getDays(date('y-m-d'), $inv->end_date);
        if($totalElapse == 0)
        {
            $lastWD = $inv->last_wd;
            $enddate = ($inv->end_date);
            $workingDays = getDays($lastWD, $enddate);
            $currentEarning += $workingDays*$inv->interest*$inv->capital;
        }
        else
        {
            $sd = $inv->last_wd;
            $ed = date('Y-m-d');
            $workingDays = getDays($sd, $ed);
            $currentEarning += $workingDays*$inv->interest*$inv->capital;
        }
    }
?>


<div class="table-responsive">            
    <table id="basic-datatables" class="display table table-striped table-hover">
        <thead class="web-table">
            <tr>                
               <th> {{ __('messages.pckg') }} </th>
               <th> {{ __('messages.cptl') }} </th>
               <th> {{ __('messages.ivt_return') }} </th>
               <th> {{ __('messages.dt_invstd') }} </th> 
               <th> {{ __('messages.elps') }} </th>  
               <th> {{ __('messages.days_spnt') }} </th> 
               <th> {{ __('messages.ivt_wdrn') }} </th>  
               <th> {{ __('messages.sts') }} </th>
               <th> {{ __('messages.erng') }} </th>                                   
            </tr>
        </thead>
        
        <tbody class="web-table">
            
            @if(count($actInv) > 0 )
                @foreach($actInv as $in)
                    <?php

                        $totalElapse = getDays(date('y-m-d'), $in->end_date);
                        if($totalElapse == 0)
                        {
                            $lastWD = $in->last_wd;
                            $enddate = ($in->end_date);
                            $Edays = getDays($lastWD, $enddate);
                            $ern  = $Edays*$in->interest*$in->capital;
                            $withdrawable = $ern;
                                                                 
                            $totalDays = getDays($in->date_invested, $in->end_date);
                            $ended = "yes";

                        }
                        else
                        {
                            $lastWD = $in->last_wd;
                            $enddate = (date('Y-m-d'));
                            $Edays = getDays($lastWD, $enddate);
                            $ern  = $Edays*$in->interest*$in->capital;
                            $withdrawable = 0;
                            if ($Edays >= $in->days_interval)
                            {
                                $withdrawable = $in->days_interval*$in->interest*$in->capital;
                            }
                                                           
                            $totalDays = getDays($in->date_invested, date('Y-m-d'));
                            $ended = "no";
                        }

                    ?>
                    <tr class="">
                        <td>{{$in->package}}</td>
                        <td>{{$in->capital}}</td>
                        <td>{{$in->i_return}}</td>
                        <td>{{$in->date_invested}}</td>
                        <td>{{$in->end_date}}</td> 
                        <td>
                            @if($in->status != 'Expired')
                                {{$totalDays}}
                            @else
                                0
                            @endif
                        </td>
                        <td>{{$in->w_amt}}</td> 
                        <td>{{$in->status}}</td>
                        <td>
                            <a title="Withdraw" href="javascript:void(0)" onclick="wdnone('{{$in->id}}', '{{$ern}}', '{{$withdrawable}}', '{{$Edays}}', '{{$ended}}')">
                                {{$user->currency}} {{$ern}}
                            </a>
                        </td>           
                    </tr>
                    
                    
                @endforeach
            @else
                
            @endif
        </tbody>
    </table>

    
</div>
    
<div class="mobile_table container messages-scrollbar" >
            @if(count($actInv) > 0 )
                @foreach($actInv as $in)
                    <?php

                        $totalElapse = getDays(date('y-m-d'), $inv->end_date);
                        if($totalElapse == 0)
                        {
                            $lastWD = $in->last_wd;
                            $enddate = ($in->end_date);
                            $Edays = getDays($lastWD, $enddate);
                            $ern  = $Edays*$in->interest*$in->capital;
                            $withdrawable = $ern;
                                                                 
                            $totalDays = getDays($in->date_invested, $in->end_date);
                            $ended = "yes";

                        }
                        else
                        {
                            $lastWD = $in->last_wd;
                            $enddate = (date('Y-m-d'));
                            $Edays = getDays($lastWD, $enddate);
                            $ern  = $Edays*$in->interest*$in->capital;
                            $withdrawable = 0;
                            if ($Edays >= $in->days_interval)
                            {
                                $withdrawable = $in->days_interval*$in->interest*$in->capital;
                            }
                                                           
                            $totalDays = getDays($in->date_invested, date('Y-m-d'));
                            $ended = "no";
                        }

                    ?>
                        
                    <div class="alert alert-info margin_top_10 pad_top_0 font_14" >
                        <div class="row admin_usr_inv_row" >
                            <div class="col-xs-12 pad_top_5" align="center" >
                                <h4 class="u_case"> {{ __('messages.pckg :') }}  {{$in->package}}</h4>
                               
                            </div>
                        </div> 
                        <div class="row color_blue_9">
                            <div class="col-xs-6">
                                {{ __('messages.cptl_c') }} 
                            </div>
                            <div class="col-xs-6">
                                {{$in->capital}}
                            </div>
                        </div> 
                        <div class="row" style="">
                            <div class="col-xs-6">
                                {{ __('messages.ivt_return') }} 
                            </div>
                            <div class="col-xs-6">
                                {{$in->i_return}}
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
                                {{$in->w_amt}}
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
                        <div class="row" style="">
                            <br>
                            <div class="col-xs-12" align="center">
                                <a title="Withdraw" href="javascript:void(0)" class="btn btn-info" onclick="wd('{{$in->id}}', '{{$ern}}', '{{$withdrawable}}', '{{$Edays}}', '{{$ended}}')">
                                    {{$user->currency}} {{$ern}}
                                </a>
                            </div>
                        </div>                                                                     
                    </div>
                @endforeach
            @else
                
            @endif
</div>
