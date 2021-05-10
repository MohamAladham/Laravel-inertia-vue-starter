<template>

    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto">
                    <inertia-link class="navbar-brand" :href="route('admin.dashboard')">
                        <span class="brand-logo">
                             <img src="/assets/admin/images/logo/logo.png">
                        </span>
                        <h2 class="brand-text">{{ this.$page.props.appName }}</h2>
                    </inertia-link>
                </li>
                <li class="nav-item nav-toggle">
                    <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a>
                </li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

                <li v-for="(link, index) in links" :key="link.title"
                    :class="[isActive(index)?'active':'', link.subLinks&&isActive(index)?'sidebar-group-active open':'', link.subLinks?'has-sub':'','nav-item']">

                    <template v-if="!link.subLinks">
                        <inertia-link class="d-flex align-items-center" :href="link.url">
                            <i :data-feather="link.icon"></i>
                            <span class="menu-title text-truncate">{{ link.title }}</span>
                            <span v-if="link.badge" class="badge badge-light-danger badge-pill ml-auto mr-1">{{ link.badge }}</span>
                        </inertia-link>
                    </template>

                    <template v-else>
                        <a class="d-flex align-items-center" :href="link.url">
                            <i :data-feather="link.icon"></i>
                            <span class="menu-title text-truncate">{{ link.title }}</span>
                            <span v-if="link.badge" class="badge badge-light-danger badge-pill ml-auto mr-1">{{ link.badge }}</span>
                        </a>

                        <ul v-if="link.subLinks" class="menu-content">
                            <li v-for="(subLink, subIndex) in link.subLinks" :key="link.title + subLink.title" :class="isActive(index,subIndex)?'active':''">
                                <inertia-link class="d-flex align-items-center" :href="subLink.url">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item">{{ subLink.title }}</span>
                                </inertia-link>
                            </li>
                        </ul>
                    </template>

                </li>

                <li :class="['nav-item']">
                    <inertia-link class="d-flex align-items-center" :href="route('logout')" method="post" as="button">
                        <i data-feather="log-out"></i>
                        <span class="menu-title text-truncate">تسجيل الخروج</span>
                    </inertia-link>
                </li>

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
                    activeCheck: ['admin.dashboard']
                },
                //////////////////////////////////////////////
                /*       {
                           title: 'المحاضرات',
                           icon: 'monitor',
                           url: null,
                           subLinks: [
                               {
                                   title: 'عرض الكل',
                                   url: null,
                                   activeCheck: ['admin.webinars.index']
                               },
                               {
                                   title: 'إضافة جديد',
                                   url: null,
                                   activeCheck: ['admin.webinars.create']
                               },
                           ]
                       },*/
                //////////////////////////////////////////////
                {
                    title: 'الإعدادات',
                    icon: 'settings',
                    url: null,
                    activeCheck: ['admin.countries.*'],
                    subLinks: [
                        {
                            title: 'الدول والمدن',
                            url: route('admin.countries.index'),
                            activeCheck: ['admin.countries.*']
                        },
                    ]
                },
                //////////////////////////////////////////////


            ];
        }
    },
    methods: {
        isActive(index, subIndex = false) {
            let currentUrl = this.$page.url.substr(1); //unused, but it's required to keep calling the method!
            let activeCheck = [];

            if (subIndex === false) {
                activeCheck = this.links[index].activeCheck;
            } else {
                activeCheck = this.links[index].subLinks[subIndex].activeCheck;
            }

            if (!activeCheck.length) {
                return false
            }

            for (let i = 0; i < activeCheck.length; i++) {
                if (route().current(activeCheck[i])) {
                    return true;
                }
            }

            // console.log(index, subIndex, route().current(activeCheck), route().current(), activeCheck);
        }
    },
    mounted() {
        this.links = this.getLinks;
    },
};
</script>

<style>
</style>
