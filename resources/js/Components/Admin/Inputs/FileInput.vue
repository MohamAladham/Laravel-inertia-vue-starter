<template>
    <div :class="'col-sm-'+col">
        <label v-if="label" class="form-label">{{ label }}
            <span v-if="required" class="text-danger">*</span>
        </label>
        <div class="row">
            <input ref="file" type="file" :accept="accept" class="hidden" @change="change" v-bind="$attrs"/>


            <div v-if="preview" class="flot-right ml-1" style="margin-left:5px ">
                <div v-if="isImg">
                    <img ref="preview" :src="preview" width="60">
                </div>
                <div v-else>
                    <a class="btn btn-info btn-sm" target="_blank" :href="preview">
                        <i class="fas fa-file"></i>
                        عرض الملف
                    </a>
                </div>
            </div>

            <div v-if="!value && !preview" class="col-12">
                <button type="button" class="btn btn-sm btn-info" @click="browse">
                    تحميل ملف
                </button>
            </div>
            <div v-else :class="[preview?'flot-right':'col-12']">
                <div v-if="value && typeof value === 'object'">
                    {{ value.name }} <span class="font-small-4 text-secondary">({{ filesize(value.size) }})</span>
                </div>
                <button type="button" class="btn btn-sm btn-secondary" @click="remove">
                    حذف
                </button>
            </div>
        </div>
        <div v-if="error" class="font-small-3 text-danger">{{ error }}</div>
    </div>
</template>

<script>
export default {
    emits: ['update:value'],
    props: {
        id: String,
        col: {
            default() {
                return 12;
            }
        },
        required: {
            type: Boolean,
            default: false
        },
        value: File,
        preview: String,
        isImg: {
            type: Boolean,
            default() {
                return false;
            }
        },
        label: String,
        accept: String,
        error: String,
    },
    watch: {
        value(value) {
            if (!value || typeof value !== 'object') {
                this.$refs.file.value = ''
                return;
            }

            let reader = new FileReader();
            let this_ = this

            if (this.isImg) {
                reader.onload = function (e) {
                    this_.$emit('update:preview', e.target.result);
                }
                reader.readAsDataURL(value);
            }
        },

    },
    methods: {
        filesize(size) {
            var i = Math.floor(Math.log(size) / Math.log(1024))
            return (size / Math.pow(1024, i)).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i]
        },
        browse() {
            this.$refs.file.click()
        },
        change(e) {
            this.$emit('update:value', e.target.files[0])
        },
        remove() {
            this.$emit('update:preview', null)
            this.$emit('update:value', null)
        },
    },
    computed: {
        /*isImg() {
            return (this.imgSrc && !!this.value && typeof this.value === 'object' && this.value.type.indexOf('image/') === 0)
                || (this.imgSrc)
        }*/
    }
}
</script>
