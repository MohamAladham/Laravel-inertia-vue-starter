<template xmlns:inertia="http://www.w3.org/1999/html">

    <page-head :title="title"/>
    <Breadcrumb :title="title" :links="breadcrumbLinks"/>

    <div class="content-body">

        <Card>
            <template #header>
                <div class="col-sm-3">
                    <table-search :routeSearch="['admin.admins.index', {}]"/>
                </div>
                <div class="col-sm-9 text-right">
                    <inertia-link :href="route('admin.admins.create')" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i>
                        إضافة جديد
                    </inertia-link>
                    &nbsp;
                    <a :href="route('admin.admins.export')" class="btn btn-sm btn-info">
                        <i class="fas fa-file-excel"></i>
                        تصدير البيانات
                    </a>
                </div>
            </template>
            <template #body>
                <div v-if="items.data.length" class="table-responsive">

                    <table class="table">
                        <thead>
                        <tr>
                            <th class="">
                                اسم المدير
                            </th>

                            <th class="">
                                البريد الإلكتروني
                            </th>

                            <th class="text-center">التحكم</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in items.data">
                            <td>
                                <inertia-link :href="route('admin.admins.edit', item.id)">
                                    <img :src="item.photo" class="rounded-circle" style="width:40px; height: 40px; margin-left: 3px"/>
                                    {{ item.name }}
                                </inertia-link>
                            </td>

                            <td class="">
                                {{ item.email }}
                            </td>

                            <td class="text-center">
                                <inertia-link
                                    :href="route('admin.admins.edit', item.id)"
                                    class="btn btn-sm btn-info"
                                >تعديل
                                </inertia-link>
                                &nbsp;
                                <a
                                    @click="openDeleteModal(item.id)"
                                    class="btn btn-sm btn-danger"
                                >
                                    حذف
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
                <Paginate v-if="items.data.length && items.total > items.per_page" :items="items"/>
                <div v-if="!items.data.length" class="alert alert-info">
                    لم يتم العثور على نتائج..
                </div>
            </template>
        </Card>

    </div>


    <!--    modal-->
    <confirm-modal @confirm="deleteItem"/>


</template>

<script>
import AdminLayout from "@/Layouts/Admin/Layout";
import ConfirmModal from "@/Components/Admin/ConfirmModal";
import Breadcrumb from "@/Layouts/Admin/Breadcrumb";
import Card from "@/Components/Admin/Card";
import Paginate from "@/Components/Admin/Paginate";
import TableSearch from "@/Components/Admin/TableSearch";
import PageHead from "@/Layouts/Admin/PageHead";

export default {
    layout: AdminLayout,
    props: ["items", 'errors', 'title'],
    components: {PageHead, TableSearch, Card, Breadcrumb, ConfirmModal, Paginate},
    data() {
        return {
            deleteItemId: null,
            breadcrumbLinks: []
        };
    },
    methods: {
        openDeleteModal(itemId) {
            $('#confirmModal').modal('show');
            this.deleteItemId = itemId;
        },
        deleteItem() {
            this.$inertia.delete(route("admin.admins.destroy", this.deleteItemId), {
                onSuccess: page => {
                    generalOnSuccess('تم حذف السجل بنجاح!');
                    $('#confirmModal').modal('hide');
                }
            });
        },
    },
};
</script>

