<template>
    <div>
        <button
            type="button"
            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
            @click="showModal=true"
        >
            New Supplier
        </button>

        <Modal v-model="showModal" modalClass="max-width: 700px" title="New Supplier" v-on:before-open="initializeForm"
               v-on:before-close="resetForm" :enable-close="false">
            <div class="py-3">
                <form class="space-y-3">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <div class="mt-1">
                            <input v-model="form.name" type="text" name="name" id="name"
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                   :class="{'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500' : errors.name}"
                                   placeholder="Supplier name">
                        </div>
                        <p v-if="errors.name" class="mt-2 text-sm text-red-600" id="email-error">{{
                                errors.name[0]
                            }}</p>
                    </div>
                    <div class="flex justify-between">
                        <div>
                            <button
                                type="button"
                                class="inline-flex items-center px-2.5 py-1.5 border border-red-300 shadow-sm text-xs font-medium rounded text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                @click.prevent="showModal = false"
                            >
                                Close
                            </button>
                        </div>
                        <div class="space-x-2">
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
                    </div>
                </form>

            </div>
        </Modal>
    </div>
</template>

<script>
export default {
    name: 'supplier-modal',
    data() {
        return {
            showModal: false,
            closeAfterSave: true,
            errors: {},
            form: {
                name: ''
            }
        }
    },
    methods: {
        async submit() {
            try {
                await axios({
                    method: this.$parent.supplier ? 'patch' : "post",
                    url: this.$parent.supplier ? `api/suppliers/${this.$parent.supplier.id}` : 'api/suppliers',
                    data: this.form
                })

                this.resetForm()

                this.$emit('fetch-suppliers', true)

                if (this.closeAfterSave) {
                    this.showModal = false
                }
            }catch (e) {
                if (e.response.status === 422) {
                    this.errors = e.response.data.errors
                    this.$toasted.error('The form submitted has errors');
                    return
                }
                this.$toasted.error('Something went wrong try again later');
            }
        },
        saveAndNew() {
            this.closeAfterSave = false
            this.submit()
        },
        resetForm() {
            this.$emit('reset-supplier')
            this.errors = []
            this.form = {
                name: ''
            }
        },
        initializeForm() {
            this.form.name = this.$parent.supplier ? this.$parent.supplier.name : ''
        }
    },
}
</script>