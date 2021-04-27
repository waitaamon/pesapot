<template>
    <div class="grid grid-cols-4 gap-4 bg-gray-50 p-2 rounded">
        <div class="col-span-2">
            <label :for="model" class="block text-sm font-medium text-gray-700">{{ model }}</label>
            <multiselect
                v-model="filters.entity"
                :options="options"
                :id="model"
                trackBy="id"
                label="name"
                :name="model"
                placeholder=""
            ></multiselect>
        </div>
        <div class="col-span-2">
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select v-model="filters.status" id="status" name="status"
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option v-for="status in statuses" :key="status" class="capitalize">{{ status }}</option>
            </select>
        </div>
        <div class="col-span-4">
            <div>
                <label for="date" class="block text-sm font-medium text-gray-700">Select Date</label>
                <div class="mt-1">
                    <div class="mb-4">
                        <date-picker
                            v-model="filters"
                            mode="date"
                            :masks="masks"
                            is-range
                            id="date"
                        >
                            <template v-slot="{ inputValue, inputEvents, isDragging }">
                                <div class="flex flex-col sm:flex-row justify-start items-center w-full">
                                    <div class="relative flex-grow">
                                        <svg
                                            class="text-gray-600 w-4 h-full mx-2 absolute pointer-events-none"
                                            fill="none"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                            ></path>
                                        </svg>
                                        <input
                                            class="flex-grow pl-8 pr-2 py-1 border rounded w-full"
                                            :class="isDragging ? 'text-gray-600' : 'text-gray-900'"
                                            :value="inputValue.start"
                                            v-on="inputEvents.start"
                                        />
                                    </div>
                                    <span class="flex-shrink-0 m-2">
              <svg
                  class="w-4 h-4 stroke-current text-gray-600"
                  viewBox="0 0 24 24"
              >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M14 5l7 7m0 0l-7 7m7-7H3"
                />
              </svg>
                                    </span>
                                    <div class="relative flex-grow">
                                        <svg
                                            class="text-gray-600 w-4 h-full mx-2 absolute pointer-events-none"
                                            fill="none"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                            ></path>
                                        </svg>
                                        <input
                                            class="flex-grow pl-8 pr-2 py-1 border rounded w-full"
                                            :class="isDragging ? 'text-gray-600' : 'text-gray-900'"
                                            :value="inputValue.end"
                                            v-on="inputEvents.end"
                                        />
                                    </div>
                                </div>
                            </template>
                        </date-picker>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-2 flex justify-start items-center">
            <a @click.prevent="clearFilters" href="#" class="block capitalize text-red-300 text-sm hover:text-red-400">clear
                filters</a>
        </div>
        <div class="col-span-4"></div>
    </div>
</template>

<script>
export default {
    name: "data-table-filters",
    props: {
        options: {
            required: false,
            type: Array,
            default: []
        },
        model: {
            required: true,
            type: String,
        }
    },
    data() {
        return {
            statuses: ['active', 'transferred', 'reversed'],
            filters: {},
            masks: {
                input: 'DD-MM-YYYY',
            },
        }
    },
    watch: {
        filters: {
            deep: true,
            handler: function () {
                this.applyFilters()
            }
        }
    },
    methods: {
        clearFilters() {
            this.filters = {
                status: 'active',
                entity: '',
                start: '',
                end: '',
            }
        },
        applyFilters() {
            let data = {
                entity: this.filters.entity ? this.filters.entity.id : '',
                status: this.filters.status,
                start: this.filters.start ? this.filters.start.toDateString() : '',
                end: this.filters.end ? this.filters.end.toDateString() : ''
            }
            console.log(data)

            this.$emit('apply-filters', data)
        },
        created() {
            this.resetForm()
        }
    },
}
</script>