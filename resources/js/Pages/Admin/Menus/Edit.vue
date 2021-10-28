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

                        <text-input v-model:value="form.title" :error="form.errors.title" label="عنوان الرابط" required="true"/>
                        <text-input v-model:value="form.url" :error="form.errors.url" label="الرابط" required="true"/>
                        <select-input v-model:value="form.is_active" :error="form.errors.is_active" label="حالة التفعيل" required="true">
                            <option v-for="item in [{key:1,value:'مفعل'},{key:0,value:'غير مفعل'}]" :key="item.key" :selected="item.key==form.is_active" :value="item.key">{{ item.value }}</option>
                        </select-input>


                        <input type="hidden" :value="form.id">

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

export default {
    name: 'edit',
    props: {
        form: {},
        errors: {}
    },
    data() {
        return {}
    },
    methods: {
        submit() {
            let url_ = route('admin.menus.update', this.form.id);
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
