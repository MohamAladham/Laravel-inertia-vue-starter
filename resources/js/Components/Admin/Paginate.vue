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
                    <li v-if="previous" class="page-item prev-item">
                        <inertia-link :href="prepareLink(items.prev_page_url)" class="page-link"></inertia-link>
                    </li>

                    <template v-for="(link, index) in items.links">
                        <li
                            v-if="index !==0 && index!==items.links.length-1"
                            class="page-item"
                            :class="{'active':link.active}">
                            <inertia-link :href="prepareLink(link.url)" class="page-link">{{ link.label }}</inertia-link>
                        </li>
                    </template>

                    <li v-if="next" class="page-item next-item">
                        <inertia-link :href="prepareLink(items.next_page_url)" class="page-link"></inertia-link>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

</template>


<script>
export default {
    props: ["items"],
    methods: {
        prepareLink(link) {
            //append GET parameters
            const paramsCurrent = new URLSearchParams(window.location.search)
            let i = 0;
            paramsCurrent.forEach(function (value, key) {
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
