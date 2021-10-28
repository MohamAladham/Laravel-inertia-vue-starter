<template>
    <input
        type="hidden"
        :id="id"
        :value="value"
        @input="$emit('update:value', $event.target.value)"
        v-bind="$attrs"
        :tabindex="tabindex"
    />
    <p class="font-small-3 text-danger" v-if="error">
        {{ error }}
    </p>
</template>
<script>
export default {
    name: 'hidden-input',
    emits: ['update:value'],
    props: {
        id: String,
        tabindex: null,
        error: String,
        value: String,
        required: {
            type: Boolean,
            default: false
        },
    },
    methods: {
        focus() {
            this.$refs.input.focus()
        }
    }
}
</script>
