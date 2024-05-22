<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import {useForm} from '@inertiajs/vue3';
import {ref} from 'vue';

const props = defineProps(['chirp', 'comments']);

const form = useForm({
    title: props.chirp.title,
    description: props.chirp.description,
});
const commentForm = useForm({
    message: '',
    chirp_id: props.chirp.id,
});
const editing = ref(false);
console.log(props.comments)

</script>

<template>
    <div class="p-6 flex space-x-2">
        <svg class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" stroke="currentColor"
             stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                stroke-linecap="round"
                stroke-linejoin="round"/>
        </svg>
        <div class="flex-1">
            <div class="flex justify-between items-center">
                <div>
                    <span class="text-gray-800">{{ chirp.user.name }}</span>
                    <small class="ml-2 text-sm text-gray-600">{{ new Date(chirp.created_at).toLocaleString() }}</small>
                    <small v-if="chirp.created_at !== chirp.updated_at" class="text-sm text-gray-600"> &middot;
                        edited</small>
                </div>
                <Dropdown v-if="$page.props.auth.user.Is_Admin != null || chirp.user_id === $page.props.auth.user.id">
                    <template #trigger>
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path
                                    d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                            </svg>
                        </button>
                    </template>
                    <template #content>
                        <button
                            class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:bg-gray-100 transition duration-150 ease-in-out"
                            @click="editing = true">
                            Edit
                        </button>
                        <DropdownLink as="button"
                                      :href="route('chirps.destroy', chirp.id)" method="delete">
                            Delete
                        </DropdownLink>
                    </template>
                </Dropdown>
            </div>
            <form v-if="editing"
                  @submit.prevent="form.put(route('chirps.update', chirp.id), { onSuccess: () => editing = false })">
                <input v-model="form.title"
                       class="mt-4 w-full text-gray-900 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                       type="text">
                <textarea v-model="form.description"
                          class="mt-4 w-full text-gray-900 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
                <InputError :message="form.errors.message" class="mt-2"/>
                <div class="space-x-2">
                    <PrimaryButton class="mt-4">Save</PrimaryButton>
                    <button class="mt-4" @click="editing = false; form.reset(); form.clearErrors()">Cancel</button>
                </div>
            </form>
            <div v-else>
                <span class="mt-4 text-lg text-gray-900">{{ chirp.title }}</span>
                <p class="mt-4 text-lg text-gray-900">{{ chirp.description }}</p>
            </div>
            <form @submit.prevent="commentForm.post(route('comments.store'), { onSuccess: () => form.reset() })">
                <textarea
                    v-model="commentForm.message"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    placeholder="What's on your mind?"
                ></textarea>
                <PrimaryButton class="mt-4">Comment</PrimaryButton>
            </form>
            <div v-for="comment in comments" :key="comment.id">
                <div v-if="chirp.id == comment.chirp_id" class="bg-gray-50 mt-3">
                    <Dropdown v-if="$page.props.auth.user.Is_Admin != null || comment.user_id === $page.props.auth.user.id">
                        <template #trigger>
                            <button>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20"
                                     fill="currentColor">
                                    <path
                                        d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                </svg>
                            </button>
                        </template>
                        <template #content>
                            <DropdownLink as="button" :href="route('comments.destroy', comment.id)" method="delete">
                                Delete
                            </DropdownLink>
                        </template>
                    </Dropdown>
                    <span>{{ comment.user.name }}</span>
                    <p>{{ comment.message }}</p>
                </div>

            </div>
        </div>
    </div>
</template>
