<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button :type="type" class="items-center px-4 py-2 bg-[#6c757d] border border-transparent rounded-md font-semibold text-[14px] text-white  w-full tracking-widest hover:bg-[#51575d] focus:bg-[#51575d] active:bg-[#51575d] focus:outline-none focus:ring-2  focus:ring-offset-2 transition ease-in-out duration-150">
        <slot />
    </button>
</template>
