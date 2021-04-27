<template>
    <div>
        <div class="flex justify-end">
            <customer-modal @fetch-customers="fetchCustomers" ref="customerModal"/>
        </div>
        <div class="mt-3">
            <div class="overflow-hidden border-b border-gray-200 sm:rounded">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox">
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Name
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Added On
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="customer in customers" :key="customer.id">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <input type="checkbox">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 capitalize">
                            {{ customer.name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ customer.status }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ customer.created_at }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
<!--                            <a :href="`/customers/${customer.id}`" class="text-indigo-600 hover:text-indigo-900">View</a>-->
                            <a href="#" class="text-red-300 hover:text-red-500" @click.prevent="editCustomer(customer)">Edit</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table-pagination :pagination-data="paginationData" @apply-pagination="applyPagination"
                                  @apply-per-page="applyPerPage"/>
            </div>
        </div>
    </div>
</template>

<script>
import CustomerModal from "./partials/CustomerModal";
import TablePagination from "../../components/TablePagination";

export default {
    components: {TablePagination, CustomerModal},
    data() {
        return {
            customers: [],
            paginationData: {},
            perPage: 50,
        }
    },
    methods: {
        applyPagination(data) {
            this.customers = data.data
            this.paginationData = data.pagination
        },
        applyPerPage(data) {
            this.perPage = data
            this.fetchCustomers()
        },
        editCustomer(customer) {
            this.$refs.customerModal.customer = customer
            this.$refs.customerModal.showModal = true
        },
        async fetchCustomers() {
            try {
                let response = await axios.get(`api/customers?per_page=${this.perPage}`)
                this.customers = response.data.data
                this.paginationData = response.data.pagination
            } catch (e) {
                console.error('could not fetch customers')
            }
        }
    },
    created() {
        this.fetchCustomers()
    }
}
</script>