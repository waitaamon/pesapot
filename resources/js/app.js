require('./bootstrap');
import Vue from "vue";
import VueModal from '@kouts/vue-modal';
import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.min.css'
import Calendar from 'v-calendar/lib/components/calendar.umd'
import DatePicker from 'v-calendar/lib/components/date-picker.umd'
import Toasted from 'vue-toasted';

Vue.use(Toasted)

Vue.component('Modal', VueModal);
Vue.component('multiselect', Multiselect)
Vue.component('calendar', Calendar)
Vue.component('date-picker', DatePicker)

Vue.component('customers-list', require('./app/customers/CustomersList.vue').default)
Vue.component('cash-receipt-list', require('./app/customers/CashReceiptsList.vue').default)

Vue.component('suppliers-list', require('./app/suppliers/SuppliersList.vue').default)
Vue.component('cash-payments-list', require('./app/suppliers/CashPaymentsList.vue').default)


const app = new Vue({
    el: '#app',
});
