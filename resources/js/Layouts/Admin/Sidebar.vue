<template>

    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto">
                    <inertia-link class="navbar-brand" :href="route('admin.dashboard')">
                        <span class="brand-logo">
                             <img :src="this.$page.props.adminPanelLogo">
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
                    :class="[isActive(index) && !link.subLinks?'active':'', link.subLinks&&isActive(index)?'sidebar-group-active open':'', link.subLinks?'has-sub':'','nav-item']">

                    <template v-if="!link.subLinks">
                        <inertia-link class="d-flex align-items-center" :href="link.url" v-if="checkPermission(link)">
                            <i :data-feather="link.icon"></i>
                            <span class="menu-title text-truncate">{{ link.title }}</span>
                            <span v-if="link.badge" class="badge badge-light-danger badge-pill ml-auto mr-1">{{ link.badge }}</span>
                        </inertia-link>
                    </template>

                    <template v-else>
                        <a class="d-flex align-items-center" :href="link.url" v-if="checkPermission(link)">
                            <i :data-feather="link.icon"></i>
                            <span class="menu-title text-truncate">{{ link.title }}</span>
                            <span v-if="link.badge" class="badge badge-light-danger badge-pill ml-auto mr-1">{{ link.badge }}</span>
                        </a>

                        <ul v-if="link.subLinks" class="menu-content">
                            <li v-for="(subLink, subIndex) in link.subLinks" :key="link.title + subLink.title" :class="isActive(index,subIndex)?'active':''">
                                <inertia-link class="d-flex align-items-center" :href="subLink.url" v-if="checkPermission(subLink)">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item">{{ subLink.title }}</span>
                                </inertia-link>
                            </li>
                        </ul>
                    </template>

                </li>

                <li :class="['nav-item']">
                    <inertia-link class="d-flex align-items-center" :href="route('logout')" method="post" as="a">
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
                    activeCheck: ['admin.dashboard', 'admin.admin']
                },
                {
                    title: 'المستخدمون',
                    icon: 'users',
                    url: route('admin.users.index'),
                    activeCheck: ['admin.users.*'],
                    permissions: ['user_show'],
                },
                {
                    title: 'المديرون',
                    icon: 'users',
                    url: route('admin.admins.index'),
                    activeCheck: ['admin.admins.*', 'admin.roles.*'],
                    permissions: ['admin_show', 'role_manage'],
                    subLinks: [
                        {
                            title: 'عرض الكل',
                            url: route('admin.admins.index'),
                            activeCheck: ['admin.admins.*'],
                            permissions: ['admin_show'],
                        },
                        {
                            title: 'الأدوار والصلاحيات',
                            url: route('admin.roles.index'),
                            activeCheck: ['admin.roles.*'],
                            permissions: ['role_manage'],
                        },
                    ]
                },
                {
                    title: 'الإعدادات',
                    icon: 'settings',
                    url: null,
                    activeCheck: ['admin.settings.*', 'admin.countries.*', 'admin.menus.*', 'admin.notification_templates.*'],
                    permissions: ['setting_manage', 'menu_manage', 'country_manage', 'notification_template_manage'],
                    subLinks: [
                        {
                            title: 'الإعدادات العامة',
                            url: route('admin.settings.general'),
                            activeCheck: ['admin.settings.general'],
                            permissions: ['setting_manage'],
                        },
                        {
                            title: 'قوالب الإشعارات',
                            url: route('admin.notification_templates.index'),
                            activeCheck: ['admin.notification_templates.*'],
                            permissions: ['notification_template_manage'],
                        },
                        {
                            title: 'إعدادات القوائم',
                            url: route('admin.menus.index'),
                            activeCheck: ['admin.menus.*'],
                            permissions: ['menu_manage'],
                        },
                        {
                            title: 'الدول والمدن',
                            url: route('admin.countries.index'),
                            activeCheck: ['admin.countries.*'],
                            permissions: ['country_manage'],
                        },
                    ]
                },

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
        },

        checkPermission(link) {
            let this_ = this;
            let permissions = link.permissions;

            if (!permissions) {
                return true;
            }

            for (let i = 0; i < permissions.length; i++) {
                if (this_.$page.props.auth.user.permissions.includes(permissions[i])) {
                    return true;
                }
            }

            return false;
        }
    },
    mounted() {
        this.links = this.getLinks;
    },
};
</script>
