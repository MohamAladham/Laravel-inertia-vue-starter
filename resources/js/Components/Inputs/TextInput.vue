<template>
    <div class="col-sm-12">
        <div class="form-group">
            <label :for="id" class="form-label">{{ label }}</label>
            <input
                :type="type"
                :class="{ 'border-danger': error,'ssss':false }"
                :id="id"
                :value="value"
                class="form-control"
                @input="$emit('update:value', $event.target.value)"
                v-bind="$attrs"
                :tabindex="tabindex"
            />
            <p class="font-small-3 text-danger" v-if="error">
                {{ error }}
            </p>
        </div>
    </div>
</template>
<script>
export default {
    name: 'text-input',
    emits: ['update:value'],
    props: {
        id: {
            type: String,
            default() {
                return `text-input-` + Math.round(Math.random() * 100);
            },
        },
        type: {
            type: String,
            default() {
                return 'text';
            }
        },
        tabindex: null,
        error: String,
        label: String,
        value: String,
    },
    methods: {
        focus() {
            this.$refs.input.focus()
        }
    }
}
</script>
