<?php
    $trans = App\fund_transfer::where('from_usr',$user->username)->orwhere('to_usr', $user->username)->orderby('id','desc')->get();
?>
<div class="table-responsive"><table id="basic-datatables" class="display table table-striped table-hover" >
        <thead>
            <tr>                
                <th>{{ __('messages.sndr') }}</th>
                <th>{{ __('messages.reicvr') }}</th>
                <th>{{ __('messages.amnt') }}</th>
                <th>{{ __('messages.date') }}</th>                                                    
            </tr>
        </thead>
        <tbody>
            
            @if(count($trans) > 0 )
                @foreach($trans as $activity)
                    <tr>
                        <td>{{$activity->from_usr}}</td>
                        <td>{{$activity->to_usr}}</td>
                        <td>{{$settings->currency.' '.$activity->amt}}</td>   
                        <td>{{$activity->created_at}}</td> 
                    </tr>
                @endforeach
            @else
                
            @endif
        </tbody>
    </table>
</div>
       