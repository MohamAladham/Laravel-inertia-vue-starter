<template xmlns:inertia="http://www.w3.org/1999/html">

    <page-head :title="title"/>
    <Breadcrumb :title="title" :links="breadcrumbLinks"/>

    <div class="content-body">

        <div class="row mt-2 mb-2">
            <div class="col-sm-3">
                <table-search :routeSearch="['admin.notification_templates.index', {}]" v-model:filter="filter" @fetchItems="fetchItems()"/>
            </div>
        </div>

        <div v-if="items.data?.length && !isLoadingTable" class="card_results_container">
            <div class="row card_results_head">
                <div class="col">
                    اسم القالب
                </div>
                <div class="col col-2 text-center">
                    الخيارات
                </div>
            </div>

            <Card class="card card_results" v-for="item in items.data">
                <template #body>
                    <div class="row">
                        <div class="col">
                            <a @click.stop.prevent="getItem(item.id)">
                                {{ item.name }}
                            </a>
                        </div>
                        <div class="col col-2 text-center">
                            <a
                                @click.stop.prevent="getItem(item.id)"
                                class="btn btn-sm btn-info"
                            >تعديل
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

    <edit :form="editItemForm" :errors="errors"/>

</template>

<script>
import AdminLayout from "@/Layouts/Admin/Layout";
import Edit from "@/Pages/Admin/NotificationTemplate/Edit";
import Breadcrumb from "@/Layouts/Admin/Breadcrumb";
import Card from "@/Components/Admin/Card";
import Paginate from "@/Components/Admin/Paginate";
import TableSearch from "@/Components/Admin/TableSearch";
import PageHead from "@/Layouts/Admin/PageHead";
import TablePlaceholder from "@/Components/Admin/TablePlaceholder";

export default {
    layout: AdminLayout,
    props: ['title'],
    components: {PageHead, TableSearch, Card, Breadcrumb, Paginate, Edit, TablePlaceholder},
    data() {
        return {
            breadcrumbLinks: [],
            editItemForm: this.$inertia.form({
                email_subject: '',
                email_text: '',
                sms_text: '',
                notification_text: '',
                id: '',
            }),
            items: [],
            filter: prepareFilterParameters({page: 1, search: ''}),
            isLoadingTable: true,
        };
    },
    methods: {
        fetchItems() {
            let this_ = this;
            this.isLoadingTable = true;
            let currentPaginationLink = route('admin.notification_templates.fetch_items', this.filter);
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
        getItem(id, event) {
            let url = route('admin.notification_templates.edit', id)
            axios.get(url).then((res) => {
                this.editItemForm = {...this.editItemForm, ...res.data}
                $('#editModal').modal('show');
            })
        },

    },
    mounted() {
        this.fetchItems();
    }
};
</script>

