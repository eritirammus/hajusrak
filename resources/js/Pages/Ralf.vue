<script setup>
import {Head} from "@inertiajs/vue3";
import GuestLayout from '@/Layouts/Layout.vue';

const props = defineProps({
    ralf: {
        type: Object,
        default: null,
    }
})


console.log(props.ralf)
</script>
<template>
    <Head title="Movies"/>
    <GuestLayout>
        <div class="p-5"></div>

        <div v-for="item in ralf.data" :key="item.id" class="flex pb-4 w-full px-32">
            <div class="w-[10%] pr-2">
                <img :src="item.image" alt="" class="">
            </div>

            <div class="w-[75%]">
                <span class="font-bold text-3xl text-gray-500">{{ item.title }}</span>
                <p class="font-bold text-lg ">{{ item.description }}</p>
                <span class="font-bold text-2xl text-gray-600">{{ item.movie_rating }}/10</span>
            </div>

        </div>
    </GuestLayout>
</template>
