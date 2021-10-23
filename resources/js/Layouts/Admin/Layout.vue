<template>

    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow">
        <div class="navbar-container d-flex content">
            <div class="bookmark-wrapper d-flex align-items-center">
                <ul class="nav navbar-nav d-xl-none">
                    <li class="nav-item">
                        <a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon" data-feather="menu"></i></a>
                    </li>
                </ul>
                <ul class="nav navbar-nav">
                    <li class="nav-item d-none d-lg-block">
                        <a class="nav-link nav-link-style"><i class="ficon" data-feather="moon"></i></a></li>
                </ul>
            </div>
            <ul class="nav navbar-nav align-items-center ml-auto">
                <li class="nav-item dropdown dropdown-notification mr-25">
                    <inertia-link class="nav-link" :href="route('admin.notifications')" data-toggle="dropdown">
                        <i class="ficon" data-feather="bell"></i>
                        <span v-show="this.$page.props.auth.unreadNotificationsCount" id="notificationsBadge" class="badge badge-pill badge-danger badge-up">{{ this.$page.props.auth.unreadNotificationsCount }}</span>
                    </inertia-link>
                </li>
                <li class="nav-item dropdown dropdown-user">
                    <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="user-nav d-sm-flex d-none">
                            <span class="user-name font-weight-bolder">{{ this.$page.props.auth.user.name }}</span><span class="user-status">مدير</span>
                        </div>
                        <span class="avatar"><img class="round" :src="this.$page.props.auth.user.photo" alt="avatar" height="40" width="40"><span class="avatar-status-online"></span></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
                        <a class="dropdown-item" href="javascript:void(0);"><i class="mr-50" data-feather="user"></i> الملف الشخصي</a>
                        <div class="dropdown-divider"></div>
                        <inertia-link class="dropdown-item" :href="route('logout')" method="post" as="a">
                            <i class="mr-50" data-feather="power"></i> تسجيل الخروج
                        </inertia-link>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    <sidebar/>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">

            <slot/>

        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light mt-5">
        <p class="clearfix mb-0">
            <span class="float-md-right d-block d-md-inline-block mt-25">جميع الحقوق محفوظة &copy; {{ (new Date()).getFullYear() }} </span>
        </p>
    </footer>
    <button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
    <!-- END: Footer-->

</template>

<script>

import Sidebar from "@/Layouts/Admin/Sidebar";

export default {
    components: {Sidebar},
    props: [],
};
</script>
