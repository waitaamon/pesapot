<template>
    <nav class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6"
         aria-label="Pagination">
        <div class="hidden sm:block">
            <p class="text-sm text-gray-700">
                Showing
                <span class="font-medium">1</span>
                to
                <span class="font-medium">10</span>
                of
                <span class="font-medium">{{ paginationData.total }}</span>
                results
            </p>
        </div>
        <div class="flex justify-center items-center space-x-2">
            <div>
                <select v-model="perPage"  id="location" name="location"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option selected value="1">1</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="500">500</option>
                    <option value="1000">1000</option>
                </select>
            </div>
            <div class="flex-1 flex justify-between sm:justify-end">
                <a href="#" @click.prevent="goToPrevious"
                   class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Previous
                </a>
                <a href="#" @click.prevent="goToNext"
                   class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Next
                </a>
            </div>
        </div>

    </nav>
</template>

<script>
export default {
    name: 'table-pagination',
    props: ['paginationData', ],
    data() {
        return {
            perPage: 50
        }
    },
    watch: {
        perPage: {
            handler: function () {
                this.$emit('apply-per-page', this.perPage)
            }
        }
    },
    methods: {
        async goToNext() {
            if (!this.paginationData.next_page_url) return

            try {
                let response = await axios.get(this.paginationData.next_page_url)
                this.$emit('apply-pagination', response.data)
            } catch (e) {
                console.error('error in pagination')
            }
        },
        goToPrevious() {

        }
    }
}
</script>