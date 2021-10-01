<template>
    <div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form @submit.prevent="submit">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ form.name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <text-input v-model:value="form.notification_text" :error="form.errors.notification_text" label="نص الإشعار في صفحة الإشعارات"/>
                        <text-input v-model:value="form.email_subject" :error="form.errors.email_subject" label="موضوع رسالة البريد الإلكتروني"/>
                        <textarea-input v-model:value="form.email_text" :error="form.errors.email_text" label="نص رسالة البريد الإلكتروني"/>
                        <text-input v-model:value="form.sms_text" :error="form.errors.sms_text" label="نص الرسالة القصيرة SMS "/>

                        <input type="hidden" :value="form.id">

                        <div class="alert alert-primary" v-html="form.description"></div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                        <submit-button class="btn btn-primary" :is-loading="form.processing">
                            حفظ البيانات
                        </submit-button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</template>
<script>
import TextInput from "@/Components/Admin/Inputs/TextInput"
import SubmitButton from "@/Components/Admin/Inputs/SubmitButton";
import SelectInput from "@/Components/Admin/Inputs/SelectInput";
import TextareaInput from "../../../Components/Admin/Inputs/TextareaInput";

export default {
    name: 'edit',
    components: {TextareaInput, SelectInput, SubmitButton, TextInput},
    props: {
        form: {},
        errors: {}
    },
    data() {
        return {}
    },
    methods: {
        submit() {
            let url_ = route('admin.notification_templates.update', this.form.id);
            this.form.put(url_, {
                onSuccess(page) {
                    generalOnSuccess();
                    $('#editModal').modal('hide');
                },
                onError: errors => {
                    console.log(errors);
                },
            })
        }
    },
    mounted() {
        let this_ = this
        $('#editModal').on('hidden.bs.modal', function () {
            this_.form.clearErrors();
        })
    }
}
</script>
