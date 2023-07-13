<script setup>
import { Inertia } from "@inertiajs/inertia";
defineProps({
    user: Object
});
const logout = () => {
    Inertia.post(route('logout'));
};
</script>

<template>
    <div class="bg-white text-gray-900 font-semibold fixed top-1 left-0 w-full  border-0">
        <div class="flex flex-wrap items-center justify-between w-full px-4 mx-auto py-4">
            <div>
                Logo
            </div>
            <div class="flex items-center space-x-4 cursor-pointer" @click="logout">
                <span> Deconnexion </span>
                <i class="fa fa-sign-out-alt" style="color: #111827"></i>
            </div>
        </div>
    </div>
</template>
