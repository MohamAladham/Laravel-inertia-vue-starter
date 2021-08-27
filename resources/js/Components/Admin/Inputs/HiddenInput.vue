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
        id: {
            type: String,
            default() {
                return `text-input-` + Math.round(Math.random() * 100);
            },
        },
        tabindex: null,
        error: String,
        value: String,
    },
    methods: {
        focus() {
            this.$refs.input.focus()
        }
    }
}
</script>
