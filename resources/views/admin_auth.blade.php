<!DOCTYPE html>
<html class="loading" lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-textdirection="rtl">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="author" content="MOHAMMED">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="apple-touch-icon" href="{{url('/')}}/assets/admin/images/ico/favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="{{url('/')}}/assets/admin/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/admin/vendors/css/vendors-rtl.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/admin/css-rtl/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/admin/css-rtl/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/admin/css-rtl/colors.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/admin/css-rtl/components.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/admin/css-rtl/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/admin/css-rtl/themes/bordered-layout.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/admin/css-rtl/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/admin/css-rtl/plugins/forms/form-validation.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/admin/css-rtl/pages/page-auth.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/admin/css-rtl/custom-rtl.css">
    <!-- END: Custom CSS-->

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <!-- Scripts -->
    @routes
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page" data-asset-path="{{asset('assets/admin/')}}">


@inertia


<script src="{{ mix('js/app.js') }}"></script>
<!-- BEGIN: Vendor JS-->
<script src="{{url('/')}}/assets/admin/vendors/js/vendors.min.js"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{{url('/')}}/assets/admin/vendors/js/forms/validation/jquery.validate.min.js"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{url('/')}}/assets/admin/js/core/app-menu.js"></script>
<script src="{{url('/')}}/assets/admin/js/core/app.js"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="{{url('/')}}/assets/admin/js/scripts/pages/page-auth-login.js"></script>
<!-- END: Page JS-->


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
