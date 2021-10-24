@php
    $favicon = get_setting( 'favicon', asset( 'assets/admin/custom/img/logo_placeholder.png' ) );
@endphp
<!DOCTYPE html>


<html class="loading" lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-textdirection="rtl">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title></title>
    <link rel="apple-touch-icon" href="{{$favicon}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{$favicon}}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/admin/vendors/css/vendors-rtl.min.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/admin/fonts/font-awesome/css/font-awesome.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/admin/css-rtl/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/admin/css-rtl/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/admin/css-rtl/colors.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/admin/css-rtl/components.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/admin/css-rtl/themes/dark-layout.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/admin/css-rtl/core/menu/menu-types/vertical-menu.css">
    <!-- END: Page CSS-->

    <!-- Sweet Alert-->
    <link href="{{url('/')}}/assets/admin/vendors/js/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
    <!-- Select2 -->
    <link href="{{url('/')}}/assets/admin/vendors/css/forms/select/select2.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/admin/custom/js/toastr/toastr.min.css">


    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/admin/css-rtl/custom-rtl.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/admin/custom/css/style.css">
    <!-- END: Custom CSS-->

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <script>
        var site_url = "{{url('/')}}";
    </script>

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">

<!-- BEGIN: Vendor JS-->
<script src="{{url('/')}}/assets/admin/vendors/js/vendors.min.js"></script>

<!-- BEGIN: Page Vendor JS-->
<!-- END: Page Vendor JS-->


<!-- Sweet Alerts js -->
<script src="{{url('/')}}/assets/admin/vendors/js/sweetalert2/sweetalert2.min.js"></script>
<!-- Select2 -->
<script src="{{url('/')}}/assets/admin/vendors/js/forms/select/select2.full.min.js"></script>

<script src="{{url('/')}}/assets/admin/custom/js/toastr/toastr.min.js"></script>
<script src="{{url('/')}}/assets/admin/custom/js/jquery-play-sound/jquery.playSound.js"></script>

<script src="{{url('/')}}/assets/admin/custom/js/script.js"></script>
@inertia

@routes
<script src="{{ mix('js/app.js') }}"></script>


<!-- BEGIN: Theme JS-->
<script src="{{url('/')}}/assets/admin/js/core/app-menu.js"></script>
<script src="{{url('/')}}/assets/admin/js/core/app.js"></script>
<!-- END: Theme JS-->

<script>
    $(window).on('load', function () {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })

    toastr.options.rtl = true;
    toastr.options.preventDuplicates = true;
    toastr.options.positionClass = 'toast-top-left';

    window.laravel_echo_port = '{{env("LARAVEL_ECHO_PORT")}}';
</script>
<script src="http://{{request()->getHost()}}:6001/socket.io/socket.io.js"></script>
<script src="{{ url('/js/laravel-echo-setup.js') }}" type="text/javascript"></script>


<script type="text/javascript">

    @php
        /* SAMPLE
        Echo.private('broadcastOn')
            .listen('.broadcastAs', (e) => {

            });*/
    @endphp

    if (window.Echo) {
        Echo.private('App.Models.Admin.{{auth()->id()}}').notification((notification) => {
            console.log(notification);

            toastr.options.onclick = function () {
                window.location.href = notification.url;
            };
            toastr.info((notification.message));
            $.playSound("{{url('assets/admin/custom/notification.mp3')}}");

            if (parseInt(notification.unread_count) > 0) {
                $('#notificationsBadge').text(notification.unread_count).show();
            }
        });
    }

</script>


</body>
<!-- END: Body-->
</html>
