<template>
    <page-head :title="title"/>
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-6">
                    <h2 class="content-header-title float-left mb-0">{{ title }}</h2>
                </div>
                <div class="col-6 text-right">
                    <inertia-link class="btn btn-sm btn-primary" :href="route('admin.notifications.mark_all_as_read')" method="post">
                        <i class="fa fa-bell"></i>
                        تحديد الكل كمقروء
                    </inertia-link>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">

        <ul class="list-group">

            <li v-for="notification in notifications" :data-url="notification.data.url" class="list-group-item d-flex align-items-center notif">

                <inertia-link
                    method="post"
                    :href="route('admin.notifications.mark_as_read', notification.id)"
                    :title="notification.read_at?'':'تحديد كمقروء'"
                    preserve-scroll>
                    <i class="fa fa-bell fa-2x" :class="{'text-danger':!notification.read_at}"></i>
                </inertia-link>

                <div style="margin-right: 20px">
                    <h6 class="tx-13 tx-inverse tx-semibold mg-b-0">
                        <inertia-link style="color: #000" :href="notification.data.url">
                            {{ notification.data.text }}
                        </inertia-link>
                    </h6>
                    <span dir="auto" class="d-block tx-11 text-muted">
					 {{ notification.created_at }}
                    </span>
                </div>
            </li>


        </ul>

    </div>

</template>

<script>


export default {
    props: {
        notifications: [],
        title: ''
    },
}
</script>
