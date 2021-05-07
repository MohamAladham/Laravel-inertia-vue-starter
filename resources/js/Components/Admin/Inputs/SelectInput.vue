<template>
    <div>
        <label v-if="label" class="form-label" :for="id">{{ label }}:</label>
        <select :id="id" ref="input" v-bind="$attrs" class="form-select" :class="{ 'border-danger': error }"
                @input="$emit('update:value', $event.target.value)"
        >
            <slot/>
        </select>
        <p class="font-small-3 text-danger" v-if="error">
            {{ error }}
        </p>
    </div>
</template>

<script>
export default {
    inheritAttrs: false,
    emits: ['update:value'],
    props: {
        id: {
            type: String,
            default() {
                // return `select-input-${this._uid}`
            },
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
