<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import SuccessButton from "@/Components/SuccessButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import { ref } from "vue";
import {
  Listbox,
  ListboxButton,
  ListboxOptions,
  ListboxOption,
  Switch,
} from "@headlessui/vue";
import ModalAddUpdateUser from "./ModalAddUpdateUser.vue";
import ModalConfirmation from "./ModalConfirmation.vue";


const statusLists = [
  { id: 1, name: "Actif", key: "active" },
  { id: 2, name: "Inactif", key: "inactive" },
];
const selectedStatus = ref(statusLists[0]);
const enabled = ref(false);
const openModalUser = ref(false)
const openModalDeleteUser = ref(false)
const openModal = () => openModalUser.value = true
const closeModal = () => openModalUser.value = false
const openModalDelete = () => openModalDeleteUser.value = true
const closeModalDelete = () => openModalDeleteUser.value = false
</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-900 leading-tight">
        User - lists
      </h2>
    </template>

    <div class="flex items-center space-x-6">
      <div class="relative">
        <div
          class="p-4 text-gray-900 border-r-0 text-sm border border-solid bg-[#ecefee] after:absolute after:right-0 after:top-1/2 after:border-[27px] after:border-solid after:w-0 after:h-0 after:content-[''] after:-translate-y-1/2 after:translate-x-full after:border-y-transparent after:border-r-transparent after:border-l-[#ecefee]"
        >
          Gestion générale
        </div>
      </div>
      <div class="relative">
        <div
          class="py-4 pr-8 pl-14 text-white text-sm border border-solid bg-[#49c5b6] border-r-0 after:absolute after:right-0 after:top-1/2 after:border-[27px] after:border-solid after:w-0 after:h-0 after:content-[''] after:-translate-y-1/2 after:translate-x-full after:border-y-transparent after:border-r-transparent after:border-l-[#49c5b6] before:absolute before:left-0 before:top-1/2 before:border-[27px] before:border-solid before:w-0 before:h-0 before:content-[''] before:-translate-y-1/2 before:border-y-transparent before:border-r-transparent before:border-l-[#f4f7f6]"
        >
          User list
        </div>
      </div>
    </div>
    <div class="w-56">
      <SuccessButton class="flex items-center space-x-2" type="button" @click="openModal">
        <span class="text-whiite text-sm"> Ajouter un utilisateur</span>
        <i class="fa fa-plus"></i>
      </SuccessButton>
    </div>
    <div class="w-full">
      <div class="p-4 uppercase w-full bg-gray-400 text-gray-900">
        RECHERCHER
      </div>
      <div class="py-2 pl-4 pr-8 flex items-center justify-between bg-white">
        <div class="flex space-x-4 items-center">
          <span class="text-sm font-normal text-gray-900">Nom:</span>
          <input
            type="text"
            class="p-4 border border-solid border-[#ced4da] text-gray-900 text-sm h-9 bg-white rounded"
          />
        </div>
        <div class="flex space-x-4 items-center">
          <span class="text-sm font-normal text-gray-900">Statut:</span>
          <div class="w-72">
            <Listbox v-model="selectedStatus">
              <div class="relative mt-1">
                <ListboxButton
                  class="relative w-full cursor-default border border-solid border-[#ced4da] rounded-lg bg-white py-2 pl-3 pr-10 text-left sm:text-sm"
                >
                  <span class="block truncate">{{ selectedStatus.name }}</span>
                  <span
                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center p-4 bg-[#F55611]"
                  >
                    <i class="fa-solid fa-sort-down" style="color: white"></i>
                  </span>
                </ListboxButton>

                <transition
                  leave-active-class="transition duration-100 ease-in"
                  leave-from-class="opacity-100"
                  leave-to-class="opacity-0"
                >
                  <ListboxOptions
                    class="absolute mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg z-10 ring-opacity-5 focus:outline-none sm:text-sm"
                  >
                    <ListboxOption
                      v-slot="{ selected }"
                      v-for="status in statusLists"
                      :key="status.name"
                      :value="status"
                      as="template"
                    >
                      <li
                        :class="[
                          selected
                            ? 'bg-[#49c5b6] text-white'
                            : 'text-gray-900',
                          'relative  select-none py-2 pl-10 pr-4 mb-2 cursor-pointer',
                        ]"
                      >
                        <span
                          :class="[
                            selected ? 'font-medium' : 'font-normal',
                            'block truncate',
                          ]"
                          >{{ status.name }}</span
                        >
                      </li>
                    </ListboxOption>
                  </ListboxOptions>
                </transition>
              </div>
            </Listbox>
          </div>
        </div>
        <div class="w-72">
          <SuccessButton class="ml-0 text-whiite text-sm" type="button">
            Rechercher
          </SuccessButton>
        </div>
      </div>
    </div>
    <div class="w-full flex justify-between bg-white p-4">
      <div class="w-1/5 flex justify-center items-center">
        <img
          :src="`${
            user?.profile_photo_path
              ? `storage/${user?.profile_photo_path}`
              : user?.profile_photo_url
              ? user?.profile_photo_url
              : `images/profile.png`
          }`"
          alt="user-image"
          class="rounded-full h-20 w-20 object-cover"
        />
      </div>
      <div class="w-1/5 text-gray-900 font-semibold text-base">Berto</div>
      <div class="w-1/5 flex flex-col space-y-4">
        <div class="flex items-center">
          <Switch
            v-model="enabled"
            :class="
              enabled
                ? 'bg-[#49c5b6] border-[#49c5b6]'
                : 'bg-[#dc3545] border-[#dc3545]'
            "
            class="relative inline-flex h-[38px] w-[74px] shrink-0 cursor-pointer rounded border-2 border-[#49c5b6] transition-colors duration-200 ease-in-out focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
          >
            <span
              aria-hidden="true"
              :class="enabled ? `translate-x-9 ` : `translate-x-0`"
              class="pointer-events-none inline-block h-[34px] w-[34px] transform rounded shadow-lg bg-white ring-0 transition duration-200 ease-in-out"
            />
            <span
              :class="`absolute ${enabled ? 'left-px' : 'right-px'} -translate-y-1/2  top-1/2 text-white uppercase text-sm font-semibold`"
            
            >
              {{ enabled ? 'ON' :'OFF' }}
            </span>
            
          </Switch>
          <span
            class="text-[#49c5b6] text-sm font-semibold uppercase block ml-4"
            >ACTIF</span
          >
        </div>

        <span class="text-sm text-gray-900 font-semibold"
          >Date de création de compte :
          <span class="font-normal">01/11/2023</span></span
        >
      </div>
      <div class="w-1/5 flex flex-col space-y-4">
        <div class="flex items-center space-x-4 text-gray-900">
          <i class="fa fa-envelope" style="color: #49c5b6"></i>
          <span class="font-normal text-sm text-[#49c5b6]"
            >berto@gmail.com</span
          >
        </div>
        <div class="flex items-center space-x-4 text-gray-900">
          <i class="fa fa-phone"></i>
          <span class="font-normal text-sm">0346628361</span>
        </div>
        <div class="flex items-center space-x-4 text-gray-900">
          <i class="fa fa-mobile"></i>
          <span class="font-normal text-sm">0346628361</span>
        </div>
      </div>
      <div class="w-1/5 flex flex-col space-y-4">
        <div class="w-1/2 ml-12">
          <SuccessButton class="ml-0 text-whiite text-sm" type="button" @click="openModal">
            Editer
          </SuccessButton>
        </div>
        <div class="w-1/2 ml-12">
          <DangerButton class="ml-0" type="button" @click="openModalDelete"> Supprimer </DangerButton>
        </div>
      </div>
      <!--Modal Update / Add User -->
      <ModalAddUpdateUser 
        :click-modal="closeModal"
        :open="openModalUser"
        :save="closeModal"
      />
      <!--Modal Update / Add User -->
      <ModalConfirmation 
       :open="openModalDeleteUser"
       :click-modal="closeModalDelete"
       :save="closeModalDelete"
      />
    </div>
  </AppLayout>
</template>
