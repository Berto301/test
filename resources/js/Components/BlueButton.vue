<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button :type="type" class="items-center px-4 py-2 bg-[#337ab7] border border-transparent rounded-md font-semibold text-[14px] text-white  w-full h-full tracking-widest hover:bg-[#56a1e2] focus:bg-[#56a1e2] active:bg-[#56a1e2]  transition ease-in-out duration-150">
        <slot />
    </button>
</template>
