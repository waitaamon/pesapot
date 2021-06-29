<template>
    <div>
        <div class="flex justify-end">
            <supplier-modal @fetch-suppliers="fetchSuppliers" @reset-supplier="supplier = null" ref="supplierModal"/>
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
                    <tr v-for="supplier in suppliers" :key="supplier.id">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <input type="checkbox">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 capitalize">
                            {{ supplier.name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ supplier.status }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ supplier.created_at }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                            <!--                            <a :href="`/suppliers/${supplier.id}`" class="text-indigo-600 hover:text-indigo-900">View</a>-->
                            <a href="#" class="text-orange-300 hover:text-orange-500"
                               @click.prevent="editSupplier(supplier)">Edit</a>
                            <a href="#" class="text-red-300 hover:text-red-500"
                               @click.prevent="deleteSupplier(supplier)">Delete</a>
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
import SupplierModal from "./partials/SupplierModal";
import TablePagination from "../../components/TablePagination";

export default {
    components: {TablePagination, SupplierModal},
    data() {
        return {
            supplier: null,
            suppliers: [],
            paginationData: {},
            perPage: 50,
        }
    },
    methods: {
        applyPagination(data) {
            this.suppliers = data.data
            this.paginationData = data.pagination
        },
        applyPerPage(data) {
            this.perPage = data
            this.fetchSuppliers()
        },
        editSupplier(supplier) {
            this.supplier = supplier
            this.$refs.supplierModal.showModal = true
        },

        async fetchSuppliers() {
            try {
                let response = await axios.get(`api/suppliers?per_page=${this.perPage}`)
                this.suppliers = response.data.data
                this.paginationData = response.data.pagination
            } catch (e) {
                console.error('could not fetch suppliers')
            }
        },

        async deleteSupplier(supplier) {
            try {
                if (!confirm('Do you want to delete this supplier?')) return

                await axios.delete(`api/suppliers/${supplier.id}`)

                this.$toasted.success('Supplier deleted successfully')

                await this.fetchSuppliers()

            } catch (e) {
                if (e.response.data.message) {
                    this.$toasted.error(e.response.data.message)
                    return
                }
                this.$toasted.error('Something Went wrong try again later')
            }
        }
    },
    created() {
        this.fetchSuppliers()
    }
}
</script>