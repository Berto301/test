<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button :type="type" class="items-center px-4 py-2 bg-[#49c5b6] border border-transparent rounded-md font-semibold text-[14px] text-white  w-full tracking-widest hover:bg-[#27b9a9] focus:bg-[#27b9a9] active:bg-[#27b9a9] focus:outline-none focus:ring-2  focus:ring-offset-2 transition ease-in-out duration-150">
        <slot />
    </button>
</template>
