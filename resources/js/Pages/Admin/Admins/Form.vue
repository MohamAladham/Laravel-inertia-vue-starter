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
                        <!-- change password -->
                        <li class="nav-item">
                            <a class="nav-link" id="account-pill-roles" data-toggle="pill" href="#account-vertical-roles" aria-expanded="false">
                                <i data-feather="lock" class="font-medium-3 mr-1"></i>
                                <span class="font-weight-bold">الأدوار والصلاحيات</span>
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
                                            <text-input v-model:value="form.name" :error="form.errors.name" label="اسم المدير" required="true"/>
                                            <text-input v-model:value="form.email" type="email" :error="form.errors.email" label="البريد الإلكتروني" required="true"/>
                                            <file-input v-model:value="form.photo" :isImg="true" v-model:preview="form.photoPreview" :error="form.errors.photo" label="الصورة الشخصية" required="true"/>
                                        </div>
                                    </div>
                                    <!--/ general tab -->

                                    <!-- change password -->
                                    <div class="tab-pane fade" id="account-vertical-password" role="tabpanel" aria-labelledby="account-pill-password" aria-expanded="false">
                                        <text-input v-model:value="form.password" :error="form.errors.password" label="كلمة المرور" required="true"/>
                                        <text-input v-model:value="form.password_confirmation" :error="form.errors.password_confirmation" label="تأكيد كلمة المرور" required="true"/>
                                    </div>
                                    <!--/ change password -->

                                    <!-- roles  -->
                                    <div class="tab-pane fade" id="account-vertical-roles" role="tabpanel" aria-labelledby="account-pill-roles" aria-expanded="false">
                                        <select2-input v-model:value="form.roles" :error="form.errors.roles" label="الأدوار" multiple required="true">
                                            <option v-for="role in roles" :key="role.id" :selected="form.roles.includes(role.id)" :value="role.id">{{ role.name }}</option>
                                        </select2-input>
                                    </div>
                                    <!--/ change password -->


                                </div>

                                <div class="text-center mt-2">
                                    <submit-button
                                        v-if="this.$page.props.auth.user.permissions.includes('admin_update')"
                                        class="btn btn-primary" :is-loading="form.processing">
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

export default {
    props: {
        title: '',
        item: {},
        roles: [],
        admin_roles: [],
    },
    data() {
        return {
            breadcrumbLinks: [
                {url: route('admin.admins.index'), title: 'المديرون'},
            ],

            form: this.$inertia.form({
                name: this.item?.name ?? '',
                email: this.item?.email ?? '',
                photo: null,
                photoPreview: this.item?.photo ?? '',
                password: '',
                password_confirmation: '',
                roles: this.admin_roles,
                _method: this.item ? 'put' : 'post',
            }),
        }
    },
    methods: {
        submit() {
            let url_ = '';
            let this_ = this;

            if (this.item) {
                url_ = route('admin.admins.update', this.item);
            } else {
                url_ = route('admin.admins.store');
            }

            this.form.post(url_, {
                preserveScroll: true,
                onSuccess(page) {
                    if (!this_.$page.props.error) {
                        generalOnSuccess('', '', function () {
                            this_.$inertia.visit(route('admin.admins.index'));
                        });
                    } else {
                        generalOnُError(this_.$page.props.error);
                    }
                },
                onError: errors => {
                    generalOnُError(errors);
                },
            })
        },
    },
}
</script>
