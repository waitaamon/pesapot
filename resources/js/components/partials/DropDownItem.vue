<template>
    <div>
        <a v-if="type === 'link'"
           href='#'
           class='block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900'
           role="menuitem"
        >
            <slot/>
        </a>

        <button v-if="type === 'button'"
                type = 'button'
                class = 'block flex w-full px-4 py-2 space-x-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900'
                role="menuitem">
            <slot/>
        </button>
    </div>
</template>

<script>
export default {
    name: 'dropdown-item',
    props: {
        type: {
            required: false,
            type: String,
            default: 'link'
        }
    }
}
</script>