<?php
    if(Session::has('val'))
    {
        $val = Session::get('val');
        $musers = App\User::where('created_at', 'like', '%'.$val.'%')->where('status', 1)->orderby('created_at', 'asc')->get();
        $mInv = App\investment::where('date_invested', 'like', '%'.$val.'%')->where('status', 'active')->orderby('date_invested', 'asc')->get();
        $mDep = App\deposits::where('created_at', 'like', '%'.$val.'%')->where('status', 1)->orderby('created_at', 'asc')->get();
        $mWd = App\Withdrawal::where('w_date', 'like', '%'.$val.'%')->where('status', 'Approved')->orderby('w_date', 'asc')->get();

        $mnt = ['Jan','Feb', 'Mar','Apr','May','Jun','Jul','Aug', 'Sep','Oct','Nov','Dec'];
        $datpart = explode('-', $val);
        $num = $mnt[intval($datpart[1])-1];
    }
    else
    {
        $musers = App\User::where('created_at', 'like',  '%'.date('Y-m').'%')->where('status', 1)->orderby('created_at', 'asc')->get();
        $mInv = App\investment::where('date_invested', 'like', '%'.date('Y-m').'%')->where('status', 'active')->orderby('date_invested', 'asc')->get();
        $mDep = App\deposits::where('created_at', 'like', '%'.date('Y-m').'%')->where('status', 1)->orderby('created_at', 'asc')->get();
        $mWd = App\Withdrawal::where('w_date', 'like', '%'.date('Y-m').'%')->where('status', 'Approved')->orderby('w_date', 'asc')->get();
    }
    
?>

<div class="row">
    <div class="col-sm-12 float-right" align="" style="">        
        <form id="search_form" action="/admin/search/stat" method="post">
            <label><b><?php echo e(__('messages.search_dat')); ?>:</b></label>
            <div class="input-group margin_top_10" >
                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"> 
                <div class="input-group-prepend">               
                    <span class="input-group-text span_bg" style="">
                        <i class="fa fa-calendar"></i>
                    </span>
                </div>
                <input type="text" name="search_val" class="form-control input_height_45" required placeholder="2019-09">
                <div class="input-group-append span_bg">                     
                    <button class="span_bg btn_prepend search_btn_append"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
                                                    
    </div>
    <div class="col-sm-12" align="center" style=" padding-top: 30px;">
        <h4 id="search_mt" align="right">            
            Result for: &nbsp; 
            <?php if(Session::has('val')): ?>
                <?php echo e($num.'-'.$datpart[0]); ?>

            <?php else: ?>
                <?php echo e(date('M-Y')); ?>

            <?php endif; ?>
            <?php (Session::forget('val')); ?>            
        </h4>
    </div>

</div>

<div class="row margin_top_10"> 
    <div class="col-sm-3 btn_prepend" onclick="load_Stat()">        
        <div class="card card-stats card-primary card-round">
            <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <div class="icon-big text-center">
                            <i class="flaticon-users"></i>
                        </div>
                    </div>
                    <div class="col-7 col-stats">
                        <div class="numbers">
                            <p class="card-category"><?php echo e(__('messages.users')); ?></p>
                            <h4 id="uCount" class="card-title"><?php echo e(count($musers)); ?></h4>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-3 btn_prepend" onclick="load_iStat()">
        <?php ($dep = 0); ?>
        <?php ($dep2 = 0); ?>
        <?php $__currentLoopData = $mInv; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $in): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php ($dep = $dep + intval($in->capital) ); ?>                       
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div class="card card-stats card-success card-round">
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <div class="icon-big text-center">
                            <i class="flaticon-users"></i>
                        </div>
                    </div>
                    <div class="col-9 col-stats">
                        <div class="numbers">
                            <p class="card-category"><?php echo e(__('messages.wd_ivt')); ?></p>
                            <h4 id="iCount" class="card-title"><?php echo e($settings->currency); ?> <?php echo e($dep); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <div class="col-sm-3 btn_prepend" onclick="load_dStat()">
        <?php ($dep = 0); ?>
        <?php ($dep2 = 0); ?>
        <?php $__currentLoopData = $mDep; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $in): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                        
            <?php ($dep = $dep + intval($in->amount) ); ?>                        
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div class="card card-stats card-secondary  card-round">
            <div class="card-body">                        
                <div class="row">
                    <div class="col-3">
                        <div class="icon-big text-center">
                            <i class="flaticon-users"></i>
                        </div>
                    </div>
                    <div class="col-9 col-stats">
                        <div class="numbers">
                            <p class="card-category"><?php echo e(__('messages.dpsts')); ?></p>
                            <h4 id="dCount" class="card-title"><?php echo e($settings->currency); ?> <?php echo e($dep); ?></h4>
                        </div>
                    </div>  
                </div>
            </div>
        </div>        
    </div>

    <div class="col-sm-3 btn_prepend" onclick="load_wStat()">        
        <?php ($dep = 0); ?>
        <?php ($dep2 = 0); ?>
        <?php $__currentLoopData = $mWd; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $in): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                        
            <?php ($dep = $dep + intval($in->amount) ); ?>                        
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div class="card card-stats card-warning card-round">
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <div class="icon-big text-center">
                            <i class="flaticon-users"></i>
                        </div>
                    </div>
                    <div class="col-9 col-stats">
                        <div class="numbers">
                            <p class="card-category"><?php echo e(__('messages.wthdrwl')); ?></p>
                            <h4 id="wCount" class="card-title"><?php echo e($settings->currency); ?> <?php echo e($dep); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
        
    </div>
    
    <div class="col-sm-12">
        <div align="center">
            <span id="adminStatChart_m_legend" class="admin_stat_legend" align="center"></span>
        </div> 
        <div id="cart_cont" class="chart-container" style="min-height: 375px">
            <canvas id="adminStatChart_m"></canvas>
        </div>
                  
    </div>

</div>



<?php
       
        $musersDate = $mInvDate = $mDepDate = $mWdDate = [];
        $musersVal = $mInvVal = $mDepval = $mWdVal = [];  
        $pt = "";
        $cnt = 0;
        $sum_cap = 0;

        foreach ($musers as $in) {
            if($pt != date('Y-m-d', strtotime($in->created_at)))
            {           $sum_cap = 0;    
                $pt = date('Y-m-d', strtotime($in->created_at));
                $musersDate[$cnt] = date('d/m/y', strtotime($in->created_at));
                $m_count = App\withdrawal::where('created_at', 'like','%'.$pt.'%')->get();                
                $musersVal[$cnt] = count($m_count);
                $sum_cap = 0;
                $cnt += 1;
            }
        } 
        $pt = "";
        $cnt = 0;
        $sum_cap = 0;
        foreach ($mInv as $in) {
            if($pt != date('Y-m-d', strtotime($in->created_at)))
            {               
                $pt = date('Y-m-d', strtotime($in->created_at));
                $mInvDate[$cnt] = date('d/m/y', strtotime($in->created_at));
                $m_count = App\withdrawal::where('created_at', 'like','%'.$pt.'%')->get();
                foreach ($m_count as $n) 
                {
                    $sum_cap += $n->amount;
                }
                $mInvVal[$cnt] = $sum_cap;
                $sum_cap = 0;
                $cnt += 1;
            }
        } 
        $pt = "";
        $cnt = 0;
        $sum_cap = 0;
        foreach ($mDep as $in) {
            if($pt != date('Y-m-d', strtotime($in->created_at)))
            {               
                $pt = date('Y-m-d', strtotime($in->created_at));
                $mDepDate[$cnt] = date('d/m/y', strtotime($in->created_at));
                $m_count = App\withdrawal::where('created_at', 'like','%'.$pt.'%')->orderby('id', 'desc')->get();
                foreach ($m_count as $n) 
                {
                    $sum_cap += $n->amount;
                }
                $mDepval[$cnt] = $sum_cap;
                $cnt += 1;
                $sum_cap = 0;
            }
        }
        $pt = "";
        $cnt = 0;
        $sum_cap = 0;
        foreach ($mWd as $in) {
            if($pt != date('Y-m-d', strtotime($in->created_at)))
            {               
                $pt = date('Y-m-d', strtotime($in->created_at));
                $mWdDate[$cnt] = date('d/m/y', strtotime($in->created_at));
                $m_count = App\withdrawal::where('created_at', 'like','%'.$pt.'%')->orderby('id', 'desc')->get();
                foreach ($m_count as $n) 
                {
                    $sum_cap += $n->amount;
                }
                $mWdVal[$cnt] = $sum_cap;
                $cnt += 1;
                $sum_cap = 0;
            }
        }            
    ?>

    <script type="text/javascript">
        var musersDate = JSON.parse('<?php echo json_encode($musersDate); ?>');
        var musersVal = JSON.parse('<?php echo json_encode($musersVal); ?>');

        var mInvDate = JSON.parse('<?php echo json_encode($mInvDate); ?>');
        var mInvVal = JSON.parse('<?php echo json_encode($mInvVal); ?>');

        var mDepDate = JSON.parse('<?php echo json_encode($mDepDate); ?>');
        var mDepval = JSON.parse('<?php echo json_encode($mDepval); ?>'); 

        var mWdDate = JSON.parse('<?php echo json_encode($mWdDate); ?>');
        var mWdVal = JSON.parse('<?php echo json_encode($mWdVal); ?>');

        $('#search_form').submit(function(e){
            e.preventDefault();
            var data = new FormData(document.getElementById('search_form'));            
            $.ajax
            ({
                url: "/admin/search/stat",
                type: "post",                
                data: data,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success:function(result)
                {
                    var str = result;
                    musersDate = str[0];
                    musersVal = str[4];

                    mInvDate = str[1];
                    mInvVal = str[5];

                    mDepDate = str[2];
                    mDepval = str[6];

                    mWdDate = str[3];
                    mWdVal = str[7];

                    $('#uCount').html(str[8]);
                    $('#iCount').html(str[9]);
                    $('#dCount').html(str[10]);
                    $('#wCount').html(str[11]);
                    $('#search_mt').text('Result for: '+str[12]);
                    loadStat(musersDate, musersVal);

                },
                error: function (xhr) {                     
                    alert(xhr.responseText)                     
                }
               
            }); 
            
        });


///////////////////// load default ////////////////////////////////////////////////////////////////

        function loadStat(statDate, statVal)
        {
            $('#cart_cont').html('');
            $('#cart_cont').append('<canvas id="adminStatChart_m"></canvas>');
            var ctx2 = document.getElementById('adminStatChart_m').getContext('2d');
            // ctx2.restore();
            var adminStatChart_m = new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: statDate, 
                    datasets: 
                    [ 
                        {
                            label: "<?php echo e(__('messages.value')); ?>",
                            borderColor: '#08C',
                            pointBackgroundColor: 'rgba(0, 84, 180, 0.6)',
                            pointRadius: 0,
                            backgroundColor: 'rgba(0, 84, 220, 0.4)',
                            legendColor: '#08C',
                            fill: true,
                            borderWidth: 2,
                            data: statVal //[154, 184, 175] 
                        }, 
                      
                    ]
                },
                options : {
                    responsive: true, 
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    tooltips: {
                        bodySpacing: 4,
                        mode:"nearest",
                        intersect: 0,
                        position:"nearest",
                        xPadding:10,
                        yPadding:10,
                        caretPadding:10
                    },
                    layout:{
                        padding:{left:5,right:5,top:15,bottom:15}
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                fontStyle: "500",
                                beginAtZero: false,
                                maxTicksLimit: 5,
                                padding: 10,
                            },
                            gridLines: {
                                drawTicks: false,
                                display: false
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                zeroLineColor: "transparent"
                            },
                            ticks: {
                                padding: 10,
                                fontStyle: "500"
                            }
                        }]
                    }, 
                    legendCallback: function(chart) { 
                        var text = []; 
                        text.push('<ul class="' + chart.id + '-legend html-legend">'); 
                        for (var i = 0; i < chart.data.datasets.length; i++) { 
                            text.push('<li><span style="background-color:' + chart.data.datasets[i].legendColor + '"></span>'); 
                            if (chart.data.datasets[i].label) { 
                                text.push(chart.data.datasets[i].label); 
                            } 
                            text.push('</li>'); 
                        } 
                        text.push('</ul>'); 
                        return text.join(''); 
                    }  
                }
            });

            var myLegendContainer = document.getElementById("adminStatChart_m_legend");

            // generate HTML legend
            myLegendContainer.innerHTML = adminStatChart_m_legend.generateLegend();

            // bind onClick event to all LI-tags of the legend
            var legendItems = myLegendContainer.getElementsByTagName('li');
            for (var i = 0; i < legendItems.length; i += 1) {
                legendItems[i].addEventListener("click", legendClickCallback, false);
            }


            
        }

        $('#adminStatChart_m_legend').text('User Statistics');

        loadStat(musersDate, musersVal);

        function load_Stat(){
            $('#adminStatChart_m_legend').text('User Statistics');
            loadStat(musersDate, musersVal);            
        }

        function load_iStat(){
            $('#adminStatChart_m_legend').text('Investment Statistics');
            loadStat(mInvDate, mInvVal);            
        }

        function load_dStat(){
            $('#adminStatChart_m_legend').text('Deposits Statistics');
            loadStat(mDepDate, mDepval);            
        }

        function load_wStat(){
            $('#adminStatChart_m_legend').text('Withdrawal Statistics');
            loadStat(mWdDate, mWdVal);            
        }
        
    </script>
<?php /**PATH /home/gcibrokers/client.gcibrokers.net/core/resources/views/admin/temp/monthly.blade.php ENDPATH**/ ?>