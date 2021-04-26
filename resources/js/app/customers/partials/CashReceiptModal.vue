<template>
    <div>
        <button
            type="button"
            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
            @click="showModal=true"
        >
            New Cash Receipt
        </button>

        <Modal v-model="showModal" modalClass="max-width: 700px" title="New cash Receipt">
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
                        <label for="amount" class="block text-sm font-medium text-gray-700">Date</label>
                        <div class="mt-1">

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
export default {
    name: 'cash-receipt-modal',
    data() {
        return {
            showModal: false,
            closeAfterSave: true,
            errors: {},
            customers: [],
            form: {
                customer: '',
                amount: '',
                date: '',
                note: ''
            }
        }
    },
    methods: {
        async prerequisites() {
          try {
              let response = await axios.get('api/cash-receipt-prerequisites')
              this.customers = response.data.customers
          }  catch (e) {
              console.error('could not fetch prerequisites')
          }
        },
        submit() {
            axios.post('api/cash-receipts', this.form)
                .then(response => {

                    this.resetForm()

                    this.$emit('fetch-receipts', true)

                    if (this.closeAfterSave) {
                        this.showModal = false
                    }

                }).catch(e => {
                if (e.response.status === 422) {
                    this.errors = e.response.data.errors
                }

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
                date: '',
                note: ''
            }
        }
    },
    created() {
        this.prerequisites()
    }
}
</script>