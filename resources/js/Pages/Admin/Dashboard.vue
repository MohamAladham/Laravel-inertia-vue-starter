<template>
    <page-head :title="title"/>
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">الرئيسية</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">


    </div>


</template>

<script>


export default {
    props: {
        auth: Object,
        errors: Object,
        title: ''
    },
}
</script>
