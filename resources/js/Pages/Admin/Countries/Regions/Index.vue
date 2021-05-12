<template>

    <page-head :title="title"/>
    <Breadcrumb :title="title" :links="breadcrumbLinks"/>

    <div class="content-body">

        <Card>
            <template #header>
                <div class="col-sm-3">
                    <table-search :routeSearch='["admin.countries.regions.index", {country: this.country}]'/>
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

                            <th class="text-center">
                                المدن
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
                                     <inertia-link :href="route('admin.countries.regions.cities.index', [country,element])">
                                         <span class="badge badge-info">{{ element.cities_count }}</span>
                                     </inertia-link>
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
    <edit :form="editItemForm" :errors="errors" :country="country"/>
    <create :country="country"/>
    <confirm-modal @confirm="deleteItem"/>


</template>

<script>
import AdminLayout from "@/Layouts/Admin/Layout";
import Edit from "@/Pages/Admin/Countries/Regions/Edit";
import Create from "@/Pages/Admin/Countries/Regions/Create";
import ConfirmModal from "@/Components/Admin/ConfirmModal";
import Breadcrumb from "@/Layouts/Admin/Breadcrumb";
import Card from "@/Components/Admin/Card";
import Paginate from "@/Components/Admin/Paginate";
import draggable from "vuedraggable";
import TableSearch from "@/Components/Admin/TableSearch";
import PageHead from "@/Layouts/Admin/PageHead";

export default {
    layout: AdminLayout,
    components: {PageHead, TableSearch, Card, Breadcrumb, ConfirmModal, Create, Edit, Paginate, draggable},
    props: ["items", 'errors', 'country', 'title'],
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
            ]
        };
    },
    methods: {
        openDeleteModal(itemId) {
            $('#confirmModal').modal('show');
            this.deleteItemId = itemId;
        },
        deleteItem() {
            this.$inertia.delete(route("admin.countries.regions.destroy", [this.country, this.deleteItemId]), {
                onSuccess: page => {
                    generalOnSuccess('تم حذف السجل بنجاح!');
                    $('#confirmModal').modal('hide');
                }
            });
        },

        getItem(id) {
            let url = route('admin.countries.regions.edit', [id, this.country])
            axios.get(url).then((res) => {
                this.editItemForm = {...this.editItemForm, ...res.data}
                $('#editModal').modal('show');
            })
        },
        endSorting() {
            let url = route('admin.countries.regions.order');
            this.$inertia.post(url, {items: this.items.data}, {
                onSuccess() {
                    generalOnSuccess('تم حفظ الترتيب بنجاح.');
                }
            })
        }
    }
};
</script>

