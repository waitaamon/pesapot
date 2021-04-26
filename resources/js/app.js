require('./bootstrap');
import Vue from "vue";
import VueModal from '@kouts/vue-modal';
import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.min.css'

Vue.component('Modal', VueModal);
Vue.component('multiselect', Multiselect)

Vue.component('customers-list', require('./app/customers/CustomersList.vue').default)
Vue.component('cash-receipt-list', require('./app/customers/CashReceiptsList.vue').default)


const app = new Vue({
    el: '#app',
});
