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

defineProps({
  open: {
    type: Boolean,
    default: false,
  },
  clickModal: Function,
  save: Function,
});

</script>
<template>
  <TransitionRoot appear :show="open" as="template">
    <Dialog as="div" @close="clickModal" class="relative z-10">
      <TransitionChild
        as="template"
        enter="duration-300 ease-out"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="duration-200 ease-in"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-black bg-opacity-25" />
      </TransitionChild>

      <div class="fixed inset-0 overflow-y-auto">
        <div
          class="flex min-h-full items-center justify-center p-4 pt-20 text-center"
        >
          <TransitionChild
            as="template"
            enter="duration-300 ease-out"
            enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100"
            leave="duration-200 ease-in"
            leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95"
          >
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
                  @click="clickModal"
                  >X</span
                >
              </DialogTitle>

              <div class="mt-4 flex text-gray-900 font-semibold px-16 text-2xl">
                Etes-vous sur vouloir supprimer cet utilisateur ?
              </div>
              <div class="mt-4 flex items-center justify-end">
                <div class="w-40">
                    <SecondaryButton @click="clickModal">
                      Annuler
                    </SecondaryButton>
                  </div>
                  <div class="w-40">
                    <DangerButton class="ml-3" @click="save">
                      Supprimer
                    </DangerButton>
                  </div>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>
