<template xmlns:inertia="http://www.w3.org/1999/html">

    <page-head :title="title"/>
    <Breadcrumb :title="title" :links="breadcrumbLinks"/>

    <div class="content-body">

        <div class="row mt-2 mb-2">
            <div class="col-sm-3">
                <table-search :routeSearch="['admin.roles.index', {}]" v-model:filter="filter" @fetchItems="fetchItems()"/>
            </div>
            <div class="col-sm-9 text-right">
                <inertia-link :href="route('admin.roles.create')" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i>
                    إضافة جديد
                </inertia-link>
            </div>
        </div>

        <div v-if="items.data?.length && !isLoadingTable" class="card_results_container">
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

</template>

<script>

export default {
    props: ['errors', 'title'],
    data() {
        return {
            breadcrumbLinks: [
                {url: route('admin.admins.index'), title: 'المديرون'},
            ],
            items: [],
            filter: prepareFilterParameters({page: 1, search: ''}),
            isLoadingTable: true,
        };
    },
    methods: {
        fetchItems() {
            console.log(this.filter);
            let this_ = this;
            this.isLoadingTable = true;
            let currentPaginationLink = route('admin.roles.fetch_items', this.filter);
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
                this_.$inertia.delete(route("admin.roles.destroy", itemId), {
                    onSuccess: page => {
                        this_.fetchItems();
                    }
                });
            });
        },
    },
    mounted() {
        this.fetchItems();
    }
};
</script>

