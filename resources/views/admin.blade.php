<!DOCTYPE html>


<html class="loading" lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-textdirection="rtl">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title></title>
    <link rel="apple-touch-icon" href="{{url('/')}}/assets/admin/images/ico/favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="{{url('/')}}/assets/admin/images/ico/favicon.ico">
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

<!-- BEGIN: Theme JS-->
<script src="{{url('/')}}/assets/admin/js/core/app-menu.js"></script>
<script src="{{url('/')}}/assets/admin/js/core/app.js"></script>
<!-- END: Theme JS-->

<!-- Sweet Alerts js -->
<script src="{{url('/')}}/assets/admin/vendors/js/sweetalert2/sweetalert2.min.js"></script>
<!-- Select2 -->
<script src="{{url('/')}}/assets/admin/vendors/js/forms/select/select2.full.min.js"></script>

<script src="{{url('/')}}/assets/admin/custom/js/script.js"></script>
@inertia

@routes
<script src="{{ mix('js/app.js') }}"></script>

<script>
    $(window).on('load', function () {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })
</script>
</body>
<!-- END: Body-->
</html>
