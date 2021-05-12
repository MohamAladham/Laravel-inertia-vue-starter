<template>
    <page-head :title="title"/>
    <Breadcrumb :title="title" :links="breadcrumbLinks"/>

    <div class="content-body">

        <Card>
            <template #header>
                <div class="col-sm-3">
                    <table-search :routeSearch='["admin.countries.regions.cities.index", {country: this.country, region: this.region,}]'/>
                </div>
                <div class="col-sm-9 text-right">
                    <a data-toggle="modal" data-target="#createModal" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i>
                        إضافة جديد
                    </a>
                </div>
            </template>
            <template #body>
                <div v-if="items.data.length" class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="">
                                اسم المنطقة
                            </th>
                            <th class="text-center">التحكم</th>
                        </tr>
                        </thead>


                        <draggable v-model="items.data" tag="tbody" item-key="id" :animation="200" @end="endSorting()">
                            <template #item="{ element }">
                                <tr>
                                    <td>
                                        {{ element.name }}
                                    </td>

                                    <td class="text-center">
                                        <a
                                            @click="getItem(element.id)"
                                            class="btn btn-sm btn-info"
                                            href="javascript:;"
                                        >تعديل
                                        </a>
                                        &nbsp;
                                        <a
                                            @click="openDeleteModal(element.id)"
                                            class="btn btn-sm btn-danger"
                                        >
                                            حذف
                                        </a>
                                    </td>
                                </tr>
                            </template>
                        </draggable>
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
    <edit :form="editItemForm" :errors="errors" :country="country" :region="region"/>
    <create :country="country" :region="region"/>
    <confirm-modal @confirm="deleteItem"/>


</template>

<script>
import AdminLayout from "@/Layouts/Admin/Layout";
import Edit from "@/Pages/Admin/Countries/Cities/Edit";
import Create from "@/Pages/Admin/Countries/Cities/Create";
import ConfirmModal from "@/Components/Admin/ConfirmModal";
import Breadcrumb from "@/Layouts/Admin/Breadcrumb";
import Card from "@/Components/Admin/Card";
import Paginate from "@/Components/Admin/Paginate";
import draggable from "vuedraggable";
import TableSearch from "@/Components/Admin/TableSearch";
import PageHead from "@/Layouts/Admin/PageHead";


export default {
    layout: AdminLayout,
    props: ["items", 'errors', 'country', 'region', 'title'],
    components: {PageHead, TableSearch, Card, Breadcrumb, ConfirmModal, Create, Edit, Paginate, draggable},
    data() {
        return {
            editItemForm: this.$inertia.form({
                name: '',
                id: '',
            }),

            deleteItemId: null,
            breadcrumbLinks: [
                {title: 'الدول', url: route('admin.countries.index')},
                {title: this.country.name, url: route('admin.countries.index')},
                {title: 'المناطق', url: route('admin.countries.regions.index', this.country)},
                {title: this.region.name, url: route('admin.countries.regions.index', this.country)},
            ]
        };
    },
    methods: {
        openDeleteModal(itemId) {
            $('#confirmModal').modal('show');
            this.deleteItemId = itemId;
        },
        deleteItem() {
            this.$inertia.delete(route("admin.countries.regions.cities.destroy", [this.country, this.region, this.deleteItemId]), {
                onSuccess: page => {
                    generalOnSuccess('تم حذف السجل بنجاح!');
                    $('#confirmModal').modal('hide');
                }
            });
        },
        getItem(id) {
            let url = route('admin.countries.regions.cities.edit', [id, this.country, this.region])
            axios.get(url).then((res) => {
                this.editItemForm = {...this.editItemForm, ...res.data}
                $('#editModal').modal('show');
            })
        },
        endSorting() {
            let url = route('admin.countries.regions.cities.order');
            this.$inertia.post(url, {items: this.items.data}, {
                onSuccess() {
                    generalOnSuccess('تم حفظ الترتيب بنجاح.');
                }
            })
        }
    }
};
</script>

