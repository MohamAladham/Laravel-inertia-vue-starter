<template>
    <div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form @submit.prevent="submit">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">تعديل العنصر</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <text-input v-model:value="form.name" :error="form.errors.name" label="اسم المدينة"/>
                        <input type="hidden" :value="form.id">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                        <submit-button class="btn btn-primary" :is-loading="submitIsLoading">
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

export default {
    name: 'edit',
    components: {SubmitButton, TextInput},
    props: {
        form: {},
        errors: {},
        country: {},
        region: {}
    },
    data() {
        return {
            submitIsLoading: false
        }
    },
    methods: {
        submit() {
            let this_ = this;
            let url_ = route('admin.countries.regions.cities.update', [this.country, this.region, this.form.id]);
            this.form.put(url_, {
                onStart: visit => {
                    this.submitIsLoading = true;
                },
                onSuccess(page) {
                    this_.$emit('saved');
                    generalOnSuccess();
                    $('#editModal').modal('hide');
                },
                onError: errors => {
                    console.log(errors);
                },
                onFinish: visit => {
                    this.submitIsLoading = false;
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
