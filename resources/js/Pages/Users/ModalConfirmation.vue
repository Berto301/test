<script setup>
import SuccessButton from "@/Components/SuccessButton.vue";
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from "@headlessui/vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";

const props = defineProps({
user:Object
});
const $emit = defineEmits(["save","clickModal"]);
</script>
<template>
  <DialogPanel
    class="w-[40rem] transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
  >
    <DialogTitle
      as="div"
      class="flex justify-between items-center py-4 px-2 border border-solid border-x-0 border-t-0 border-b-[#ced4da]"
    >
      <div class="flex items-center space-x-4">
        <i class="fa-solid fa-user-xmark"></i>
        <span class="text-lg font-medium leading-6 text-gray-900"
          >Suppression utilisateur</span
        >
      </div>
      <span
        class="text-lg font-medium leading-6 text-gray-900 cursor-pointer"
        @click="$emit('clickModal')"
        >X</span
      >
    </DialogTitle>

    <div class="mt-4 flex text-gray-900 font-semibold px-16 text-2xl">
      Etes-vous sur vouloir supprimer cet utilisateur ?
    </div>
    <div class="mt-4 flex items-center justify-end">
      <div class="w-40">
        <SecondaryButton @click="$emit('clickModal')"> Annuler </SecondaryButton>
      </div>
      <div class="w-40">
        <DangerButton class="ml-3" @click="$emit('save',props.user.id)"> Supprimer </DangerButton>
      </div>
    </div>
  </DialogPanel>
</template>
