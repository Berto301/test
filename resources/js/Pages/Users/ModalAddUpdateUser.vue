<script setup>
import SuccessButton from "@/Components/SuccessButton.vue";
import {
  DialogPanel,
  DialogTitle,
  Listbox,
  ListboxButton,
  ListboxOptions,
  ListboxOption,
} from "@headlessui/vue";
import { useForm } from "@inertiajs/vue3";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import BlueButton from "@/Components/BlueButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import { ref } from "vue";

const props = defineProps({
  user: Object,
});

const $emit = defineEmits(["save", "clickModal"]);
const civilities = [
  { id: 1, name: "Mr", key: "Mr" },
  { id: 2, name: "Mlle", key: "Mlle" },
];
let userInfo = useForm({
  name: "",
  firstname: "",
  civility: civilities[0],
  phone: "",
  mobile: "",
  role: "user",
  email: "",
  status: false,
  photo:null
});
const photoInput = ref(null);
const photoPreview = ref(null);
const selectNewPhoto = () => {
  photoInput.value.click();
};

const updatePhotoPreview = () => {
  const photo = photoInput.value.files[0];

  if (!photo) return;

  const reader = new FileReader();

  reader.onload = (e) => {
    photoPreview.value = e.target.result;
  };

  reader.readAsDataURL(photo);
};
const clearPhotoFileInput = () => {
  if (photoInput.value?.value) {
    photoInput.value.value = null;
  }
};
if (props?.user?.id) {
  userInfo = {...userInfo, ...props?.user };
  userInfo.civility = civilities?.find(
    (_civility) => _civility.key === props.user.civility
  );
}

const submit =  () => {
  if (photoInput.value) {
    userInfo.photo = photoInput.value.files[0]; 
  }
  
  $emit("save", userInfo);
  clearPhotoFileInput()
};
</script>
<template>
  <DialogPanel
    class="w-full max-w-[66.063rem] transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
  >
    <DialogTitle
      as="div"
      class="flex justify-between items-center py-4 px-2 border border-solid border-x-0 border-t-0 border-b-[#ced4da]"
    >
      <div class="flex items-center space-x-4">
        <i class="fa fa-user-plus"></i>
        <span class="text-lg font-medium leading-6 text-gray-900">{{
          props?.user?.id
            ? "Modifier les informations de l'utilisateur"
            : "Ajouter un utilisateur"
        }}</span>
      </div>
      <span
        class="text-lg font-medium leading-6 text-gray-900 cursor-pointer"
        @click="$emit('clickModal')"
        >X</span
      >
    </DialogTitle>
    <form @submit.prevent="submit">
      <div class="mt-4 flex">
        <div class="flex flex-col space-y-4 w-1/3 items-center justify-center">
          <input
            ref="photoInput"
            type="file"
            class="hidden"
            @change="updatePhotoPreview"
          />
          <!-- Current Profile Photo -->
          <div v-show="!photoPreview" class="mt-2">
            <img
              :src="`${
                user?.profile_photo_path
                  ? `storage/${user?.profile_photo_path}`
                  : `images/profile.png`
              }`"
              alt="image"
              class="rounded-full h-40 w-40 object-cover"
            />
          </div>

          <!-- New Profile Photo Preview -->
          <div v-show="photoPreview" class="mt-2">
            <span
              class="block rounded-full h-40 w-40 bg-cover bg-no-repeat bg-center"
              :style="'background-image: url(\'' + photoPreview + '\');'"
            />
          </div>
          <div class="w-60 h-20">
            <BlueButton @click.prevent="selectNewPhoto">
              Choisir une photo
            </BlueButton>
          </div>
          <div class="flex space-x-4 text-sm items-center">
            <div
              class="border border-solid border-[#dc3545] rounded-r-md rounded-l-md bg-white p-2 text-[#dc3545] uppercase font-semibold"
            >
              Notes
            </div>
            <div class="font-normal text-gray-900">
              Formats: JPG , PNG , GIF.
            </div>
          </div>
          <div class="w-60">
            <DangerButton class="ml-0" type="submit">
              Supprimer la photo
            </DangerButton>
          </div>
        </div>
        <div
          class="w-2/3 flex flex-col space-y-4 border border-solid border-x-0 border-t-0 border-b-[#ced4da] pb-8"
        >
          <div class="flex items-center justify-between space-x-4">
            <!--SECTION CIVILITE-->
            <div class="w-1/3 flex flex-col space-y-2">
              <InputLabel for="civility" value="Civilité" :required="true" />
              <Listbox v-model="userInfo.civility">
                <div class="relative mt-1">
                  <ListboxButton
                    class="relative w-full cursor-default border border-solid border-[#ced4da] rounded-lg bg-white py-2 pl-3 pr-10 text-left sm:text-sm"
                  >
                    <span class="block truncate">{{
                      userInfo.civility?.name
                    }}</span>
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
                        v-for="_civility in civilities"
                        :key="_civility.name"
                        :value="_civility"
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
                            >{{ _civility.name }}</span
                          >
                        </li>
                      </ListboxOption>
                    </ListboxOptions>
                  </transition>
                </div>
              </Listbox>
              <InputError :message="userInfo.errors?.civility" />
            </div>
            <div class="w-1/3 flex flex-col space-y-2">
              <InputLabel for="firstname" value="Prenom" :required="true" />
              <TextInput
                id="firstname"
                v-model="userInfo.firstname"
                type="text"
                class="mt-1 block w-full"
                required
                autofocus
                autocomplete="name"
              />
              <InputError :message="userInfo.errors?.firstname" />
            </div>
            <div class="w-1/3 flex flex-col space-y-2">
              <InputLabel for="name" value="Nom" :required="true" />
              <TextInput
                id="name"
                v-model="userInfo.name"
                type="text"
                class="mt-1 block w-full"
                required
                autofocus
                autocomplete="name"
              />
              <InputError :message="userInfo.errors?.name" />
            </div>
          </div>
          <!--SECTION INFORMATIONS-->
          <div class="bg-gray-400 text-gray-900 px-8 py-4 w-full rounded">
            Informations
          </div>
          <div class="flex items-center space-x-4">
            <div class="w-1/2 flex flex-col space-y-2">
              <InputLabel for="telephone" value="Telephone" :required="true" />
              <TextInput
                id="telephone"
                v-model="userInfo.phone"
                type="text"
                class="mt-1 block w-full"
                required
                autofocus
                autocomplete="name"
              />
              <InputError :message="userInfo.errors?.phone" />
            </div>
            <div class="w-1/2 flex flex-col space-y-2">
              <InputLabel for="mobile" value="Mobile" :required="true" />
              <TextInput
                id="mobile"
                v-model="userInfo.mobile"
                type="text"
                class="mt-1 block w-full"
                required
                autofocus
                autocomplete="name"
              />
              <InputError :message="userInfo.errors?.mobile" />
            </div>
          </div>

          <!--SECTION INFORMATIONS-->
          <div class="bg-gray-400 text-gray-900 px-8 py-4 w-full rounded">
            Informations de connexion
          </div>
          <div class="flex items-center justify-between">
            <div class="w-1/2 flex flex-col space-y-2">
              <InputLabel for="email" value="Email" :required="true" />
              <TextInput
                id="email"
                type="email"
                class="mt-1 block w-full"
                required
                autofocus
                autocomplete="name"
                v-model="userInfo.email"
              />
              <InputError :message="userInfo.errors?.email" />
            </div>
            <div class="w-60">
              <DangerButton class="ml-0 mt-[30px]" type="submit">
                Changer de mot de passe
              </DangerButton>
            </div>
          </div>
        </div>
      </div>
      <div class="mt-16 flex items-center justify-between">
        <div class="flex items-center space-x-4">
          <i class="fa-solid fa-lock" style="color: #dc3545"></i>
          <span class="text-lg font-medium leading-6 text-[#dc3545]"
            >Ajouter un utilisateur</span
          >
        </div>
        <div class="flex items-center space-x-4">
          <div class="w-40">
            <SecondaryButton @click="$emit('clickModal')">
              Annuler
            </SecondaryButton>
          </div>
          <div class="w-40">
            <!-- @click="save(userInfo)" -->
            <SuccessButton
              class="ml-3"
              type="submit"
              :class="{ 'opacity-25': userInfo.processing }"
              :disabled="userInfo.processing"
            >
              Enregistrer
            </SuccessButton>
          </div>
        </div>
      </div>
    </form>
  </DialogPanel>
</template>
