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
        <div class="col-span-2">
            <div>
                <label for="date_from" class="block text-sm font-medium text-gray-700">From</label>
                <div class="mt-1">
                    <input v-model="filters.date_from" type="date" name="date_from" id="date_from" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                </div>
            </div>
        </div>
        <div class="col-span-2">
            <div>
                <label for="date_to" class="block text-sm font-medium text-gray-700">To</label>
                <div class="mt-1">
                    <input v-model="filters.date_to" type="date" name="date_to" id="date_to" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
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
                date_from: '',
                date_to: '',
            }
        },
        applyFilters() {
            let data = {
                entity: this.filters.entity ? this.filters.entity.id : '',
                status: this.filters.status,
                from: this.filters.date_from,
                to: this.filters.date_to
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