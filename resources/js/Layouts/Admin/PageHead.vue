<template>
    <teleport to="head title">
        {{ title }} | {{this.$page.props.appName}}
    </teleport>
</template>

<script>
export default {
    name: 'pageHead',
    props: ['title']
}
</script>
