<script setup>
import { Inertia } from "@inertiajs/inertia";
import { Link } from "@inertiajs/inertia-vue3";
defineProps({
    user: Object
});

</script>

<template>
    <div class="bg-[#232c73] text-white fixed top-1 left-0 w-full z-50 border border-solid border-x-0 border-t-0 border-b-[#eee]">
        <div class="flex flex-wrap items-center justify-between w-full px-4 mx-auto py-4">
            <div >
                Logo
            </div>
            <div class="flex items-center space-x-4">
                <span> Deconnexion </span>
                <i class="fa fa-sign-out-alt" style="color: #fff"></i>
            </div>
        </div>
    </div>
</template>
