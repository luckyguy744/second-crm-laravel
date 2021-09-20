<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{$settings->site_title}} - {{$settings->site_descr}}</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="/img/{{$settings->site_logo}}" type="image/x-icon"/>

    <!-- Fonts and icons -->
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

    <!-- CSS Files -->
    <link rel="stylesheet" href="/atlantis/css/bootstrap.min.css">
    <link rel="stylesheet" href="/atlantis/css/atlantis.min.css">
    <link rel="stylesheet" href="/atlantis/style.css">

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="/atlantis/css/demo.css">
    <!-- jquery lib -->
    <script src="/atlantis/js/core/jquery.3.2.1.min.js"></script>
</head>


	@yield('content')

<div id="err" class="alert alert-danger popup_alert_err" ></div>
<div id="suc" class="alert alert-success popup_alert_suc"></div>

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
	

<script src="/atlantis/js/core/popper.min.js"></script>
<script src="/atlantis/js/core/bootstrap.min.js"></script>

<!-- jQuery UI -->
<script src="/atlantis/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="/atlantis/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

<!-- jQuery Scrollbar -->
<script src="/atlantis/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>


<!-- Chart JS -->
<script src="/atlantis/js/plugin/chart.js/chart.min.js"></script>

<!-- jQuery Sparkline -->
<script src="/atlantis/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

<!-- Chart Circle -->
<script src="/atlantis/js/plugin/chart-circle/circles.min.js"></script>

<!-- Datatables -->
<script src="/atlantis/js/plugin/datatables/datatables.min.js"></script>

<!-- Bootstrap Notify -->
<script src="/atlantis/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

<!-- jQuery Vector Maps -->
<script src="/atlantis/js/plugin/jqvmap/jquery.vmap.min.js"></script>
<script src="/atlantis/js/plugin/jqvmap/maps/jquery.vmap.world.js"></script>

<!-- Sweet Alert -->
<script src="/atlantis/js/plugin/sweetalert/sweetalert.min.js"></script>

<!-- Atlantis JS -->
<script src="/atlantis/js/atlantis.min.js"></script>

<!-- Atlantis DEMO methods, don't include it in your project! -->
<script src="/atlantis/js/setting-demo.js"></script>
<!-- <script src="/atlantis/js/demo.js"></script>    -->
<script src="/atlantis/js/moment.js"></script>
<script src="/atlantis/main.js"></script>

<script type="text/javascript">    
    $(document).ready(function(){
        var timeout = 10000;
        var num = 10
        setInterval(function() {
            $('#csrf').val('{{ csrf_token() }}');
            // alert('here');
        }, timeout);
    });                                                    
</script>

</body>

</html>

