<template>
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">{{ title }}</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <inertia-link :href="route('admin.dashboard')">الصفحة الرئيسية</inertia-link>
                            </li>
                            <li v-for="link in links" class="breadcrumb-item">
                                <inertia-link :href="link.url">{{ link.title }}</inertia-link>
                            </li>
                            <li class="breadcrumb-item active">{{ title }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'Breadcrumb',
    props: {
        title: '',
        links: Array,
    }
}
</script>
