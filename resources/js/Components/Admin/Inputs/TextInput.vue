<template>
    <div :class="'col-sm-'+col">
        <div class="form-group">
            <label :for="id" class="form-label">{{ label }}
                <span v-if="required" class="text-danger">*</span>
            </label>
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
        id: String,
        col: {
            default() {
                return 12;
            }
        },
        type: {
            type: String,
            default() {
                return 'text';
            }
        },
        required: {
            type: Boolean,
            default: false
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
