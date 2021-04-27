<template>
    <div>
        <div class="grid grid-cols-4 gap-2">
            <div class="col-span-2">
                <a
                    href="#"
                    @click.prevent="showFilters = !showFilters"
                    class="mb-2 block text-sm tracking-wide font-bold text-red-600 hover:text-red-800"
                >
                    {{ showFilters ? 'Hide' : 'Show' }} Filters
                </a>
                <div v-if="showFilters">
                    <data-table-filters model="customer" :options="customers" @apply-filters="applyFilters"/>
                </div>

            </div>
            <div class="col-span-2 flex justify-end space-x-3">
                <div>
                    <app-drop-down label="Bulk Actions">
                        <button @click.prevent="markTransfer"
                                class="block flex items-center space-x-2 class = 'block flex w-full px-4 py-2 space-x-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cool-gray-400"
                                 viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M8 5a1 1 0 100 2h5.586l-1.293 1.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L13.586 5H8zM12 15a1 1 0 100-2H6.414l1.293-1.293a1 1 0 10-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L6.414 15H12z"/>
                            </svg>
                            <span>Transfer</span>
                        </button>
                        <button @click.prevent="exportSelected"
                                class="block flex items-center space-x-2 class = 'block flex w-full px-4 py-2 space-x-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cool-gray-400"
                                 viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                      clip-rule="evenodd"/>
                            </svg>
                            <span>Export</span>
                        </button>
                        <button @click.prevent="deleteSelected"
                                class="block flex items-center space-x-2 class = 'block flex w-full px-4 py-2 space-x-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cool-gray-400"
                                 viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                      clip-rule="evenodd"/>
                            </svg>
                            <span>Delete</span>
                        </button>
                    </app-drop-down>
                </div>

                <cash-receipt-modal :customers="customers" @fetch-receipts="fetchReceipts"/>
            </div>
        </div>
        <div class="mt-3">
            <div class="overflow-hidden border-b border-gray-200 sm:rounded">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" v-model="selectAll">
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Customer
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Amount
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col"
                            class=" px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <!--                        <th scope="col" class="relative px-6 py-3">-->
                        <!--                            <span class="sr-only">Edit</span>-->
                        <!--                        </th>-->
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="receipt in receipts" :key="receipt.id">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <input type="checkbox" v-model="selected" :value="receipt.id">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900 capitalize">
                            {{ receipt.customer_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                            {{ receipt.amount.toLocaleString() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                            {{ receipt.status }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                            {{ receipt.date }}
                        </td>
                        <!--                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">-->
                        <!--                            <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>-->
                        <!--                        </td>-->
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
import TablePagination from "../../components/TablePagination";
import CashReceiptModal from "./partials/CashReceiptModal";
import AppDropDown from "../../components/AppDropdown";
import DropdownItem from "../../components/partials/DropDownItem";
import DataTableFilters from "../../components/DataTableFilters";

export default {
    components: {DataTableFilters, DropdownItem, AppDropDown, CashReceiptModal, TablePagination},
    data() {
        return {
            receipts: [],
            paginationData: {},
            perPage: 50,
            selected: [],
            selectAll: false,
            showFilters: false,
            customers: [],
            filters: {}
        }
    },
    watch: {
        selectAll: {
            handler: function () {
                if (this.selectAll) {
                    this.selected = this.receipts.map(receipt => receipt.id)
                    return
                }
                this.selected = []
            }
        }
    },
    methods: {
        async prerequisites() {
            try {
                let response = await axios.get('api/cash-receipt-prerequisites')
                this.customers = response.data.customers
            } catch (e) {
                this.$toast.error('Something went wrong try again later');
            }
        },
        applyPagination(data) {
            this.receipts = data.data
            this.paginationData = data.pagination
        },
        applyPerPage(data) {
            this.perPage = data
            this.fetchReceipts()
        },

        applyFilters(data) {
            this.filters = data
            this.fetchReceipts()
        },

        exportSelected() {
            if (!this.selected.length) {
                this.$toast.error('Select at least one record');
                return
            }

            axios({
                method: 'post',
                url: 'api/cash-receipt-export-excel',
                responseType: 'blob',
                data: {receipts: this.selected}
            }).then(response => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', `pesapot-cash-receipts.xlsx`);
                document.body.appendChild(link);
                link.click();
            }).catch(e => {
                this.$toast.error('Something went wrong try again later');
            })
        },
        async deleteSelected() {
            if (!this.selected.length) {
                this.$toast.error('Select at least one record');
                return
            }

            try {
                await axios.post(`api/cash-receipts`, {
                    receipts: this.selected
                })

                await this.fetchReceipts()
            } catch (e) {
                this.$toast.error('Something went wrong try again later');
            }
        },
        async markTransfer() {
            if (!this.selected.length) {
                this.$toast.error('Select at least one record');
                return
            }
            try {
                await axios.post('api/cash-receipt-mark-transferred', {
                    receipts: this.selected
                })

                await this.fetchReceipts()
            } catch (e) {
                this.$toast.error('Something went wrong try again later');
            }
        },

        async fetchReceipts() {
            try {
                let response = await axios.get(
                    `api/cash-receipts?per_page=${this.perPage}&customer=${this.filters.entity ??= ''}&status=${this.filters.status ??= 'active'}&start=${this.filters.start ??= ''}&end=${this.filters.end ??= ''}`
                )
                this.receipts = response.data.data
                this.paginationData = response.data.pagination
            } catch (e) {
                this.$toast.error('Something went wrong try again later');
            }
        }
    },
    created() {
        this.fetchReceipts()
        this.prerequisites()
    }
}
</script>