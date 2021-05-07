<template>
    <button :disabled="isLoading" v-bind="$attrs">
        <i :class="{'fas fa-spinner fa-spin':isLoading}"></i>
        <slot></slot>
    </button>
</template>

<script>
export default {
    name: 'submit-button',
    props: {
        isLoading: {
            type: Boolean,
            default: false
        },
    },
}

</script>
