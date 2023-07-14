<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

defineProps({
  status: String,
});

const form = useForm({
  email: "",
});

const submit = () => {
  form.post(route("reset-password"));
};
</script>

<template>
  <AuthenticationCard>
    <div>
      <Head title="Forgot Password" />

      <div class="mb-4 text-sm text-gray-600">
        Vous avez oublié votre mot de passe ? Pas de problème. Il vous suffit de nous communiquer votre adresse électronique
        et nous vous enverrons un email contenant votre mot de passe.
      </div>

      <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
        {{ status }}
      </div>

      <form @submit.prevent="submit">
        <div>
          <InputLabel for="email" value="Email" />
          <TextInput
            id="email"
            v-model="form.email"
            type="email"
            class="mt-1 block w-full"
            required
            autofocus
            autocomplete="username"
          />
          <InputError class="mt-2" :message="form.errors.email" />
        </div>

        <div class="flex items-center justify-end mt-4">
          <PrimaryButton
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Envoyer
          </PrimaryButton>
        </div>
      </form>
    </div>
  </AuthenticationCard>
</template>
