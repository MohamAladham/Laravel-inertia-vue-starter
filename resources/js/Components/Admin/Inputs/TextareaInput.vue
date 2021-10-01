<template>
    <div class="col-sm-12">
        <div class="form-group">
            <label :for="id" class="form-label">{{ label }}</label>
            <textarea
                :name="id"
                :id="id"
                :value="value"
                :class="{ 'border-danger': error }"
                class="form-control"
                rows="4"
                @input="$emit('update:value', $event.target.value)"
                v-bind="$attrs"
            />
            <p class="font-small-3 text-danger" v-if="error">
                {{ error }}
            </p>
        </div>
    </div>
</template>
<script>
export default {
    name: 'textarea-input',
    props: {
        id: {
            type: String,
            default() {
                return `textarea-input-` + Math.round(Math.random() * 100);
            },
        },

        error: String,
        label: String,
        value: String,
    },
    emits: ['update:value'],
    methods: {
        focus() {
            this.$refs.input.focus()
        }
    }
}
</script>
