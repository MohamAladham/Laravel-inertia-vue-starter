<template>
    <!-- Login v1 -->
    <div class="card mb-0">
        <div class="card-body">
            <a href="javascript:void(0);" class="brand-logo">
                <img src="/assets/admin/images/logo/logo.png">
            </a>

            <h4 class="card-title mb-1">أهلاً بعودتك! 👋</h4>
            <p class="card-text mb-2">يرجى إدخال اسم المستخدم وكلمة المرور لتسجيل الدخول</p>

            <form class="auth-login-form mt-2" @submit.prevent="submit">

                <div class="row">
                    <text-input v-model:value="form.email" :error="form.errors.email" label="البريد الإلكتروني" :tabindex="1" autofocus placeholder="email@example.com"/>
                    <div class="col-sm-12">
                        <div class="form-group">


                            <div class="d-flex justify-content-between">
                                <label>{{ label }}</label>
                                <a :href="route('password.request')">
                                    <small>نسيت كلمة المرور؟</small>
                                </a>
                            </div>
                            <div class="input-group input-group-merge form-password-toggle">

                                <input
                                    type="password"
                                    :class="{ 'border-danger': form.errors.password}"
                                    v-model="form.password"
                                    class="form-control form-control-merge"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    tabindex="2"
                                />
                                <div class="input-group-append">
                                    <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                </div>
                            </div>
                            <p class="font-small-3 text-danger" v-if="form.errors.password">
                                {{ form.errors.password }}
                            </p>

                        </div>
                    </div>


                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="remember" name="remember" tabindex="3"/>
                                <label class="custom-control-label" for="remember"> تذكرني </label>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary btn-block" tabindex="4">تسجيل الدخول</button>
            </form>

        </div>
    </div>
    <!-- /Login v1 -->
</template>

<script>
import AdminAuthLayout from "@/Layouts/Admin/AdminAuth"
import TextInput from "@/Components/Admin/Inputs/TextInput";

export default {
    layout: AdminAuthLayout,

    components: {TextInput},

    props: {
        auth: Object,
        canResetPassword: Boolean,
    },

    data() {
        return {
            form: this.$inertia.form({
                email: '',
                password: '',
                remember: false
            })
        }
    },

    methods: {
        submit() {
            this.form
                .transform(data => ({
                    ...data,
                    remember: this.form.remember ? 'on' : ''
                }))
                .post(this.route('login'), {
                    onFinish: () => this.form.reset('password'),
                })
        }
    }
}
</script>
