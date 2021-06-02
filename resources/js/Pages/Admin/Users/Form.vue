<template>

    <page-head :title="title"/>
    <Breadcrumb :title="title" :links="breadcrumbLinks"/>


    <div class="content-body">
        <!-- account setting page -->
        <section id="page-account-settings">
            <div class="row">
                <!-- left menu section -->
                <div class="col-md-3 mb-2 mb-md-0">
                    <ul class="nav nav-pills flex-column nav-left">
                        <!-- general -->
                        <li class="nav-item">
                            <a class="nav-link active" id="account-pill-general" data-toggle="pill" href="#account-vertical-general" aria-expanded="true">
                                <i data-feather="user" class="font-medium-3 mr-1"></i>
                                <span class="font-weight-bold">البيانات الأساسية</span>
                            </a>
                        </li>
                        <!-- change password -->
                        <li class="nav-item">
                            <a class="nav-link" id="account-pill-password" data-toggle="pill" href="#account-vertical-password" aria-expanded="false">
                                <i data-feather="lock" class="font-medium-3 mr-1"></i>
                                <span class="font-weight-bold">كلمة المرور</span>
                            </a>
                        </li>

                    </ul>
                </div>
                <!--/ left menu section -->

                <!-- right content section -->
                <div class="col-md-9">

                    <card>
                        <template #body>
                            <form @submit.prevent="submit">
                                <div class="tab-content">
                                    <!-- general tab -->
                                    <div role="tabpanel" class="tab-pane active" id="account-vertical-general" aria-labelledby="account-pill-general" aria-expanded="true">
                                        <div class="row">
                                            <text-input v-model:value="form.name" :error="form.errors.name" label="اسم المستخدم"/>
                                            <text-input v-model:value="form.email" type="email" :error="form.errors.email" label="البريد الإلكتروني"/>

                                            <select-input v-model:value="form.country_id" @change="onCountryChange()" :error="errors.country_id" label="الدولة">
                                                <option :value="null">فضلاً إختر..</option>
                                                <option v-for="country in countries" :key="country.id" :selected="country.id===form.country_id" :value="country.id">{{ country.name }}</option>
                                            </select-input>


                                            <select-input v-model:value="form.region_id" id="region_id" @change="onRegionChange()" :error="errors.region_id" label="المنطقة">
                                                <option :value="null">فضلاً إختر..</option>
                                                <option v-for="region in regions" :key="region.id" :selected="region.id===form.region_id" :value="region.id">{{ region.name }}</option>
                                            </select-input>

                                            <select-input v-model:value="form.city_id" id="city_id" :error="errors.city_id" label="المدينة">
                                                <option :value="null">فضلاً إختر..</option>
                                                <option v-for="city in cities" :key="city.id" :selected="city.id===form.city_id" :value="city.id">{{ city.name }}</option>
                                            </select-input>

                                            <file-input v-model:value="form.photo" :isImg="true" v-model:preview="form.photoPreview" :error="errors.photo" label="الصورة الشخصية"/>

                                        </div>
                                    </div>
                                    <!--/ general tab -->

                                    <!-- change password -->
                                    <div class="tab-pane fade" id="account-vertical-password" role="tabpanel" aria-labelledby="account-pill-password" aria-expanded="false">
                                        <text-input v-model:value="form.password" :error="form.errors.password" label="كلمة المرور"/>
                                        <text-input v-model:value="form.password_confirmation" :error="form.errors.password_confirmation" label="تأكيد كلمة المرور"/>
                                    </div>
                                    <!--/ change password -->


                                </div>

                                <div class="text-center mt-2">
                                    <submit-button class="btn btn-primary" :is-loading="submitIsLoading">
                                        حفظ البيانات
                                    </submit-button>
                                </div>

                            </form>
                        </template>
                    </card>

                </div>
                <!--/ right content section -->
            </div>
        </section>
        <!-- / account setting page -->

    </div>

</template>
<script>
import AdminLayout from "@/Layouts/Admin/Layout";
import SelectInput from "@/Components/Admin/Inputs/SelectInput"
import TextInput from "@/Components/Admin/Inputs/TextInput"
import FileInput from "@/Components/Admin/Inputs/FileInput"
import SubmitButton from "@/Components/Admin/Inputs/SubmitButton";
import Breadcrumb from "@/Layouts/Admin/Breadcrumb";
import Card from "@/Components/Admin/Card";
import PageHead from "@/Layouts/Admin/PageHead";

export default {
    layout: AdminLayout,
    components: {SubmitButton, SelectInput, TextInput, FileInput, PageHead, Card, Breadcrumb},
    props: {
        title: '',
        item: {},
        countries: [],
        errors: {}
    },
    data() {
        return {
            submitIsLoading: false,
            breadcrumbLinks: [
                {url: route('admin.users.index'), title: 'المستخدمون'},
            ],

            form: this.$inertia.form({
                name: this.item?.name ?? '',
                email: this.item?.email ?? '',
                photo: null,
                photoPreview: this.item?.photo ?? '',
                country_id: this.item?.country_id ?? '',
                region_id: this.item?.region_id ?? '',
                city_id: this.item?.city_id ?? '',

                password: '',
                password_confirmation: '',
                _method: this.item ? 'put' : 'post',
            }),

            regions: this.item?.country?.regions ?? [],
            cities: this.item?.region?.cities ?? [],
        }
    },
    methods: {
        submit() {
            let url_ = '';

            if (this.item) {
                url_ = route('admin.users.update', this.item);
            } else {
                url_ = route('admin.users.store');
            }

            this.form.post(url_, {
                onStart: visit => {
                    this.submitIsLoading = true;
                },
                onSuccess(page) {
                    generalOnSuccess();
                },
                onError: errors => {
                    console.log(errors);
                },
                onFinish: visit => {
                    this.submitIsLoading = false;
                },
            })
        },


        onCountryChange() {
            let countryId = this.form.country_id;
            let url = route('admin.countries.regions.get_regions_json', countryId)
            axios.get(url).then((res) => {
                this.regions = res.data
            })
        },

        onRegionChange() {
            let regionId = this.form.region_id;
            let url = route('admin.countries.regions_cities.get_cities_json', regionId)
            axios.get(url).then((res) => {
                this.cities = res.data
            })
        }

    },
}
</script>
