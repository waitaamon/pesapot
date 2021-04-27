<template>
    <button
            type = 'button'

            role="menuitem">
        <slot/>
    </button>
</template>

<script>
export default {
    name: 'dropdown-item',
}
</script>