
            <table class="display table table-stripped table-hover">
                <thead>
                    <tr>
                       <th> {{ __('messages.adm_name') }} </th>
                       <th> {{ __('messages.pkg_min') }} </th>
                       <th> {{ __('messages.pkg_max') }} </th>
                       <th> {{ __('messages.intrs_precnt') }} </th>
                       <th> {{ __('messages.perd') }} </th>
                       <th> {{ __('messages.mthd') }} </th>
                       <th> {{ __('messages.wd_interval') }} </th>                       
                       <th> {{ __('messages.on_off') }} </th>
                       <th> {{ __('messages.mang') }} </th>                                                                          
                    </tr>
                </thead>
                <tbody>
                    
                    @if(count($packs) > 0 )
                        @foreach($packs as $dep)
                            <tr>
                                <td>{{$dep->package_name}}</td>
                                <td>{{$dep->min}}</td>
                                <td>{{$dep->max}}</td>
                                <td>{{round($dep->daily_interest*$dep->period*100,2)}}</td>
                                <td>{{$dep->period}}</td>
                                <td>
                                  @if($dep->method == 1)
                                    {{ __('messages.wrk_days') }}
                                  @elseif($dep->method == 0)
                                    {{ __('messages.everyday') }}
                                  @endif
                                </td>
                                <td>{{$dep->days_interval}}</td>                                
                                <td>                                     
                                  <label class="switch" >
                                    <input type="checkbox" @if($dep->status == 1){{'checked'}}@endif>
                                    <span id="switch_pack{{$dep->id}}" class="slider round" onclick="act_deact_pack('{{$dep->id}}')"></span>
                                  </label>                                    
                                </td>
                                
                                <td>                                                                       
                                    @if($adm->role == 3 || $adm->role == 2)
                                        <a id="{{$dep->id}}" title="Edit Package" href="javascript:void(0)" onclick="edit_pack(this.id, '{{$dep->min}}', '{{$dep->max}}', '{{round($dep->daily_interest*$dep->period*100,2)}}', '{{$dep->withdrwal_fee}}', '{{csrf_token()}}', '{{$dep->currency}}')"> 
                                            <span><i class="fa fa-edit btn btn-warning"></i></span>
                                        </a> 
                                        <a id="{{$dep->id}}" title="Delete Package" href="javascript:void(0)" onclick="load_get_ajax('/admin/delete/pack/{{$dep->id}}', this.id, 'admDeleteMsg') "> 
                                            <span><i class="fa fa-times btn btn-danger"></i></span>
                                        </a>
                                         
                                    @endif
                                </td>
                                               
                            </tr>
                        @endforeach
                    @else
                        
                    @endif
                </tbody>
            </table>