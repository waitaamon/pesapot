<template>
    <div>

        <button
            type="button"
            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
            @click="showModal=true"
        >
            New Cash Receipt
        </button>

        <Modal v-model="showModal" modalClass="max-width: 700px" title="New cash Receipt" v-on:before-open="setDefaults">
            <div class="py-3">
                <form class="space-y-4">
                    <div>
                        <label for="customer" class="block text-sm font-medium text-gray-700">Customer</label>
                        <div class="mt-1">
                            <multiselect
                                v-model="form.customer"
                                :options="customers"
                                id="customer"
                                trackBy="id"
                                label="name"
                                name="customer"
                                placeholder="select customer"
                            ></multiselect>
                        </div>
                        <p v-if="errors.customer" class="mt-2 text-sm text-red-600" id="customer-error">
                            {{ errors.customer[0] }}
                        </p>
                    </div>
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                        <div class="mt-1">
                            <input v-model="form.amount" type="number" name="amount" id="amount"
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                   :class="{'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500' : errors.amount}"
                                   placeholder="Amount">
                        </div>
                        <p v-if="errors.amount" class="mt-2 text-sm text-red-600" id="amount-error">
                            {{ errors.amount[0] }}
                        </p>
                    </div>
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                        <div class="mt-1">
                            <date-picker class="inline-block h-full w-full" v-model="form.date" id="date">
                                <template v-slot="{ inputValue, togglePopover }">
                                    <div class="flex items-center">
                                        <button
                                            type="button"
                                            class="p-2 bg-blue-100 border border-blue-200 hover:bg-blue-200 text-blue-600 rounded-l focus:bg-blue-500 focus:text-white focus:border-blue-500 focus:outline-none"
                                            @click.prevent="togglePopover()"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20"
                                                class="w-4 h-4 fill-current"
                                            >
                                                <path
                                                    d="M1 4c0-1.1.9-2 2-2h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4zm2 2v12h14V6H3zm2-6h2v2H5V0zm8 0h2v2h-2V0zM5 9h2v2H5V9zm0 4h2v2H5v-2zm4-4h2v2H9V9zm0 4h2v2H9v-2zm4-4h2v2h-2V9zm0 4h2v2h-2v-2z"
                                                ></path>
                                            </svg>
                                        </button>
                                        <input
                                            :value="inputValue"
                                            class="bg-white text-gray-700 w-full py-1 px-2 appearance-none border rounded-r focus:outline-none focus:border-blue-500"
                                            readonly
                                            @focus="togglePopover()"
                                        />
                                    </div>
                                </template>
                            </date-picker>
                        </div>
                        <p v-if="errors.date" class="mt-2 text-sm text-red-600" id="date-error">
                            {{ errors.date[0] }}
                        </p>
                    </div>
                    <div>
                        <label for="note" class="block text-sm font-medium text-gray-700">Note</label>
                        <div class="mt-1">
                            <textarea v-model="form.note" name="note" id="note"
                                      class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                      :class="{'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500' : errors.note}"
                            ></textarea>
                        </div>
                        <p v-if="errors.note" class="mt-2 text-sm text-red-600" id="note-error">
                            {{ errors.note[0] }}
                        </p>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button
                            type="button"
                            class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            @click="saveAndNew"
                        >
                            Save and New
                        </button>
                        <button
                            type="button"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                            @click.prevent="submit"
                        >
                            Save
                        </button>
                    </div>
                </form>

            </div>
        </Modal>
    </div>
</template>

<script>
import AppDropDown from "../../../components/AppDropdown";
import DropdownItem from "../../../components/partials/DropDownItem";

export default {
    name: 'cash-receipt-modal',
    components: {DropdownItem, AppDropDown},
    props: ['customers'],
    data() {
        return {
            showModal: false,
            closeAfterSave: true,
            errors: {},
            receipt: null,
            form: {
                customer: '',
                amount: '',
                date: new Date(),
                note: '',
            }
        }
    },
    methods: {
        submit() {

            axios({
                method: this.receipt ? 'patch' : 'post',
                url: this.receipt ? `api/cash-receipts/${this.receipt.id}` : `api/cash-receipts`,
                data: {
                    ...this.form,
                    customer: this.form.customer ? this.form.customer.id : ''
                }
            })
                .then(response => {

                    this.resetForm()

                    this.$emit('fetch-receipts', true)

                    if (this.closeAfterSave) {
                        this.showModal = false
                    }

                }).catch(e => {
                if (e.response.status === 422) {
                    this.errors = e.response.data.errors
                    this.$toast.error('The form submitted has errors');
                    return
                }
                this.$toast.error('Something went wrong try again later');
            })
        },
        saveAndNew() {
            this.closeAfterSave = false
            this.submit()
        },
        resetForm() {
            this.form = {
                customer: '',
                amount: '',
                date: new Date(),
                note: ''
            }
        },
        setDefaults() {
            this.form.customer = this.receipt ? this.customers.find(customer => customer.id === this.receipt.customer_id) : ''
            this.form.amount = this.receipt ? this.receipt.amount : ''
            this.form.date = this.receipt ? this.receipt.date : ''
            this.form.note = this.receipt ? this.receipt.note : ''
        }
    }
}
</script>