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
                    <password-input v-model:value="form.password" :error="form.errors.password" label="كلمة المرور" :tabindex="2"/>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="remember-me" tabindex="3"/>
                                <label class="custom-control-label" for="remember-me"> Remember Me </label>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary btn-block" tabindex="4">Sign in</button>
            </form>

            <p class="text-center mt-2">
                <span>New on our platform?</span>
                <a href="page-auth-register-v1.html">
                    <span>Create an account</span>
                </a>
            </p>

            <div class="divider my-2">
                <div class="divider-text">or</div>
            </div>

            <div class="auth-footer-btn d-flex justify-content-center">
                <a href="javascript:void(0)" class="btn btn-facebook">
                    <i data-feather="facebook"></i>
                </a>
                <a href="javascript:void(0)" class="btn btn-twitter white">
                    <i data-feather="twitter"></i>
                </a>
                <a href="javascript:void(0)" class="btn btn-google">
                    <i data-feather="mail"></i>
                </a>
                <a href="javascript:void(0)" class="btn btn-github">
                    <i data-feather="github"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- /Login v1 -->
</template>

<script>
import AdminAuthLayout from "@/Layouts/AdminAuth"
import TextInput from "@/Components/Inputs/TextInput";
import PasswordInput from "@/Components/Inputs/PasswordInput";

export default {
    layout: AdminAuthLayout,

    components: {TextInput, PasswordInput},

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
                .post(this.route('admin.login'), {
                    onFinish: () => this.form.reset('password'),
                })
        }
    }
}
</script>
