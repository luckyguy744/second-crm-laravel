			<footer class="foot">
				<div class="container-fluid">					
					<div class="copyright" align="center">
					    <?php $settings = App\site_settings::find(1); ?>
					    {{ __('messages.cpyrght') }} &#169; <a href="/">{{$settings->site_title}}</a> {{ date("Y") }}. {{ __('messages.all_rght_resrvd') }}
					</div>				
				</div>
			</footer>
		</div>
	</div>
	<script src="/atlantis/js/plugin/webfont/webfont.min.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['/atlantis/css/fonts.min.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
	<script>
        tinymce.init({
            selector: '#textmsg2',

            setup: function (editor1) {
                editor1.on('change', function () {
                    editor1.save();
                });
            },            
	        plugins: [
	            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
	            'searchreplace wordcount visualblocks visualchars code fullscreen',
	            'insertdatetime media nonbreaking save table contextmenu directionality',
	            'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
	        ],
	        toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
	        toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
	        image_advtab: true,
        });
    </script>
	
	<script>
		Circles.create({
			id:'circles-1',
			radius:45,
			value:'{{count($users->where("status", "=", 1))}}',
			maxValue:'{{count($users)}}',
			width:7,
			text: '{{count($users->where("status", "=", 1))}}',
			colors:['#f1f1f1', '#FF9E27'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})

		Circles.create({
			id:'circles-2',
			radius:45,
			value:'{{count($inv->where("status", "=", "Active"))}}',
			maxValue:'{{ count($inv) }}',
			width:7,
			text: '{{count($inv->where("status", "=", "Active"))}}',
			colors:['#f1f1f1', '#2BB930'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})

		Circles.create({
			id:'circles-3',
			radius:45,
			value:'{{count($deposits->where("status", "=", 1))}}',
			maxValue:'{{ count($deposits) }}',
			width:7,
			text: '{{count($deposits->where("status",      "=", 1))}}',
			colors:['#f1f1f1', '#F25961'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})

		Circles.create({
			id:'circles-logs',
			radius:45,
			value:'{{count($logs->where("admin", "=", $adm->email))}}',
			maxValue:'{{ count($logs) }}',
			width:7,
			text: '{{count($logs->where("admin", "=", $adm->email))}}',
			colors:['#f1f1f1', '#F25961'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})

		Circles.create({
			id:'circles-admLevel',
			radius:45,
			value:'{{$adm->role}}',
			maxValue:'{{$adm->role}}',
			width:7,
			text: '{{$adm->role}}',
			colors:['#f1f1f1', '#0289b1'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})

		var totalIncomeChart = document.getElementById('totalIncomeChart').getContext('2d');

		var mytotalIncomeChart = new Chart(totalIncomeChart, {
			type: 'bar',
			data: {
				labels: ["S", "M", "T", "W", "T", "F", "S", "S", "M", "T"],
				datasets : [{
					label: "Total Income",
					backgroundColor: '#ff9e27',
					borderColor: 'rgb(23, 125, 255)',
					data: [6, 4, 9, 5, 4, 6, 4, 3, 8, 10],
				}],
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				legend: {
					display: false,
				},
				scales: {
					yAxes: [{
						ticks: {
							display: false //this will remove only the label
						},
						gridLines : {
							drawBorder: false,
							display : false
						}
					}],
					xAxes : [ {
						gridLines : {
							drawBorder: false,
							display : false
						}
					}]
				},
			}
		});

		$('#lineChart').sparkline([105,103,123,100,95,105,115], {
			type: 'line',
			height: '70',
			width: '100%',
			lineWidth: '2',
			lineColor: '#ffa534',
			fillColor: 'rgba(255, 165, 52, .14)'
		});	

	</script>

	<?php
		$nw = date('Y-m-d');
		$from = date('Y-m-d', strtotime($nw. "-12 months"));
		$inv = App\investment::whereBetween('date_invested',    [$from, $nw])->orderby('id', 'asc')->get();
		// $inv = App\deposits::whereBetween('date_invested',    [$from, $nw])->orderby('id', 'asc')->get();

		$inv_dates = [];
		$inv_vals = [];	

		$dep_dates = [];
		$dep_vals = [];	

		$pt = "";
		$cnt = 0;
		foreach ($inv as $in) {
			if($pt != date('Y-m', strtotime($in->date_invested)))
			{				
				$pt = date('Y-m', strtotime($in->date_invested));
				$inv_dates[$cnt] = date('m/y', strtotime($in->date_invested));
				$m_count = App\investment::where('date_invested', 'like','%'.date('Y-m', strtotime($in->date_invested)).'%')->orderby('id', 'asc')->get();
				foreach ($m_count as $n) 
				{
					$sum_cap += $n->capital;
				}
				$inv_vals[$cnt] = $sum_cap;
				$cnt += 1;
			}
		}
	/////////////////////// for deposits //////////////////

		$nw = date('Y-m-d H:s:i');
		$from = date('Y-m-d H:s:i', strtotime($nw. "-12 months"));			
		$dep_st = App\deposits::whereBetween('created_at',    [$from, $nw])->orderby('id', 'asc')->get();
		$pt = "";
		$cnt = 0;
		foreach ($dep_st as $in) {
			if($pt != date('Y-m', strtotime($in->created_at)))
			{				
				$pt = date('Y-m', strtotime($in->created_at));
				$dep_dates[$cnt] = date('m/y', strtotime($in->created_at));
				$m_count = App\deposits::where('created_at', 'like','%'.date('Y-m', strtotime($in->created_at)).'%')->orderby('id', 'asc')->get();
				foreach ($m_count as $n) 
				{
					$sum_cap += $n->amount;
				}
				$dep_vals[$cnt] = $sum_cap;
				$cnt += 1;
			}
		}
		
	?>
	<script type="text/javascript">
		
		var inv_dates = JSON.parse('{!! json_encode($inv_dates) !!}');
		var inv_vals = JSON.parse('{!! json_encode($inv_vals) !!}');
		var dep_dates = JSON.parse('{!! json_encode($dep_dates) !!}');
		var dep_vals = JSON.parse('{!! json_encode($dep_vals) !!}');

		var ctx2 = document.getElementById('adminStatisticsChart2').getContext('2d');

		var adminStatisticsChart2 = new Chart(ctx2, {
			type: 'line',
			data: {
				labels: inv_dates, 
				datasets: 
				[ 
					{
						label: "{{ __('messages.invt_stats') }}",
						borderColor: '#08C',
						pointBackgroundColor: 'rgba(0, 84, 180, 0.6)',
						pointRadius: 0,
						backgroundColor: 'rgba(0, 84, 220, 0.4)',
						legendColor: '#08C',
						fill: true,
						borderWidth: 2,
						data: inv_vals //[154, 184, 175] 
					}, 
					{
						label: "{{ __('messages.invt_stats') }}",
						borderColor: '#0C8',
						pointBackgroundColor: 'rgba(0, 184, 80, 0.6)',
						pointRadius: 0,
						backgroundColor: 'rgba(0, 184, 40, 0.4)',
						legendColor: '#0c8',
						fill: true,
						borderWidth: 2,
						data: dep_vals //[154, 184, 175] 
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
							maxTicksLimit: 10,
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

		var myLegendContainer = document.getElementById("adminMyChartLegend2");

		// generate HTML legend
		myLegendContainer.innerHTML = adminStatisticsChart2.generateLegend();

		// bind onClick event to all LI-tags of the legend
		var legendItems = myLegendContainer.getElementsByTagName('li');
		for (var i = 0; i < legendItems.length; i += 1) {
			legendItems[i].addEventListener("click", legendClickCallback, false);
		}
	</script>

	<!-- //////////////////// Withdrawal stats /////////////////////////////////////////////////// -->

	<?php
		$nw = date('Y-m-d H:s:i');
		$from = date('Y-m-d H:s:i', strtotime($nw. "-12 months"));			
		$wd_st = App\withdrawal::whereBetween('created_at',    [$from, $nw])->orderby('id', 'asc')->get();
		$inv_dates = [];
		$inv_vals = [];	
		$pt = "";
		$cnt = 0;
		foreach ($wd_st as $in) {
			if($pt != date('Y-m', strtotime($in->created_at)))
			{				
				$pt = date('Y-m', strtotime($in->created_at));
				$inv_dates[$cnt] = date('m/y', strtotime($in->created_at));
				$m_count = App\withdrawal::where('created_at', 'like','%'.date('Y-m', strtotime($in->created_at)).'%')->orderby('id', 'asc')->get();
				foreach ($m_count as $n) 
				{
					$sum_cap += $n->amount;
				}
				$inv_vals[$cnt] = $sum_cap;
				$cnt += 1;
			}
		}		
	?>

	<script type="text/javascript">

		var inv_dates = JSON.parse('{!! json_encode($inv_dates) !!}');
		var inv_vals = JSON.parse('{!! json_encode($inv_vals) !!}');	
		
		// $.each( js_inv, function( k, val ) {
	 //        // $('#prnt').append(', ' +ky+": "+val['created_at']);
	 //        var dt = moment(new Date(val['created_at'])).format('MM/YY'); //new Date(val['created_at']);
	 //        inv_dates[k] = dt; // dt.getMonth() + '/'+ dt.getFullYear();
	 //        inv_vals[k] = val['amount'];
	 //    }); 

		var ctx = document.getElementById('wd_stats').getContext('2d');

		var wd_stats = new Chart(ctx, {
			type: 'line',
			scaleFontColor: '#CCC',
			data: {
				labels: inv_dates, //["Jan", "Feb", "Mar"], 
				datasets: 
				[ 
					{
						label: "{{ __('messages.wthdrwl_stat') }}",
						borderColor: '#FFF',
						pointBackgroundColor: 'rgba(243, 84, 93, 0.6)',
						pointRadius: 0,
						backgroundColor: 'rgba(243, 84, 93, 0.4)',
						legendColor: '#CCC',
						fill: true,
						borderWidth: 2,
						data: inv_vals //[154, 184, 175] 
					} 
					
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
							fontColor: "#CCC",							
						},
						gridLines: {
							drawTicks: false,
							display: false,
							color:"rgba(255,255,255,0.5)",
						}
					}],
					xAxes: [{
						gridLines: {
							zeroLineColor: "#FFF",
							color:"rgba(255,255,255,0.5)",

						},
						ticks: {
							padding: 10,
							fontStyle: "500",
							fontColor: "#CCC",
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

		
	</script>
	{{ homeLogin() }}
	<script >
		$(document).ready(function() {
			$('#basic-datatables').DataTable({
			});

			$('#multi-filter-select').DataTable( {
				"pageLength": 5,
				initComplete: function () {
					this.api().columns().every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value=""></option></select>')
						.appendTo( $(column.footer()).empty() )
						.on( 'change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
								);

							column
							.search( val ? '^'+val+'$' : '', true, false )
							.draw();
						} );

						column.data().unique().sort().each( function ( d, j ) {
							select.append( '<option value="'+d+'">'+d+'</option>' )
						} );
					} );
				}
			});

			// Add Row
			$('#add-row').DataTable({
				"pageLength": 5,
			});

			var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

			$('#addRowButton').click(function() {
				$('#add-row').dataTable().fnAddData([
					$("#addName").val(),
					$("#addPosition").val(),
					$("#addOffice").val(),
					action
					]);
				$('#addRowModal').modal('hide');

			});
		});
	</script>

	<!--<div id="p_loading" class="container p_loading" >-->
 <!--     <div class="row">-->
 <!--       <div class="col-md-4">&emps;</div>-->
 <!--       <div class="col-md-4" style="margin-top: 25%; color: #FFF;" align="Center">-->
          <!--<img src="/img/loader.gif" style="height: 30px; width: 30px;">-->
 <!--       </div>-->
 <!--     </div>-->
 <!--   </div>-->

    <div id="err" class="alert alert-danger popup_alert_err" >
	</div>
	<div id="suc" class="alert alert-success popup_alert_suc">
	</div>

	@include('user.inc.alert')

	@if(Session::has('status')  && Session::get('msgType') == 'suc')         
	    <script type="text/javascript">            
	        $('#succ').show();
	    </script>
	    {{Session::forget('status')}}
	    {{Session::forget('msgType')}}         
	@elseif(Session::has('status')  && Session::get('msgType') == 'err')        
	    <script type="text/javascript">
	        $('#errr_msg').html('{{Session::get('status')}}');
	        $('#errr').show();
	    </script>
	    {{Session::forget('status')}}
	    {{Session::forget('msgType')}}
	@endif

	@if(Session::get('toast_type') == 'err' )
		<script type="text/javascript">
			$('#err').html('{{Session::get('toast_msg')}}')
            $('#err').show().animate({ width: "30%" }, "1000").delay(10000).fadeOut(100);
		</script>
	@endif
	@if(Session::get('toast_type') == 'suc' )
		<script type="text/javascript">
			$('#suc').html('{{Session::get('toast_msg')}}')
            $('#suc').show().animate({ width: "30%" }, "1000").delay(10000).fadeOut(100);
		</script>
	@endif
	<script src="/atlantis/main.js"></script>


</body>
</html>