<template>
    <div class="input-group input-group-merge">
        <input
            type="search"
            placeholder="بحث.."
            v-model="search"
            @keyup="searching"
            class="form-control"
            aria-describedby="button-addon2">
        <div class="input-group-append">
            <span class="input-group-text" id="basic-addon-search2"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></span>
        </div>
    </div>
</template>
<script>
export default {
    name: 'table-search',
    props: ['routeSearch'],
    data() {
        return {
            search: ''
        };
    }, methods: {
        searching() {
            this.$inertia.replace(
                route(this.routeSearch[0], Object.assign({search: this.search}, this.routeSearch[1]))
            );
        },
    }

}
</script>
