<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps(["nekos"]);

const form = useForm({
  title: null,
  description: null,
  image: null,
  chapters: null,
  year: null,
});
</script>

<template>
  <AuthenticatedLayout>
    <form
      @submit.prevent="form.post(route('nekos.store'))"
      class="flex justify-center self-center p-5 w-2/2"
    >
      <div class="p-12 bg-white mx-auto rounded-3xl w-96">
        <div class="mb-7">
          <h3 class="font-semibold text-2xl text-gray-800">Add a product</h3>
        </div>
        <div class="space-y-6">
          <input
            v-model="form.title"
            type="text"
            class="w-full text-sm px-4 py-3 bg-gray-100 focus:bg-gray-200 border border-gray-300 rounded-lg focus:outline-none focus:border-gray-400"
            placeholder="title"
          />
          <input
            v-model="form.description"
            placeholder="description"
            type="text"
            class="text-sm text-gray-600 px-4 py-3 rounded-lg w-full bg-gray-100 focus:bg-gray-200 border border-gray-300 focus:outline-none focus:border-gray-400"
          />
          <div v-if="form.errors.description">
            {{ form.errors.description }}
          </div>
          <input
            v-model="form.image"
            placeholder="image of your cat"
            type="text"
            class="text-sm text-gray-600 px-4 py-3 rounded-lg w-full bg-gray-100 focus:bg-gray-200 border border-gray-300 focus:outline-none focus:border-gray-400"
          />
          <input
            v-model="form.cuteness"
            placeholder="cuteness"
            type="text"
            class="text-sm text-gray-600 px-4 py-3 rounded-lg w-full bg-gray-100 focus:bg-gray-200 border border-gray-300 focus:outline-none focus:border-gray-400"
          />
          <div>
            <input
              v-model="form.rating"
              placeholder="rating"
              type="text"
              class="mb-7 box-border text-sm text-gray-600 px-4 py-3 rounded-lg w-full bg-gray-100 focus:bg-gray-200 border border-gray-300 focus:outline-none focus:border-gray-400"
            />
            <div>
              <button
                type="submit"
                :disabled="form.processing"
                class="w-full flex justify-center bg-gray-600 hover:bg-gray-500 text-gray-100 p-3 rounded-lg tracking-wide font-semibold cursor-pointer transition ease-in duration-500"
              >
                Submit your product!
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </AuthenticatedLayout>
</template>
