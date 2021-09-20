<table class="display table table-stripped table-hover">
    <thead>
        <tr>                       
            <th> {{ __('messages.adm_name') }} </th>
            <th> {{ __('messages.admin_frm_email') }} </th>
            <th> {{ __('messages.rol') }} </th>
            <th> {{ __('messages.sts') }} </th>                        
            <th> {{ __('messages.mang') }} </th>                                                                          
        </tr>
    </thead>
    <tbody>        
        @if(count($adm_users) > 0 )
            @foreach($adm_users as $dep)
                <tr> 
                    <td>{{$dep->name}}</td>
                    <td>{{$dep->email}}</td>
                    <td>
                        @if($dep->role == 1)
                        {{$dep->role = "Support"}}
                        @elseif($dep->role == 2)
                        {{$dep->role = "Manager"}}
                         @else
                         {{$dep->role = "Admin"}}
                        @endif
                    </td> 
                    <td>{{$dep->status}}</td>                   
                    <td>
                        <a title="Ban User" href="/admin/ban/admuser/{{$dep->id}}" > 
                            <span class=""><i class="fa fa-ban text-warnig" ></i></span>
                        </a>       
                        <a title="Activate User" href="/admin/activate/admuser/{{$dep->id}}" > 
                            <span><i class="fa fa-check text-success"></i></span>
                        </a>                             
                        @if($adm->role == 3)                                        
                            <a title="Delete User" href="/admin/delete/admuser/{{$dep->id}}" > 
                                <span class=""><i class="fa fa-times text-danger"></i></span>
                            </a>
                        @endif
                    </td>
                                   
                </tr>
            @endforeach
        @else
            <tr>                                                            
                <td>{{ __('messages.no_data') }} </td>                                        
            </tr>
        @endif
    </tbody>
</table>
      