<template>

    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto">
                    <a class="navbar-brand" :href="route('admin.dashboard')">
                        <span class="brand-logo">
                             <img src="/assets/admin/images/logo/logo.png">
                        </span>
                        <h2 class="brand-text">{{ this.$page.props.appName }}</h2>
                    </a></li>
                <li class="nav-item nav-toggle">
                    <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a>
                </li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

                <li v-for="link in links" :key="link.title" :class="{'active':link.isActive}" class="nav-item">
                    <a class="d-flex align-items-center" :href="link.url">
                        <i :data-feather="link.icon"></i>
                        <span class="menu-title text-truncate">{{ link.title }}</span>
                        <span v-if="link.badge" class="badge badge-light-danger badge-pill ml-auto mr-1">{{ link.badge }}</span>
                    </a>

                    <ul v-if="link.subLinks" class="menu-content">
                        <li v-for="subLink in link.subLinks" :key="link.title + subLink.title" :class="{'active':subLink.isActive}">
                            <a class="d-flex align-items-center" :href="subLink.url">
                                <i data-feather="circle"></i>
                                <span class="menu-item">{{ subLink.title }}</span>
                            </a>
                        </li>
                    </ul>

                </li>

                <!--
                <li class=" nav-item">
                    <a class="d-flex align-items-center" href="#">
                    <i data-feather="layout"></i>
                    <span class="menu-title text-truncate">Page Layouts</span>
                    <span class="badge badge-light-danger badge-pill ml-auto mr-1">2</span>
                    </a>
                    <ul class="menu-content">
                        <li>
                            <a class="d-flex align-items-center" href="layout-blank.html">
                            <i data-feather="circle"></i>
                            <span class="menu-item">Layout Blank</span>
                            </a>
                        </li>
                    </ul>
                </li>
                                -->

            </ul>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            links: []
        }
    },
    computed: {
        getLinks() {
            return [
                {
                    title: 'الرئيسية',
                    icon: 'home',
                    url: route('admin.dashboard'),
                    isActive: this.getSegments() === 'dashboard'
                },
                //////////////////////////////////////////////
                {
                    title: 'المحاضرات',
                    icon: 'monitor',
                    url: null,
                    subLinks: [
                        {
                            title: 'عرض الكل',
                            url: null,
                            isActive: this.getSegments() === 'webinars' && (!this.getSegments(2) || this.getSegments(2) === 'index')
                        },
                        {
                            title: 'إضافة جديد',
                            url: null,
                            isActive: this.getSegments() === 'webinars' && this.getSegments(2) === 'create'
                        },
                    ]
                },
                //////////////////////////////////////////////
                {
                    title: 'الإعدادات',
                    icon: 'settings',
                    url: null,
                    subLinks: [
                        {
                            title: 'الدول والمدن',
                            url: route('admin.countries.index'),
                            isActive: this.getSegments() === 'countries'
                        },
                    ]
                },
                //////////////////////////////////////////////


            ];
        }
    },
    methods: {
        getSegments(index = 1) {
            let link = this.$page.url
            console.log(this.$page.url);
            let split = link.split('/');
            split.splice(split, 1); //unset /admin

            return split[index] ? split[index] : '';
        },
    },
    mounted() {
        this.links = this.getLinks;
    },
};
</script>

<style>
</style>
