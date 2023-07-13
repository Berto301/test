<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'

 defineProps({
  user: Object,
});

</script>

<template>
  <div class="w-64 h-full float-left mt-16 fixed left-1 bg-[#f4f7f6] z-10 space-y-4 shadow-lg">
    <div class="m-5 flex items-center justify-between space-x-4">
      <img
          :src="`${user?.profile_photo_path ? `storage/${user?.profile_photo_path}` : `images/profile.png` }`"
          alt="user-image"
          class="rounded-full h-20 w-20 object-cover"
      />
      <div class="flex flex-col space-y-2 text-sm text-gray-900">
        <div class="font-normal">Bienvenue,</div>
        <div class="font-semibold">Mr {{ user?.name }} {{ user?.firstname  }}</div>
      </div>
    </div>
    <div class="flex flex-wrap pl-0 mb-0 ">
      <div class="mb-[-1px] border border-solid border-b-0 rounded-tl rounded-tr p-3 ">
        <span class="text-[#49c5b6] bg-transparent  font-semibold ">
          Menu
        </span>
      </div>
      <div class="border border-solid border-x-0 border-t-0 border-[#dee2e6] p-4 w-[74%]">

      </div>
    </div>

    <Disclosure v-slot="{ open }">
      <DisclosureButton :class="`bg-[#f1f1f1] p-4 w-full flex justify-between items-center border border-l-4 transition ease-in-out duration-150 ${open ? 'border-l-[#49c5b6] ' : 'border-l-transparent'}`">
        <i class="fas fa-cog" style="color: #49c5b6"></i>
        <span class="text-gray-900">Gestion générale</span>
        <div
          :class="`transform transition ease-in-out duration-150 ${open ? 'rotate-90 -mb-4':'rotate-0'} `"
          class="h-5 w-5 "
        >
        <svg width="10" height="18" viewBox="0 0 10 18" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1.515 17.7891L10 9.30406L1.515 0.819064L0.099999 2.23306L7.172 9.30406L0.1 16.3751L1.515 17.7891Z" fill="#c5c5c5"/>
        </svg>
        </div>
      </DisclosureButton>
      <DisclosurePanel >
         <div class="ml-6 px-4 transition ease-in-out duration-150 space-x-4">
            <!-- <Link :href="route('dashboard')" class="flex  items-center space-x-4">  -->
              <i class="fas fa-list-ul" style="color: #49c5b6"></i>
              <span class="font-bold text-sm text-[#49c5b6]">User list</span>
            <!-- </Link> -->
         </div>
      </DisclosurePanel>
    </Disclosure>
  </div>
  
</template>
