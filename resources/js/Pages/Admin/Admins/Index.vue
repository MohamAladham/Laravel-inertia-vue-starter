<template xmlns:inertia="http://www.w3.org/1999/html">

    <page-head :title="title"/>
    <Breadcrumb :title="title" :links="breadcrumbLinks"/>

    <div class="content-body">

        <div class="row mt-2 mb-2">
            <div class="col-sm-3">
                <table-search :routeSearch="['admin.admins.fetch_items', {}]" v-model:filter="filter" @fetchItems="fetchItems()"/>
            </div>
            <div class="col-sm-9 text-right">
                <inertia-link
                    v-if="this.$page.props.auth.user.permissions.includes('admin_update')"
                    :href="route('admin.admins.create')" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i>
                    إضافة جديد
                </inertia-link>
                <a :href="route('admin.admins.export')" class="btn btn-sm btn-info">
                    <i class="fas fa-file-excel"></i>
                    تصدير البيانات
                </a>
            </div>
        </div>

        <div v-if="items.data?.length && !isLoadingTable" class="card_results_container">
            <div class="row card_results_head">
                <div class="col">
                    اسم المدير
                </div>
                <div class="col">
                    الأدوار
                </div>
                <div class="col">
                    البريد الإلكتروني
                </div>
                <div class="col col-2 text-center">
                    الخيارات
                </div>
            </div>

            <Card class="card card_results" v-for="item in items.data">
                <template #body>
                    <div class="row">
                        <div class="col">
                            <inertia-link :href="route('admin.admins.edit', item.id)">
                                <img :src="item.photo" class="rounded-circle" style="width:40px; height: 40px; margin-left: 3px"/>
                                {{ item.name }}
                            </inertia-link>
                        </div>
                        <div class="col">
                            <inertia-link
                                v-for="role in item.roles"
                                :href="route('admin.roles.edit', role.id)"
                                class="badge badge-secondary" style="margin-left: 4px;">
                                {{ role.name }}
                            </inertia-link>
                        </div>
                        <div class="col">
                            {{ item.email }}
                        </div>
                        <div class="col col-2 text-center">
                            <inertia-link
                                :href="route('admin.admins.edit', item.id)"
                                class="btn btn-sm btn-info">
                                تعديل
                            </inertia-link>
                            <a
                                v-if="this.$page.props.auth.user.permissions.includes('admin_delete')"
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
    props: ['title'],
    data() {
        return {
            breadcrumbLinks: [],
            items: [],
            isLoadingTable: true,
            filter: prepareFilterParameters({page: 1, search: ''}),
        };
    },
    methods: {
        fetchItems() {
            let this_ = this;
            this.isLoadingTable = true;
            let currentPaginationLink = route('admin.admins.fetch_items', this.filter);
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
                this_.$inertia.delete(route("admin.admins.destroy", itemId), {
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

