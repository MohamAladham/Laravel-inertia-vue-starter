<template xmlns:inertia="http://www.w3.org/1999/html">

    <page-head :title="title"/>
    <Breadcrumb :title="title" :links="breadcrumbLinks"/>

    <div class="content-body">

        <div class="row mt-2 mb-2">
            <div class="col-sm-3">
                <table-search :routeSearch="['admin.roles.index', {}]"/>
            </div>
            <div class="col-sm-9 text-right">
                <inertia-link :href="route('admin.roles.create')" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i>
                    إضافة جديد
                </inertia-link>
            </div>
        </div>

        <div v-if="items.data.length" class="card_results_container">
            <div class="row card_results_head">
                <div class="col">
                    اسم الدور
                </div>
                <div class="col col-2 text-center">
                    الخيارات
                </div>
            </div>

            <Card class="card card_results" v-for="item in items.data">
                <template #body>
                    <div class="row">
                        <div class="col">
                            <inertia-link :href="route('admin.roles.edit', item.id)">
                                {{ item.name }}
                            </inertia-link>
                        </div>
                        <div class="col col-2 text-center">
                            <inertia-link
                                :href="route('admin.roles.edit', item.id)"
                                class="btn btn-sm btn-info"
                            >تعديل
                            </inertia-link>
                            <a
                                @click="openDeleteModal(item.id)"
                                class="btn btn-sm btn-danger">
                                حذف
                            </a>
                        </div>
                    </div>
                </template>
            </Card>

        </div>


        <Paginate v-if="items.data.length && items.total > items.per_page" :items="items"/>
        <div v-if="!items.data.length" class="alert alert-info">
            لم يتم العثور على نتائج..
        </div>

    </div>

</template>

<script>
import AdminLayout from "@/Layouts/Admin/Layout";
import Breadcrumb from "@/Layouts/Admin/Breadcrumb";
import Card from "@/Components/Admin/Card";
import Paginate from "@/Components/Admin/Paginate";
import TableSearch from "@/Components/Admin/TableSearch";
import PageHead from "@/Layouts/Admin/PageHead";

export default {
    layout: AdminLayout,
    props: ["items", 'errors', 'title'],
    components: {PageHead, TableSearch, Card, Breadcrumb, Paginate},
    data() {
        return {
            breadcrumbLinks: [
                {url: route('admin.admins.index'), title: 'المديرون'},
            ],

        };
    },
    methods: {
        openDeleteModal(itemId) {
            let this_ = this;
            confirm('', function () {
                this_.$inertia.delete(route("admin.roles.destroy", itemId), {
                    onSuccess: page => {
                    }
                });
            });
        },
    },
};
</script>

