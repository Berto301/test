<script setup>
defineProps({
    value: String,
    required:{
        type: Boolean,
        default:false
    }
});
</script>

<template>
    <label :class="` font-medium text-sm text-gray-900 ${required ? 'flex items-center space-x-4': 'block'}`">
        <span v-if="value">{{ value }}</span>
        <i class="fa-solid fa-lock" v-if="value && required" style="color: #dc3545;"></i>
    </label>
</template>
