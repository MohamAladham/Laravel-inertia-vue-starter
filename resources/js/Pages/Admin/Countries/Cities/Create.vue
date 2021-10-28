<template>
    <div id="createModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form @submit.prevent="submit">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">إنشاء جديد</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <text-input v-model:value="form.name" :error="form.errors.name" label="اسم المدينة" required="true"/>

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

export default {
    name: 'edit',
    props: {
        country: {},
        region: {}
    },
    data() {
        return {
            form: this.$inertia.form({
                name: '',
            }),

            submitIsLoading: false
        }
    },
    methods: {
        submit() {
            let this_ = this;
            let url_ = route('admin.countries.regions.cities.store', [this.country, this.region]);
            this.form.post(url_, {
                onStart: visit => {
                    this.submitIsLoading = true;
                },
                onSuccess(page) {
                    this_.$emit('saved');
                    $('#createModal').modal('hide');
                },
                onFinish: visit => {
                    this.submitIsLoading = false;
                },
            })
        }
    },
    mounted() {
        let this_ = this
        $('#createModal').on('hidden.bs.modal', function () {
            this_.form.clearErrors();
        })
    }
}
</script>
