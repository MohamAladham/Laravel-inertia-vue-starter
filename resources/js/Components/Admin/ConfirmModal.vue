<template>
    <div id="confirmModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="alert alert-warning">
                        هل أنت متأكد؟
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء الأمر</button>
                    <button type="button" @click="confirm" class="btn btn-danger">نعم</button>
                </div>
            </div>

        </div>
    </div>
</template>
<script>
export default {
    name: 'confirm-modal',
    methods: {
        confirm() {
            this.$emit('confirm');
        }
    }
}
</script>
