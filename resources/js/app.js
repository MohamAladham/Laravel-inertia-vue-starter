require('./bootstrap');

// Import modules...
import {createApp, h} from 'vue';
import {App as InertiaApp, plugin as InertiaPlugin} from '@inertiajs/inertia-vue3';
import {InertiaProgress} from '@inertiajs/progress';
import AdminLayout from "@/Layouts/Admin/Layout";

const el = document.getElementById('app');

var Vue = createApp({
        render: () =>
            h(InertiaApp, {
                initialPage: JSON.parse(el.dataset.page),
                resolveComponent: (name) => {
                    let page = require(`./Pages/${name}`).default;
                    page.layout ??= AdminLayout;
                    return page;
                },
            }),
    })
        .mixin({methods: {route}})
        .use(InertiaPlugin)
;

InertiaProgress.init({color: '#4B5563'});


// Import inputs
import TextInput from './Components/Admin/Inputs/TextInput';
import CheckboxInput from './Components/Admin/Inputs/CheckboxInput';
import TextareaInput from './Components/Admin/Inputs/TextareaInput';
import HiddenInput from './Components/Admin/Inputs/HiddenInput';
import FileInput from './Components/Admin/Inputs/FileInput';
import Select2Input from './Components/Admin/Inputs/Select2Input';
import SelectInput from './Components/Admin/Inputs/SelectInput';
import SubmitButton from './Components/Admin/Inputs/SubmitButton';
import Breadcrumb from './Layouts/Admin/Breadcrumb';
import Card from './Components/Admin/Card';
import PageHead from './Layouts/Admin/PageHead';
import TablePlaceholder from './Components/Admin/TablePlaceholder';
import TableSearch from './Components/Admin/TableSearch';
import Paginate from './Components/Admin/Paginate';

Vue.component('TextInput', TextInput);
Vue.component('CheckboxInput', CheckboxInput);
Vue.component('TextareaInput', TextareaInput);
Vue.component('HiddenInput', HiddenInput);
Vue.component('FileInput', FileInput);
Vue.component('Select2Input', Select2Input);
Vue.component('SelectInput', SelectInput);
Vue.component('SubmitButton', SubmitButton);
Vue.component('Breadcrumb', Breadcrumb);
Vue.component('Card', Card);
Vue.component('PageHead', PageHead);
Vue.component('TablePlaceholder', TablePlaceholder);
Vue.component('TableSearch', TableSearch);
Vue.component('Paginate', Paginate);

Vue.mount(el);
