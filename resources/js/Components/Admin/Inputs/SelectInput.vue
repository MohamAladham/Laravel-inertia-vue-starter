<template>
    <div :class="'col-sm-'+col">
        <div class="form-group">
            <label v-if="label" class="form-label" :for="id">{{ label }}
                <span v-if="required" class="text-danger">*</span>
            </label>
            <select :id="id" ref="input" v-bind="$attrs" class="form-control" :class="{ 'border-danger': error }"
                    @input="$emit('update:value', $event.target.value)"
            >
                <slot/>
            </select>
            <p class="font-small-3 text-danger" v-if="error">
                {{ error }}
            </p>
        </div>
    </div>
</template>

<script>
export default {
    inheritAttrs: false,
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
    },
}
</script>
