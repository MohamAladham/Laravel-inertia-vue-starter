<template>
    <div class="col-sm-12">
        <div class="form-group">


            <div class="d-flex justify-content-between">
                <label :for="id">{{ label }}</label>
                <a href="{{route('admin.password.request')}}">
                    <small>نسيت كلمة المرور؟</small>
                </a>
            </div>
            <div class="input-group input-group-merge form-password-toggle">

                <input
                    type="password"
                    :class="{ 'border-danger': error }"
                    :id="id"
                    :value="value"
                    class="form-control form-control-merge"
                    @input="$emit('update:value', $event.target.value)"
                    v-bind="$attrs"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    :tabindex="tabindex"
                />
                <div class="input-group-append">
                    <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                </div>
            </div>
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
        id: {
            type: String,
            default() {
                return `text-input-` + Math.round(Math.random() * 100);
            },
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
