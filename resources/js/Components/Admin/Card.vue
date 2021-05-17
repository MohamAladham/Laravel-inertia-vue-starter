<template>
    <div class="card">
        <div v-if="hasHeaderSlot" class="card-header">
            <slot name="header"/>
        </div>
        <div class="card-body">
            <slot name="body"/>
        </div>
    </div>
</template>
<script>
export default {
    name: 'Card',
    computed: {
        hasHeaderSlot() {
            return !!this.$slots.header
        }
    }
}
</script>
