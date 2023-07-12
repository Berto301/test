<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button :type="type" class="items-center justify-center w-full px-4 py-2 bg-[#dc3545] border border-transparent rounded-md font-semibold text-[14px] text-white  tracking-widest hover:bg-[#c82333] active:bg-[#c82333] focus:outline-none focus:ring-2 focus:ring-[#c82333] focus:ring-offset-2 transition ease-in-out duration-150">
        <slot />
    </button>
</template>
