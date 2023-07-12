<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button :type="type" class="items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-[14px] text-white  w-full tracking-widest hover:bg-gray-700  transition ease-in-out duration-150">
        <slot />
    </button>
</template>
