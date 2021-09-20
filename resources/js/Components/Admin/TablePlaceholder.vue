<template>
    <div class="card_results_container">
        <div class="row card_results_head">
            <div class="col">
                <div class="animated-background"></div>
            </div>
            <div class="col">
                <div class="animated-background"></div>
            </div>
            <div class="col">
                <div class="animated-background"></div>
            </div>
            <div class="col">
                <div class="animated-background"></div>
            </div>
        </div>

        <Card class="card card_results" style="padding-top: 20px; padding-bottom: 20px;">
            <template #body>
                <div class="row">
                    <div class="col">
                        <div class="animated-background"></div>
                    </div>
                </div>
            </template>
        </Card>

    </div>

</template>

<style scoped>
@keyframes placeHolderShimmer {
    0% {
        background-position: -468px 0;
    }
    100% {
        background-position: 468px 0;
    }
}

.animated-background {
    animation-duration: 1.5s;
    animation-fill-mode: forwards;
    animation-iteration-count: infinite;
    animation-timing-function: linear;
    animation-name: placeHolderShimmer;
    background: #f6f7f8;
    background: linear-gradient(to right, #eeeeee 8%, #dddddd 18%, #eeeeee 33%);
    background-size: 800px 104px;
    height: 15px;
    position: relative;
}
</style>

<script>
import Card from "@/Components/Admin/Card";

export default {
    props: [],
    components: {Card},
    data() {
        return {};
    }, methods: {}
}
</script>
