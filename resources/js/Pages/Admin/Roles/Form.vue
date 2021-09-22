<template>

    <page-head :title="title"/>
    <Breadcrumb :title="title" :links="breadcrumbLinks"/>


    <div class="content-body">

        <form @submit.prevent="submit">

            <card>
                <template #header>
                    <h4>
                        <i class="fas fa-info"></i>
                        بيانات الدور
                    </h4>
                </template>
                <template #body>
                    <text-input v-model:value="form.name" :error="form.errors.name" label="اسم الدور"/>
                </template>
            </card>

            <card>
                <template #header>
                    <h4>
                        <i class="fas fa-list"></i>
                        تحديد الكل
                    </h4>
                </template>
                <template #body>
                    <checkbox-input v-model:selected="selectAll" @change="this.onSelectAll()" :value="1" label="تحديد جميع الصلاحيات"/>
                </template>
            </card>

            <div class="row">
                <div class="col-sm-4" v-for="( permissionItems, permissionCategory) in permissions">
                    <card>
                        <template #header>
                            <h4>
                                <i :class="[permissionItems[0].icon]"></i>
                                {{ permissionCategory }}
                            </h4>
                        </template>
                        <template #body>
                            <div v-for="permission in permissionItems" :key="permission.id">
                                <checkbox-input v-model:selected="form.permissions" :value="permission.id" :error="form.errors.permissions" :label="permission.label"/>
                            </div>
                        </template>
                    </card>
                </div>
            </div>
            <div class="text-center mt-2">
                <submit-button class="btn btn-primary" :is-loading="form.processing">
                    حفظ البيانات
                </submit-button>
            </div>

        </form>


    </div>

</template>
<script>
import AdminLayout from "@/Layouts/Admin/Layout";
import TextInput from "@/Components/Admin/Inputs/TextInput"
import SubmitButton from "@/Components/Admin/Inputs/SubmitButton";
import Breadcrumb from "@/Layouts/Admin/Breadcrumb";
import Card from "@/Components/Admin/Card";
import PageHead from "@/Layouts/Admin/PageHead";
import CheckboxInput from "@/Components/Admin/Inputs/CheckboxInput";

export default {
    layout: AdminLayout,
    components: {CheckboxInput, SubmitButton, TextInput, PageHead, Card, Breadcrumb},
    props: {
        title: '',
        item: {},
        role_permissions: [],
        permissions: []
    },
    data() {
        return {
            breadcrumbLinks: [
                {url: route('admin.admins.index'), title: 'المديرون'},
                {url: route('admin.roles.index'), title: 'الأدوار والصلاحيات'},
            ],

            form: this.$inertia.form({
                name: this.item?.name ?? '',
                permissions: this.role_permissions ?? [],
                _method: this.item ? 'put' : 'post',
            }),

            selectAll: false,
        }
    },
    methods: {
        submit() {
            let url_ = '';
            let this_ = this;
            if (this.item) {
                url_ = route('admin.roles.update', this.item);
            } else {
                url_ = route('admin.roles.store');
            }

            this.form.post(url_, {
                preserveScroll: true,
                onSuccess(page) {
                    if (!this_.$page.props.error) {
                        generalOnSuccess('', '', function () {
                            this_.$inertia.visit(route('admin.roles.index'));
                        });
                    } else {
                        generalOnُError(this_.error);
                    }
                },
                onError: errors => {
                    if (!this_.form.errors) {
                        generalOnُError(errors);
                    }
                },
            })
        },

        onSelectAll() {
            let permObjKeys = Object.keys(this.permissions);

            // check if old value was FALSE
            if (!this.selectAll) {
                for (let i = 0; i < permObjKeys.length; i++) {
                    for (let j = 0; j < this.permissions[permObjKeys[i]].length; j++) {
                        this.form.permissions.push(this.permissions[permObjKeys[i]][j].id);
                    }
                }

            } else {
                this.form.permissions = [];
            }
        },
    },
}
</script>
