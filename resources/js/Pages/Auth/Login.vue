<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import Checkbox from "@/Components/Checkbox.vue";
import InputError from "@/Components/InputError.vue";
import DangerButton from "@/Components/DangerButton.vue";
import TextInput from "@/Components/TextInput.vue";

defineProps({
  canResetPassword: Boolean,
});

const form = useForm({
  email: "",
  password: "",
  remember: false,
});

const submit = () => {
  form
    .transform((data) => ({
      ...data,
      remember: form.remember ? "on" : "",
    }))
    .post(route("login"), {
      onFinish: () => form.reset("password"),
    });
};
</script>

<template>
  <div>
    <Head title="Log in" />

    <AuthenticationCard>
      <p class="font-[300] block mt-6 text-[18px] text-[#444]">Login</p>

      <form @submit.prevent="submit">
        <div>
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

        <div class="mt-4">
          <TextInput
            id="password"
            v-model="form.password"
            type="password"
            class="mt-1 block w-full"
            required
            autocomplete="current-password"
          />
          <InputError class="mt-2" :message="form.errors.password" />
        </div>

        <div class="block mt-4">
          <label class="flex items-center">
            <Checkbox v-model:checked="form.remember" name="remember" />
            <span class="ml-2 text-sm text-gray-600">Se souvenir de moi</span>
          </label>
        </div>

        <div class="flex items-center justify-end mt-4">
          <DangerButton
            class="ml-0"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
            type="submit"
          >
            Se connecter
          </DangerButton>
        </div>
        <div class="flex items-start justify-start mt-4">
          <Link
            v-if="canResetPassword"
            :href="route('password.request')"
            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            Mot de passe oublié?
          </Link>
        </div>
      </form>
    </AuthenticationCard>
  </div>
</template>
