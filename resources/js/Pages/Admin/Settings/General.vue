<template>

    <page-head :title="title"/>
    <Breadcrumb :title="title" :links="breadcrumbLinks"/>


    <div class="content-body">

        <form @submit.prevent="submit">
            <card v-for="fieldGroup in fields">
                <template #header>
                    <h4>
                        <i class="fas fa-cog"></i>
                        {{ fieldGroup.title }}
                    </h4>
                </template>
                <template #body>
                    <template v-for="field in fieldGroup.fields">
                        <text-input v-if="field.type==='text'" v-model:value="form[field.name]" :error="form.errors[field.name]" :label="field.label"/>
                        <file-input v-else-if="field.type==='image'" v-model:preview="form[field.name + 'Preview']" v-model:value="form[field.name]" :error="form.errors[field.name]" :isImg="true" :label="field.label"/>
                    </template>
                </template>
            </card>

            <div class="text-center mt-2 mb-5">
                <submit-button class="btn btn-primary btn-block" :is-loading="form.processing">
                    <i class="fas fa-check"></i>
                    حفظ البيانات
                </submit-button>
            </div>

        </form>
    </div>

</template>
<script>
import AdminLayout from "@/Layouts/Admin/Layout";

export default {
    layout: AdminLayout,
    props: {
        title: '',
        settings: {},
    },
    data() {
        return {
            breadcrumbLinks: [],
            form: this.$inertia.form({
                // see mounted()
            }),
            fields: [
                {
                    title: 'الإعدادات العامة',
                    fields: [
                        {
                            name: 'site_title',
                            type: 'text',
                            label: 'عنوان الموقع',
                        },
                        {
                            name: 'admin_panel_logo',
                            type: 'image',
                            label: 'شعار لوحة التحكم',
                        },
                        {
                            name: 'favicon',
                            type: 'image',
                            label: 'الشعار في تبويبة المتصفح',
                        },
                    ],
                }
            ]
        }
    },
    methods: {
        submit() {
            let this_ = this;
            let url_ = route('admin.settings.update_general');
            this.form.post(url_, {
                preserveScroll: true,
                onSuccess(page) {
                    if (!this_.$page.props.error) {
                        generalOnSuccess('', '', function () {
                            this_.$inertia.visit(route('admin.settings.general'));
                        });
                    } else {
                        generalOnُError(this_.error);
                    }
                },
                onError: errors => {
                    generalOnُError();
                },
            })
        },
    },
    mounted() {
        let this_ = this;
        let formObj = {};
        this.fields.forEach(function (fieldGroup, index, array) {
            fieldGroup.fields.forEach(function (field, index_, array_) {
                formObj[field.name] = this_.settings[field.name] ?? '';
                if (field.type === 'image') {
                    formObj[field.name + 'Preview'] = this_.settings[field.name] ?? '';
                }
            });
        })

        this.form = this.$inertia.form(formObj);
    }
}
</script>
