<template>
    <!-- Login v1 -->
    <div class="card mb-0">
        <div class="card-body">
            <a href="javascript:void(0);" class="brand-logo">
                <img src="/assets/admin/images/logo/logo.png">
            </a>

            <h4 class="card-title mb-1">إستعادة كلمة المرور 🔒</h4>
            <p class="card-text mb-2">يرجى إدخال البيانات التالية لتغيير كلمة المرور الخاصة بك</p>

            <form class="auth-login-form mt-2" @submit.prevent="submit">

                <div class="row">
                    <text-input v-model:value="form.email" :error="form.errors.email" :tabindex="1" autofocus label="البريد الإلكتروني" placeholder="email@example.com"/>
                    <text-input v-model:value="form.password" :error="form.errors.password" :tabindex="2" :type="'password'" label="كلمة المرور"/>
                    <text-input v-model:value="form.password_confirmation" :error="form.errors.password_confirmation" :tabindex="3" :type="'password'" label="تأكيد كلمة المرور"/>
                </div>

                <button class="btn btn-primary btn-block" tabindex="4">تغيير كلمة المرور</button>
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

    components: {
        TextInput,
    },

    props: {
        auth: Object,
        email: String,
        errors: Object,
        token: String,
    },

    data() {
        return {
            form: this.$inertia.form({
                token: this.token,
                email: this.email,
                password: '',
                password_confirmation: '',
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('password.update', 'admin'), {
                onFinish: () => this.form.reset('password', 'password_confirmation'),
            })
        }
    }
}
</script>
