<template>
    <div :class="'col-sm-'+col">
        <div class="form-group">

            <label v-if="label" class="form-label d-block" :for="id">
                <span v-if="required" class="text-danger">*</span>
                <input type="checkbox" :checked="isChecked()" :value="value" v-bind="$attrs" :id="id" ref="input"
                       @change="check()">
                {{ label }}
            </label>

            <p class="font-small-3 text-danger" v-if="error">
                {{ error }}
            </p>
        </div>
    </div>
</template>

<script>
export default {
    inheritAttrs: false,
    emits: ['update:selected'],
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
        selected: [Array, Boolean],
        value: [String, Number, Boolean],
        label: String,
        error: String,
    },

    methods: {
        focus() {
            this.$refs.input.focus()
        },
        select() {
            this.$refs.input.select()
        },
        check() {
            if (Array.isArray(this.selected)) {
                if (this.$refs.input.checked === true) {
                    if (!this.selected.includes(this.value)) {
                        this.selected.push(this.value);
                    }
                } else {
                    this.selected.splice(this.selected.indexOf(this.value), 1);
                }
                this.$emit('update:selected', this.selected)
            } else {
                this.$emit('update:selected', this.$refs.input.checked)
            }
        },
        isChecked() {
            if (Array.isArray(this.selected)) {
                return this.selected.includes(this.value);
            }

            return this.selected === this.value;
        }
    },
}
</script>
