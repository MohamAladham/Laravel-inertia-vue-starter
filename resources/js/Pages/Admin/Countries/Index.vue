<template>

    <page-head :title="title"/>
    <Breadcrumb :title="title" :links="breadcrumbLinks"/>

    <div class="content-body">

        <div class="row mt-2 mb-2">
            <div class="col-sm-3">
                <table-search :routeSearch="['admin.countries.index', {}]" v-model:filter="filter" @fetchItems="fetchItems()"/>
            </div>
            <div class="col-sm-9 text-right">
                <a data-toggle="modal" data-target="#createModal" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i>
                    إضافة جديد
                </a>
            </div>
        </div>

        <div v-if="items.data?.length && !isLoadingTable" class="card_results_container">
            <div class="row card_results_head">
                <div class="col">
                    اسم الدولة
                </div>
                <div class="col">
                    المناطق
                </div>
                <div class="col col-2 text-center">
                    الخيارات
                </div>
            </div>

            <draggable v-model="items.data" item-key="id" :animation="200" @end="endSorting()">
                <template #item="{ element }">

                    <Card class="card card_results">
                        <template #body>
                            <div class="row">
                                <div class="col">
                                    {{ element.name }}
                                </div>
                                <div class="col">
                                    <inertia-link :href="route('admin.countries.regions.index', element.id)">
                                        <span class="badge badge-info">{{ element.regions_count }}</span>
                                    </inertia-link>
                                </div>
                                <div class="col col-2 text-center">
                                    <a
                                        @click="getItem(element.id)"
                                        class="btn btn-sm btn-info"
                                        href="javascript:;">
                                        تعديل
                                    </a>

                                    <a
                                        @click="openDeleteModal(element.id)"
                                        class="btn btn-sm btn-danger">
                                        حذف
                                    </a>
                                </div>
                            </div>
                        </template>

                    </Card>
                </template>
            </draggable>

        </div>
        <table-placeholder v-else-if="isLoadingTable"></table-placeholder>


        <Paginate v-if="items.data?.length && items.total > items.per_page"
                  :items="items"
                  @fetchItems="fetchItems()"
                  v-model:filter="filter"
        />
        <div v-if="!items.data?.length && !isLoadingTable" class="alert alert-info">
            لم يتم العثور على نتائج..
        </div>

    </div>


    <!--    modal-->
    <edit :form="editItemForm" :errors="errors" @saved="this.fetchItems()"/>
    <create @saved="this.fetchItems()"/>


</template>

<script>
import Edit from "@/Pages/Admin/Countries/Edit";
import Create from "@/Pages/Admin/Countries/Create";
import draggable from "vuedraggable";

export default {
    props: ['errors', 'title'],
    components: {
        Create,
        Edit,
        draggable,
    },
    data() {
        return {
            editItemForm: this.$inertia.form({
                name: '',
                id: '',
            }),

            breadcrumbLinks: [],
            items: [],
            filter: prepareFilterParameters({page: 1, search: ''}),
            isLoadingTable: true,
        };
    },
    methods: {
        fetchItems() {
            let this_ = this;
            this.isLoadingTable = true;
            let currentPaginationLink = route('admin.countries.fetch_items', this.filter);
            axios.get(currentPaginationLink).then((res) => {
                this_.isLoadingTable = false;
                if (res.status === 200) {
                    this_.items = res.data.items
                } else {
                    generalOnُError();
                }
            }).catch(function (error) {
                generalOnُError(serverErrorMsg);
            })
        },
        openDeleteModal(itemId) {
            let this_ = this;
            confirm('', function () {
                this_.$inertia.delete(route("admin.contries.destroy", itemId), {
                    onSuccess: page => {
                        this_.fetchItems();
                    }
                });
            });
        },
        getItem(id) {
            let url = route('admin.countries.edit', id)
            axios.get(url).then((res) => {
                this.editItemForm = {...this.editItemForm, ...res.data}
                $('#editModal').modal('show');
            })
        },
        endSorting() {
            let url = route('admin.countries.order');
            this.$inertia.post(url, {items: this.items.data}, {
                preserveScroll: true,
                onSuccess() {
                    generalOnSuccess('تم حفظ الترتيب بنجاح.');
                }
            })
        }
    },
    mounted() {
        this.fetchItems();
    }
};
</script>

