<template>

    <!-- Reset Password v1 -->
    <div class="card mb-0">
        <div class="card-body">
            <a href="javascript:void(0);" class="brand-logo">
                <img src="/assets/admin/images/logo/logo.png">
            </a>


            <h4 class="card-title mb-1">إستعادة كلمة المرور 🔒</h4>
            <p class="card-text mb-2">كلمة المرور الجديدة يجب أن تكون مختلفة عن الكلمة القديمة</p>

            <form class="auth-reset-password-form mt-2" @submit.prevent="submit">
                <text-input v-model:value="form.email" :error="form.errors.email" label="البريد الإلكتروني" :tabindex="1" autofocus placeholder="email@example.com"/>

                <button class="btn btn-primary btn-block" tabindex="3">إرسال رابط إستعادة كلمة المرور</button>
            </form>

            <p class="text-center mt-2">
                <a :href="route('admin.login')"> <i data-feather="chevron-left"></i> العودة لتسجيل الدخول </a>
            </p>
        </div>
    </div>
    <!-- /Reset Password v1 -->
</template>

<script>
import AdminAuthLayout from "@/Layouts/AdminAuth"
import TextInput from "@/Components/Inputs/TextInput";

export default {
        layout: AdminAuthLayout,

    components: {TextInput},

    props: {
        auth: Object,
        errors: Object,
        status: String,
    },

    data() {
        return {
            form: this.$inertia.form({
                email: ''
            })
        }
    },

    methods: {
        submit() {
                this.form.post(this.route('admin.password.email'))
        }
    }
}
</script>
