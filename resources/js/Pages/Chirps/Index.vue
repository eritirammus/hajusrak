<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Chirp from "@/Components/Chirp.vue";
import { Head, useForm } from "@inertiajs/vue3";

defineProps(["chirps", "comments"]);
const form = useForm({
  title: "",
  description: "",
});
</script>

<template>
  <Head title="Chirps" />

  <AuthenticatedLayout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 p-5 lg:p-8">
      <form
        @submit.prevent="
          form.post(route('chirps.store'), { onSuccess: () => form.reset() })
        "
      >
        <input
          v-model="form.title"
          class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
          placeholder="Title of your post"
          type="text"
        />
        <textarea
          v-model="form.description"
          class="mt-4 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
          placeholder="Spread your chirps here..."
        ></textarea>
        <InputError
          :message="form.errors.title"
          class="mt-2 text-bold text-2xl"
        />
        <PrimaryButton class="mt-4">Tweet</PrimaryButton>
      </form>
      <div class="mt-6 bg-white rounded-lg divide-y-2">
        <Chirp
          v-for="chirp in chirps"
          :key="chirp.id"
          :chirp="chirp"
          :comments="comments"
        />
      </div>
    </div>
  </AuthenticatedLayout>
</template>
