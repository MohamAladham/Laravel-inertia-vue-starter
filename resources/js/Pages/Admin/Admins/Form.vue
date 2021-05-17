<template>

    <page-head :title="title"/>
    <Breadcrumb :title="title" :links="breadcrumbLinks"/>


    <div class="content-body">
        <!-- account setting page -->
        <section id="page-account-settings">
            <div class="row">
                <!-- left menu section -->
                <div class="col-md-3 mb-2 mb-md-0">
                    <ul class="nav nav-pills flex-column nav-left">
                        <!-- general -->
                        <li class="nav-item">
                            <a class="nav-link active" id="account-pill-general" data-toggle="pill" href="#account-vertical-general" aria-expanded="true">
                                <i data-feather="user" class="font-medium-3 mr-1"></i>
                                <span class="font-weight-bold">البيانات الأساسية</span>
                            </a>
                        </li>
                        <!-- change password -->
                        <li class="nav-item">
                            <a class="nav-link" id="account-pill-password" data-toggle="pill" href="#account-vertical-password" aria-expanded="false">
                                <i data-feather="lock" class="font-medium-3 mr-1"></i>
                                <span class="font-weight-bold">كلمة المرور</span>
                            </a>
                        </li>

                    </ul>
                </div>
                <!--/ left menu section -->

                <!-- right content section -->
                <div class="col-md-9">

                    <card>
                        <template #body>
                            <form @submit.prevent="submit">
                                <div class="tab-content">
                                    <!-- general tab -->
                                    <div role="tabpanel" class="tab-pane active" id="account-vertical-general" aria-labelledby="account-pill-general" aria-expanded="true">
                                        <div class="row">

                                            <text-input v-model:value="form.name" :error="form.errors.name" label="اسم المدير"/>
                                            <text-input v-model:value="form.email" type="email" :error="form.errors.email" label="البريد الإلكتروني"/>

                                        </div>
                                    </div>
                                    <!--/ general tab -->

                                    <!-- change password -->
                                    <div class="tab-pane fade" id="account-vertical-password" role="tabpanel" aria-labelledby="account-pill-password" aria-expanded="false">
                                        <text-input v-model:value="form.password" :error="form.errors.password" label="كلمة المرور"/>
                                        <text-input v-model:value="form.password_confirmation" :error="form.errors.password_confirmation" label="تأكيد كلمة المرور"/>
                                    </div>
                                    <!--/ change password -->


                                </div>

                                <div class="text-center mt-2">
                                    <submit-button class="btn btn-primary" :is-loading="submitIsLoading">
                                        حفظ البيانات
                                    </submit-button>
                                </div>

                            </form>
                        </template>
                    </card>

                </div>
                <!--/ right content section -->
            </div>
        </section>
        <!-- / account setting page -->

    </div>

</template>
<script>
import AdminLayout from "@/Layouts/Admin/Layout";
import TextInput from "@/Components/Admin/Inputs/TextInput"
import SubmitButton from "@/Components/Admin/Inputs/SubmitButton";
import Breadcrumb from "@/Layouts/Admin/Breadcrumb";
import Card from "@/Components/Admin/Card";
import PageHead from "@/Layouts/Admin/PageHead";

export default {
    layout: AdminLayout,
    components: {SubmitButton, TextInput, PageHead, Card, Breadcrumb},
    props: {
        title: '',
        item: {},
        errors: {}
    },
    data() {
        return {
            submitIsLoading: false,
            breadcrumbLinks: [
                {url: route('admin.admins.index'), title: 'المديرون'},
            ],

            form: this.$inertia.form({
                name: this.item?.name ?? '',
                email: this.item?.email ?? '',
                password: '',
                password_confirmation: '',
            }),

        }
    },
    methods: {
        submit() {
            if (this.item) {
                this.submitUpdate();
            } else {
                this.submitStore();
            }
        },
        submitStore() {
            let url_ = route('admin.admins.store');
            this.form.post(url_, {
                onStart: visit => {
                    this.submitIsLoading = true;
                },
                onSuccess(page) {
                    generalOnSuccess();
                },
                onError: errors => {
                    console.log(errors);
                },
                onFinish: visit => {
                    this.submitIsLoading = false;
                },
            })
        },
        submitUpdate() {
            let url_ = route('admin.admins.update', this.item);
            this.form.put(url_, {
                onStart: visit => {
                    this.submitIsLoading = true;
                },
                onSuccess(page) {
                    generalOnSuccess();
                },
                onError: errors => {
                    console.log(errors);
                },
                onFinish: visit => {
                    this.submitIsLoading = false;
                },
            })
        },

    },
}
</script>
