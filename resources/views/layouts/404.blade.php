<!doctype html>
<html class="fixed">

<head>

    <!-- Basic -->
    <meta charset="UTF-8">

    <title>Altcel II</title>
    <meta name="keywords" content="HTML5 Admin Template" />
    <meta name="description" content="JSOFT Admin - Responsive HTML5 Template">
    <meta name="author" content="JSOFT.net">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <link rel="shortcut icon" type="image/png" href="{{asset('images/Altcel2_Ok@2x.png')}}">

    <!-- Web Fonts  -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light"
        rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{asset('octopus/assets/vendor/bootstrap/css/bootstrap.css')}}" />
    <link rel="stylesheet" href="{{asset('octopus/assets/vendor/font-awesome/css/font-awesome.css')}}" />
    <link rel="stylesheet" href="{{asset('octopus/assets/vendor/magnific-popup/magnific-popup.css')}}" />
    <link rel="stylesheet" href="{{asset('octopus/assets/vendor/bootstrap-datepicker/css/datepicker3.css')}}" />
    <!-- Specific Page Vendor CSS -->
	<link rel="stylesheet" href="{{asset('octopus/assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css')}}" />

    <!-- Specific Page Vendor CSS -->
    <link rel="stylesheet" href="{{asset('octopus/assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css')}}" />
    <link rel="stylesheet" href="{{asset('octopus/assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css')}}" />
    <link rel="stylesheet" href="{{asset('octopus/assets/vendor/morris/morris.css')}}" />
    <link rel="stylesheet" href="{{asset('octopus/assets/vendor/pnotify/pnotify.custom.css')}}" />
    <link rel="stylesheet" href="{{asset('octopus/assets/vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.css')}}" />

    <!-- Estilos Calendar -->
    <link rel="stylesheet" href="{{asset('octopus/assets/vendor/fullcalendar/fullcalendar.css')}}" />
    <link rel="stylesheet" href="{{asset('octopus/assets/vendor/fullcalendar/fullcalendar.print.css')}}" media="print" />

    <link rel="stylesheet" href="{{asset('octopus/assets/vendor/select2/select2.css')}}" />
	<link rel="stylesheet" href="{{asset('octopus/assets/vendor/jquery-datatables-bs3/assets/css/datatables.css')}}" />
    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{asset('octopus/assets/stylesheets/theme.css')}}" />

    <!-- Skin CSS -->
    <link rel="stylesheet" href="{{asset('octopus/assets/stylesheets/skins/default.css')}}" />

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{asset('octopus/assets/stylesheets/theme-custom.c')}}ss">
        
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- Head Libs -->
    <script src="{{asset('octopus/assets/vendor/modernizr/modernizr.js')}}"></script>
    <script src="{{asset('octopus/assets/vendor/jquery/jquery.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

</head>

<body>

    <!-- start: page -->
        <section class="body-error error-inside">
            <div class="center-error">

                <div class="row">
                    <div class="col-md-8">
                        <div class="main-error mb-xlg">
                            <h3 class="error-code text-dark text-center text-semibold m-none">Woops!!<i class="fa fa-times-circle"></i></h3>
                            <p class="error-explanation text-center mt-md">El número que ingresaste no existe dentro de nuestros registros, intenta de nuevo o consulta a Desarrollo.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <!-- end: page -->
    
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script> -->
<script src="{{asset('octopus/assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js')}}"></script>
<script src="{{asset('octopus/assets/vendor/liquid-meter/liquid.meter.js')}}"></script>
<script src="{{asset('octopus/assets/vendor/snap-svg/snap.svg.js')}}"></script>
<script>

$('#meter').liquidMeter({
		shape: 'circle',
		color: '#0088CC',
		background: '#272A31',
        stroke: '#33363F',
		fontSize: '24px',
		fontWeight: '600',
		textColor: '#FFFFFF',
		liquidOpacity: 0.9,
		liquidPalette: ['#0088CC'],
		speed: 3000
	});

	/*
	Liquid Meter Dark
	*/
	$('#meterDark').liquidMeter({
		shape: 'circle',
		color: '#0088CC',
		background: '#272A31',
		stroke: '#33363F',
		fontSize: '24px',
		fontWeight: '600',
		textColor: '#FFFFFF',
		liquidOpacity: 0.9,
		liquidPalette: ['#0088CC'],
		speed: 3000
	});

</script>



 <!-- Vendor -->
 <script src="{{asset('octopus/assets/vendor/jquery/jquery.js')}}"></script>
    <script src="{{asset('octopus/assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js')}}"></script>
    <script src="{{asset('octopus/assets/vendor/bootstrap/js/bootstrap.js')}}"></script>
    <script src="{{asset('octopus/assets/vendor/nanoscroller/nanoscroller.js')}}"></script>
    <script src="{{asset('octopus/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('octopus/assets/vendor/magnific-popup/magnific-popup.js')}}"></script>
    <script src="{{asset('octopus/assets/vendor/jquery-placeholder/jquery.placeholder.js')}}"></script>

    <!-- Examples -->
    <script src="{{asset('octopus/assets/javascripts/dashboard/examples.dashboard.js')}}"></script>

    <!-- Specific Page Vendor -->
    <script src="{{asset('octopus/assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.js')}}"></script>
    <script src="{{asset('octopus/assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js')}}"></script>
    
    <!-- Librerías DataTable -->
    <script src="{{asset('octopus/assets/vendor/select2/select2.js')}}"></script>
    <script src="{{asset('octopus/assets/vendor/jquery-datatables/media/js/jquery.dataTables.js')}}"></script>
    <script src="{{asset('octopus/assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js')}}"></script>
    <script src="{{asset('octopus/assets/vendor/jquery-datatables-bs3/assets/js/datatables.js')}}"></script>

    <!-- Librerías Callendar -->
    <script src="{{asset('octopus/assets/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js')}}"></script>
    <script src="{{asset('octopus/assets/vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js')}}"></script>
    <script src="{{asset('octopus/assets/vendor/fullcalendar/lib/moment.min.js')}}"></script>
    <script src="{{asset('octopus/assets/vendor/fullcalendar/fullcalendar.js')}}"></script>

    <!-- Theme Base, Components and Settings -->
    <script src="{{asset('octopus/assets/javascripts/theme.js')}}"></script>

    <!-- Theme Custom -->
    <script src="{{asset('octopus/assets/javascripts/theme.custom.js')}}"></script>

    <!-- Theme Initialization Files -->
    <script src="{{asset('octopus/assets/javascripts/theme.init.js')}}"></script>
    <!-- Examples -->
    <script src="{{asset('octopus/assets/javascripts/tables/examples.datatables.default.js')}}"></script>
    

</body>

</html>