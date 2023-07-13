<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import SuccessButton from "@/Components/SuccessButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import { reactive, ref } from "vue";
import {
  Listbox,
  ListboxButton,
  ListboxOptions,
  ListboxOption,
  Switch,
  TransitionRoot,
  TransitionChild,
  Dialog,
} from "@headlessui/vue";

import ModalAddUpdateUser from "./ModalAddUpdateUser.vue";
import ModalConfirmation from "./ModalConfirmation.vue";
import moment from "moment-timezone";
import { Inertia } from "@inertiajs/inertia";
import UsersServices from "../../service/Users.service";
import { isEqual } from "lodash";

const props = defineProps({
  user: Object,
  users: Array,
});
const statusLists = [
  {id: 0, name: "Selectionnez le status", key: null},
  { id: 1, name: "Actif", key: 1 },
  { id: 2, name: "Inactif", key: 0 },
];
const selectedStatus = ref(statusLists[0]);


const openModalUser = ref(false);
const openModalDeleteUser = ref(false);
const selectedUser = ref(null);
const usersProps = ref(props?.users|| []);
const users = ref(usersProps.value)
const state = reactive({
  //users: props?.users,
  searchName:''
});
let {   searchName } = state;

const handleModalUser = (e, user) => {
  e.preventDefault();
  selectedUser.value = user ? { ...user } : null;
  openModalUser.value = true;
};
const HandleCloseModalUser = () => {
  selectedUser.value = null;
  openModalUser.value = false;
};

const openModalDelete =(e, user) => {
  e.preventDefault();
  selectedUser.value = user ? { ...user } : null;
  openModalDeleteUser.value = true;
};
const closeModalDelete = () => {
  selectedUser.value = null;
  openModalDeleteUser.value = false;
};

const saveUser = async (dataUser) => {
  const data = {
    ...dataUser,
    civility: dataUser?.civility?.key,
  };


  if (!dataUser?.id) {
    await UsersServices.create(data).then((reponse) => {
      if (reponse?.user) {
        users?.value?.push(reponse?.user);
        HandleCloseModalUser();
      }
    });
  } else {
    data.id = dataUser.id;
    const reponse =  await onUpdateUser(user)
    if (reponse?.user) {
        HandleCloseModalUser();
      }
  }
  if(dataUser?.photo){
    console.log({dataUser})
   await Inertia.put(route("user-profile-information.update"))
  }
  
};
const onEnableUser = async (user) => await onUpdateUser({...user,status: user?.status===1? 0: 1})

const onUpdateUser = async (data) => await UsersServices.update(data).then((reponse) => {
      if (reponse?.user) {
        users.value = users.value.map((_user) => {
          if (_user.id === reponse.user.id) _user = { ...reponse.user };
          return _user;
        });
        return reponse
      }
    }).catch((err)=> null); 

const deleteUser = (id) => UsersServices.deleteById(id).then((reponse)=>{
  closeModalDelete()
})
.catch((err)=>console.log(err))
const onFilter = ()=> {
  const tempUsers = [...usersProps.value]
  users.value = (!searchName && isEqual(selectedStatus.value?.key,null)) ? tempUsers :  tempUsers.filter((user)=>{
   if(searchName && ((user?.name?.toLowerCase().match(searchName.toLocaleLowerCase())) || (user?.firstname?.toLowerCase().match(searchName.toLocaleLowerCase())))) return true
   if(isEqual(user.status,selectedStatus.value.key)) return true
  })
}
</script>

<template>
  <AppLayout title="Dashboard" :user="user">
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
      <SuccessButton
        class="flex items-center space-x-2"
        type="button"
        @click="handleModalUser"
      >
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
            v-model="searchName"
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
          <SuccessButton class="ml-0 text-whiite text-sm" type="button" @click="onFilter">
            Rechercher
          </SuccessButton>
        </div>
      </div>
    </div>
    <div
      class="w-full flex justify-between bg-white p-4"
      v-if="users?.length"
      v-for="user in users"
      :key="user?.id"
    >
      <div class="w-1/5 flex justify-center items-center">
        <img
          :src="`${
            user?.profile_photo_path
              ? `storage/${user?.profile_photo_path}`
              : `images/profile.png`
          }`"
          alt="user-image"
          class="rounded-full h-20 w-20 object-cover"
        />
      </div>
      <div class="w-1/5 text-gray-900 font-semibold text-base">
        {{ user?.name }} {{ user?.firstname }}
      </div>
      <div class="w-1/5 flex flex-col space-y-4">
        <div class="flex items-center">
          <Switch
           
            @click="()=>onEnableUser(user)"
            :class="`${ user.status===1 ? 'bg-[#49c5b6] border-[#49c5b6]' : 'bg-[#dc3545] border-[#dc3545]'} ${ user.id===props.user.id ? 'cursor-none pointer-events-none' : 'cursor-pointer'} relative inline-flex h-[38px] w-[74px] shrink-0  rounded border-2 border-[#49c5b6] transition-colors duration-200 ease-in-out focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75`"
          >
            <span
              aria-hidden="true"
              :class="user.status===1 ? `translate-x-9 ` : `translate-x-0`"
              class="pointer-events-none inline-block h-[34px] w-[34px] transform rounded shadow-lg bg-white ring-0 transition duration-200 ease-in-out"
            />
            <span
              :class="`absolute ${
                user.status===1 ? 'left-px' : 'right-px'
              } -translate-y-1/2  top-1/2 text-white uppercase text-sm font-semibold`"
            >
              {{ user.status===1 ? "ON" : "OFF" }}
            </span>
          </Switch>
          <span
            class="text-[#49c5b6] text-sm font-semibold uppercase block ml-4"
            >ACTIF</span
          >
        </div>

        <span class="text-sm text-gray-900 font-semibold"
          >Date de création de compte :
          <span class="font-normal"
            >{{ moment(new Date(user?.created_at)).format("DD/MM/YYYY") }}
          </span></span
        >
      </div>
      <div class="w-1/5 flex flex-col space-y-4">
        <div class="flex items-center space-x-4 text-gray-900">
          <i class="fa fa-envelope" style="color: #49c5b6"></i>
          <span class="font-normal text-sm text-[#49c5b6]">{{
            user?.email
          }}</span>
        </div>
        <div class="flex items-center space-x-4 text-gray-900">
          <i class="fa fa-phone"></i>
          <span class="font-normal text-sm">{{ user?.phone }}</span>
        </div>
        <div class="flex items-center space-x-4 text-gray-900">
          <i class="fa fa-mobile"></i>
          <span class="font-normal text-sm">{{ user?.mobile }}</span>
        </div>
      </div>
      <div class="w-1/5 flex flex-col space-y-4">
        <div class="w-1/2 ml-12">
          <SuccessButton
            class="ml-0 text-whiite text-sm"
            type="button"
            @click="(e) => handleModalUser(e, user)"
          >
            Editer
          </SuccessButton>
        </div>
        <div class="w-1/2 ml-12">
          <DangerButton
            class="ml-0"
            type="button"
            @click="(e)=>openModalDelete(e,user)"
            v-if="!isEqual(user.id, props.user.id)"
          >
            Supprimer
          </DangerButton>
        </div>
      </div>
    </div>
    <div v-else class="text-gray-900 text-sm font-semibold w-full text-center">
      Aucun resultat
    </div>
    <!--Modal Update / Add User -->
    <TransitionRoot appear :show="openModalUser" as="template">
      <Dialog as="div" class="relative z-10">
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
            class="flex min-h-full items-start justify-center p-4 pt-20 text-center"
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
              <ModalAddUpdateUser
                @click-modal="HandleCloseModalUser"
                @save="saveUser"
                :user="selectedUser"
              />
            </TransitionChild>
          </div>
        </div>
      </Dialog>
    </TransitionRoot>

    <!--Modal Delete User -->
    <TransitionRoot appear :show="openModalDeleteUser" as="template">
      <Dialog as="div" class="relative z-10">
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
            class="flex min-h-full items-center justify-center p-4  text-center"
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
              <ModalConfirmation
                @click-modal="closeModalDelete"
                @save="deleteUser"
                :user="selectedUser"
              />
            </TransitionChild>
          </div>
        </div>
      </Dialog>
    </TransitionRoot>
  </AppLayout>
</template>
