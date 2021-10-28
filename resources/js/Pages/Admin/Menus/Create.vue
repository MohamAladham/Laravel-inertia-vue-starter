<template>
    <div id="createModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form @submit.prevent="submit">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">إضافة جديد</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <text-input v-model:value="form.title" :error="form.errors.title" label="عنوان الرابط" required="true"/>
                        <text-input v-model:value="form.url" :error="form.errors.url" label="الرابط" required="true"/>
                        <select-input v-model:value="form.is_active" :error="form.errors.is_active" label="حالة التفعيل" required="true">
                            <option v-for="item in [{key:1,value:'مفعل'},{key:0,value:'غير مفعل'}]" :key="item.key" :value="item.key">{{ item.value }}</option>
                        </select-input>
                        <hidden-input v-model:value="form.parent_id" :error="form.errors.parent_id"/>
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
    name: 'create',
    props: {
        parent_id: 0
    },
    data() {
        return {
            form: this.$inertia.form({
                title: '',
                url: '',
                is_active: true,
                parent_id: 0,
            }),
        }
    },
    watch: {
        parent_id: function (newVal, oldVal) { // watch it
            this.form.parent_id = newVal;
        }
    },
    methods: {
        submit() {
            let url_ = route('admin.menus.store');
            let this_ = this;
            this.form.post(url_, {
                onSuccess(page) {
                    $('#createModal').modal('hide');
                    this_.form.reset();
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
