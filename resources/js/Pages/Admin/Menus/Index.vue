<template>

    <page-head :title="title"/>
    <Breadcrumb :title="title" :links="breadcrumbLinks"/>

    <div class="content-body">

        <div class="text-right">
            <a @click="openCreateModal(0)" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i>
                إضافة جديد
            </a>
        </div>

        <div v-if="items">

            <div class="row">
                <div class="col-sm-6 offset-sm-3">
                    <div class="collapse-shadow collapse-icon bg-white mt-2 mb-5">
                        <draggable v-model="menuItems" item-key="id" :animation="200" @end="endSorting()">
                            <template #item="{element}">
                                <div
                                    @mouseover="$refs['controlButtons'+ element.id].classList.remove('d-none')"
                                    @mouseleave="$refs['controlButtons'+ element.id].classList.add('d-none')"
                                    :style="{opacity: element.is_active?'1':'0.6'}"
                                >

                                    <div :id="'heading' + element.id" class="card-header" data-toggle="collapse" role="button" :data-target="'#accordion'+element.id" aria-expanded="false" :aria-controls="'accordion'+element.id">
                                        <span class="lead collapse-title"> {{ element.title }} </span>

                                        <div class="dropdown_control text-right float-right mr-2 d-none" :ref="'controlButtons' + element.id">
                                            <div class="dropdown chart-dropdown">
                                                <i class="fas fa-ellipsis-v cursor-pointer" data-toggle="dropdown"></i>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" @click.stop.prevent="openCreateModal(element.id)" href="javascript:;">
                                                        إضافة رابط فرعي
                                                    </a>
                                                    <a class="dropdown-item" @click.stop.prevent="getItem(element.id)" href="javascript:;">
                                                        تعديل
                                                    </a>
                                                    <a class="dropdown-item" @click.stop.prevent="openDeleteModal(element.id)">
                                                        حذف
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div :id="'accordion'+element.id" role="tabpanel" :aria-labelledby="'heading'+element.id" class="collapse">
                                        <div class="card-body">

                                            <table class="table">
                                                <draggable v-model="element.sub_menus" tag="tbody" item-key="id" :animation="200" @end="endSorting()">
                                                    <template #item="{element}">
                                                        <tr @mouseover="$refs['subControlButtons'+ element.id].classList.remove('d-none')"
                                                            @mouseleave="$refs['subControlButtons'+ element.id].classList.add('d-none')"
                                                            :style="{opacity: element.is_active?'1':'0.6'}"
                                                        >
                                                            <td>
                                                                {{ element.title }}
                                                            </td>
                                                            <td>
                                                                <div class="dropdown_control text-right float-right mr-2 d-none" :ref="'subControlButtons' + element.id">
                                                                    <div class="dropdown chart-dropdown">
                                                                        <i class="fas fa-ellipsis-v cursor-pointer" data-toggle="dropdown"></i>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <a class="dropdown-item" @click.stop.prevent="getItem(element.id)" href="javascript:;">
                                                                                تعديل
                                                                            </a>
                                                                            <a class="dropdown-item" @click.stop.prevent="openDeleteModal(element.id)">
                                                                                حذف
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </template>
                                                </draggable>
                                            </table>

                                        </div>
                                    </div>

                                </div>
                            </template>
                        </draggable>
                    </div>
                </div>
            </div>

        </div>
        <div v-if="!items" class="alert alert-info">
            لم يتم العثور على نتائج..
        </div>

    </div>


    <!--    modal-->
    <edit :form="editItemForm" :errors="errors"/>
    <create :parent_id="parent_id"/>


</template>


<script>
import Edit from "@/Pages/Admin/Menus/Edit";
import Create from "@/Pages/Admin/Menus/Create";

import draggable from "vuedraggable";

export default {
    props: ["items", 'errors', 'title'],
    components: {Create, Edit, draggable},
    data() {
        return {
            menuItems: this.items,
            editItemForm: this.$inertia.form({
                title: '',
                url: '',
                is_active: '',
                parent_id: 0,
                id: '',
            }),

            parent_id: 0,
            deleteItemId: null,
            breadcrumbLinks: []
        };
    },
    methods: {
        openCreateModal(parent_id) {
            this.parent_id = parent_id;
            $('#createModal').modal('show');
        },

        openDeleteModal(itemId) {
            let this_ = this;
            confirm('', function () {
                this_.$inertia.delete(route("admin.menus.destroy", itemId), {
                    preserveScroll: true,
                    onSuccess: page => {
                        this_.fetchItems();
                    }
                });
            });
        },

        getItem(id, event) {
            let url = route('admin.menus.edit', id)
            axios.get(url).then((res) => {
                this.editItemForm = {...this.editItemForm, ...res.data}
                $('#editModal').modal('show');
            })
        },
        endSorting() {
            let url = route('admin.menus.order');
            this.$inertia.post(url, {items: this.items}, {
                preserveScroll: true,
                onSuccess() {
                    generalOnSuccess('تم حفظ الترتيب بنجاح.');
                }
            })
        }
    },
};
</script>

<style scoped>
.dropdown_control i {
    padding: 5px 8px;
}
</style>
