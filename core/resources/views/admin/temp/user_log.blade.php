<?php
    $acts = App\adminLog::orderby('id', 'desc')->paginate(50);
?>

<table id="basic-datatables" class="display table table-stripped table-hover">
    <thead>
        <tr>            
            <th> {{ __('messages.id') }} </th>
            <th> {{ __('messages.admn') }} </th>
            <th> {{ __('messages.actn') }} </th>
            <th> {{ __('messages.date') }} </th>                                                              
        </tr>
    </thead>
    <tbody>
        @if(count($acts) > 0 )
            @foreach($acts as $dep)
                <tr>                                                            
                    <td>{{$dep->id}}</td>
                    <td>{{$dep->admin}}</td>
                    <td>{{$dep->action}}</td>
                    <td>{{$dep->created_at}}</td>
                </tr>
            @endforeach
        @else
            <tr>                                                            
                <td>{{ __('messages.no_data') }}</td>                                        
            </tr>
        @endif
    </tbody>
</table>
<!--<div align="center">-->
<!--   <span> {{$acts->links()}}</span>  -->
<!--</div>-->