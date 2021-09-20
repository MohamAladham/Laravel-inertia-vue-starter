<template>

    <div class="row mt-4">
        <div class="col-sm-6">
            <p>
                يظهر من
                <span class="font-medium">{{ items.from }}</span>
                إلى
                <span class="font-medium">{{ items.to }}</span>
                من أصل
                <span class="font-medium">{{ items.total }}</span>
                عنصر
            </p>
        </div>
        <div class="col-sm-6">
            <nav>
                <ul class="pagination justify-content-end">
                    <template v-if="isAjax">
                        <li v-if="items.prev_page_url" class="page-item prev-item">
                            <a :href="prepareLink(items.prev_page_url)" class="page-link" @click.prevent="linkClick(items.prev_page_url)"></a>
                        </li>

                        <template v-for="(link, index) in items.links">
                            <li
                                v-if="index !==0 && index!==items.links.length-1"
                                class="page-item"
                                :class="{'active':link.active}">

                                <a v-if="link.url" :href="prepareLink(link.url)" @click.prevent="linkClick(link.url)" class="page-link">{{ link.label }}</a>
                                <a v-else href="javascript:;" class="page-link">{{ link.label }}</a>
                            </li>
                        </template>

                        <li v-if="items.next_page_url" class="page-item next-item">
                            <a :href="prepareLink(items.next_page_url)" class="page-link" @click.prevent="linkClick(items.next_page_url)"></a>
                        </li>
                    </template>
                    <template v-else>
                        <li v-if="items.prev_page_url" class="page-item prev-item">
                            <inertia-link :href="prepareLink(items.prev_page_url)" class="page-link"></inertia-link>
                        </li>

                        <template v-for="(link, index) in items.links">
                            <li
                                v-if="index !==0 && index!==items.links.length-1"
                                class="page-item"
                                :class="{'active':link.active}">

                                <inertia-link v-if="link.url" :href="prepareLink(link.url)" class="page-link">{{ link.label }}</inertia-link>
                                <a v-else href="javascript:;" class="page-link">{{ link.label }}</a>
                            </li>
                        </template>

                        <li v-if="items.next_page_url" class="page-item next-item">
                            <inertia-link :href="prepareLink(items.next_page_url)" class="page-link"></inertia-link>
                        </li>

                    </template>
                </ul>
            </nav>
        </div>
    </div>

</template>


<script>
export default {
    props: ["items", "isAjax"],
    methods: {
        linkClick(paginationLink) {
            if (this.isAjax) {
                this.$emit('update:currentPaginationLink', this.prepareLink(paginationLink));
                this.$emit('fetchItems');
            }
        },
        prepareLink(link) {
            //append GET parameters
            const paramsCurrent = new URLSearchParams(window.location.search)
            let i = 0;
            paramsCurrent.forEach(function (value, key) {
                if (key === 'page') {
                    return;
                }

                if (i === 0) {
                    if (!link.indexOf('?')) {
                        link += '?' + key + '=' + value;
                    } else {
                        link += '&' + key + '=' + value;
                    }
                } else {
                    link += '&' + key + '=' + value;
                }

                //console.log(value, key);
                i++;
            })

            return link;
        }
    }
};
</script>
