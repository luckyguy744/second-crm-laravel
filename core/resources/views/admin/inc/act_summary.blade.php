@if($adm->role != 1)
    <div class="income-order-visit-user-area mob_d">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <div class="income-dashone-total shadow-reset nt-mg-b-30">
                        <div class="income-title">
                            <div class="main-income-head">
                                <h2><b>{{ __('messages.t_users') }}</b></h2>
                                <div class="main-income-phara">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                        <div class="income-dashone-pro">
                            <div class="income-rate-total">
                                <div class="price-adminpro-rate">
                                    <h3><span></span><span class="counter">&nbsp;{{count($users)}}</span></h3>
                                </div>
                                <div class="price-graph">
                                    <i class="fa fa-money"></i>
                                </div>
                            </div>
                            <div class="income-range">
                                <p>{{ __('messages.inactive') }}: {{count($users->where('status', '!=', '1'))}}</p>
                                <span class="income-percentange"> </span>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="income-dashone-total shadow-reset nt-mg-b-30">
                        <div class="income-title">
                            <div class="main-income-head">
                                <h2><b>{{ __('messages.investments') }}</b></h2>
                                <div class="main-income-phara order-cl">
                                    <?php
                                        $inv = App\investment::where('status', 'active')->orderby('id', 'desc')->get();
                                        $cap = 0;
                                        $cap2 = 0;
                                    ?>
                                    @foreach($inv as $in)
                                        @if($in->currency == 'N' || $in->package != 'International')
                                            @php($cap = $cap + intval($in->capital) )
                                        @endif
                                    @endforeach
                                    @foreach($inv as $in)
                                        @if($in->currency == '$' || $in->package == 'International')
                                            @php($cap2 = $cap2 + intval($in->capital) )
                                        @endif
                                    @endforeach
                                    <p>{{count($inv->where('status', '!=', 'Active'))}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="income-dashone-pro">
                            <div class="income-rate-total">
                                <div class="price-adminpro-rate">
                                    <h3><span class="counter">{{count($inv)}}</span></h3>
                                </div>
                                <div class="price-graph">
                                    <span id="sparkline6"></span>
                                </div>
                            </div>
                            <div class="income-range order-cl">
                                <p> N{{$cap}}; ${{$cap2}}</p>                            
                                <span class="income-percentange"><i class="fa fa-pie-chart"></i></span>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="income-dashone-total shadow-reset nt-mg-b-30">
                        <div class="income-title">
                            <div class="main-income-head">
                                <h2><b>{{ __('messages.dpsts') }}</b></h2>
                                <div class="main-income-phara low-value-cl">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                        <div class="income-dashone-pro">
                            <div class="income-rate-total">
                                <div class="price-adminpro-rate">
                                    <?php
                                        $deposits = App\deposits::where('status', 1)->orderby('id', 'desc')->get();
                                        $dep = 0;
                                        $dep2 = 0;
                                    ?>
                                    @foreach($deposits as $in)
                                        @if($in->currency == 'N' || $in->package != 'International')
                                            @php($dep += $in->amount )
                                        @endif
                                        @if($in->currency == '$' || $in->package == 'International')
                                            @php($dep2 += $in->amount )
                                        @endif
                                    @endforeach
                                    <h3><span>N</span><span class="counter">{{$dep}}</span></h3>
                                </div>
                                <div class="price-graph">
                                    <span id="sparkline5"></span>
                                </div>
                            </div>
                            <div class="income-range low-value-cl">
                                <p>USD: {{$dep2}}</p>
                                <span class="income-percentange"> <i class="fa fa-level-down"></i></span>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="income-dashone-total shadow-reset nt-mg-b-30">
                        <div class="income-title">
                            <div class="main-income-head">
                                <h2><b>{{ __('messages.wthdrwls') }}</b></h2>
                                <?php
                                    $wd = App\withdrawal::orderby('id', 'desc')->get();
                                    $dep = 0;
                                    $dep2 = 0;
                                ?>
                                
                                @foreach($wd as $in)
                                    @if($in->currency == 'N' || $in->package != 'International')
                                        @php($dep = $dep + $in->amount )
                                    @endif
                                    @if($in->currency == '$' || $in->package == 'International')
                                        @php($dep2 = $dep2 + $in->amount )
                                    @endif
                                @endforeach
                                <div class="main-income-phara visitor-cl">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                        <div class="income-dashone-pro">
                            <div class="income-rate-total">
                                <div class="price-adminpro-rate">
                                    <h3><span>N</span><span class="counter"> {{$dep}}</span></h3>
                                </div>
                                <div class="price-graph">
                                    <span id="sparkline2"></span>
                                </div>
                            </div>
                            <div class="income-range visitor-cl">
                                <p >$ {{$dep2}}</p>
                                <span class="income-percentange"> <i class="fa fa-level-up"></i></span>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

@else

    <div class="income-order-visit-user-area mob_d">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <div class="income-dashone-total shadow-reset nt-mg-b-30">
                        <div class="income-title">
                            <div class="main-income-head">
                                <h2><b>{{ __('messages.t_users') }}</b></h2>
                                <div class="main-income-phara">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                        <div class="income-dashone-pro">
                            <div class="income-rate-total">
                                <div class="price-adminpro-rate">
                                    <h3><span></span><span class="counter">&nbsp;{{count($users)}}</span></h3>
                                </div>
                                <div class="price-graph">
                                    <i class="fa fa-money"></i>
                                </div>
                            </div>
                            <div class="income-range">
                                <p>{{ __('messages.inactive') }}: {{count($users->where('status', '!=', '1'))}}</p>
                                <span class="income-percentange"> </span>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="income-dashone-total shadow-reset nt-mg-b-30">
                        <div class="income-title">
                            <div class="main-income-head">
                                <h2><b>{{ __('messages.investments') }}</b></h2>
                                <div class="main-income-phara order-cl">
                                    <?php
                                        $inv = App\investment::where('status', 'active')->orderby('id', 'desc')->get();
                                        $cap = 0;
                                        $cap2 = 0;
                                    ?>
                                    @foreach($inv as $in)
                                        @if($in->currency == 'N' || $in->package != 'International')
                                            @php($cap = $cap + intval($in->capital) )
                                        @endif
                                    @endforeach
                                    @foreach($inv as $in)
                                        @if($in->currency == '$' || $in->package == 'International')
                                            @php($cap2 = $cap2 + intval($in->capital) )
                                        @endif
                                    @endforeach
                                    <p>{{count($inv->where('status', '!=', 'Active'))}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="income-dashone-pro">
                            <div class="income-rate-total">
                                <div class="price-adminpro-rate">
                                    <h3><span class="counter">{{count($inv)}}</span></h3>
                                </div>
                                <div class="price-graph">
                                    <span id="sparkline6"></span>
                                </div>
                            </div>
                            <div class="income-range order-cl">
                                <p></p>                            
                                <span class="income-percentange"><i class="fa fa-pie-chart"></i></span>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="income-dashone-total shadow-reset nt-mg-b-30">
                        <div class="income-title">
                            <div class="main-income-head">
                                <h2><b>{{ __('messages.dpsts') }}</b></h2>
                                <div class="main-income-phara low-value-cl">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                        <div class="income-dashone-pro">
                            <div class="income-rate-total">
                                <div class="price-adminpro-rate">
                                    <?php
                                        $deposits = App\deposits::where('status', 1)->orderby('id', 'desc')->get();
                                        $dep = 0;
                                        $dep2 = 0;
                                    ?>
                                    @foreach($deposits as $in)
                                        @if($in->currency == 'N' || $in->package != 'International')
                                            @php($dep += $in->amount )
                                        @endif
                                        @if($in->currency == '$' || $in->package == 'International')
                                            @php($dep2 += $in->amount )
                                        @endif
                                    @endforeach
                                    <h3><span></span><span class="counter">{{count($deposits)}}</span></h3>
                                </div>
                                <div class="price-graph">
                                    <span id="sparkline5"></span>
                                </div>
                            </div>
                            <div class="income-range low-value-cl">
                                <p></p>
                                <span class="income-percentange"> <i class="fa fa-level-down"></i></span>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="income-dashone-total shadow-reset nt-mg-b-30">
                        <div class="income-title">
                            <div class="main-income-head">
                                <h2><b>{{ __('messages.wthdrwls') }}</b></h2>
                                <?php
                                    $wd = App\withdrawal::orderby('id', 'desc')->get();
                                    $dep = 0;
                                    $dep2 = 0;
                                ?>
                                @foreach($wd as $in)
                                    @if($in->currency == 'N' || $in->package != 'International')
                                        @php($dep = $dep + $in->amount )
                                    @endif
                                    @if($in->currency == '$' || $in->package == 'International')
                                        @php($dep2 = $dep2 + $in->amount )
                                    @endif
                                @endforeach
                                <div class="main-income-phara visitor-cl">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                        <div class="income-dashone-pro">
                            <div class="income-rate-total">
                                <div class="price-adminpro-rate">
                                    <h3><span></span><span class="counter"> {{count($wd)}}</span></h3>
                                </div>
                                <div class="price-graph">
                                    <span id="sparkline2"></span>
                                </div>
                            </div>
                            <div class="income-range visitor-cl">
                                <p ></p>
                                <span class="income-percentange"> <i class="fa fa-level-up"></i></span>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
@endif