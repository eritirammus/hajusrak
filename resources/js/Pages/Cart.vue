<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import GuestLayout from '@/Layouts/Layout.vue';

const props = defineProps({
    neko : {
        type: Object,
        default: null,
    }
})

</script>


<template>
    <GuestLayout>
        <div class="mx-10">
            <div class="w-full flex justify-between">
                <PrimaryButton class="mt-4"><a :href="route('neko.create')">Add neko</a></PrimaryButton>
            </div>
            <div v-for="item in neko">
                <!-- Card 2 -->
                <a href="#" class="w-[30rem] border-2 border-b-4 border-gray-200 rounded-xl hover:bg-gray-50">
                    <div class="grid grid-cols-6 p-5 gap-y-2">
                        <!-- Profile Picture -->
                        <div>
                            <img :src="item.image" alt="" class="max-w max-h rounded-md"/>
                        </div>

                        <!-- Description -->
                        <div class="col-span-5 md:col-span-4 ml-4">


                            <p class="text-sky-500 font-bold"> {{ item.title }} </p>
                            <p class="text-gray-600"> {{ item.description }} </p>
                            <div class="flex gap-3">
                                <p class="text-sky-500 font-bold text-xs"> Cuteness : {{ item.cuteness }} </p>
                                <p class="text-sky-500 font-bold text-xs"> Rating : {{ item.rating }} </p>
                            </div>

                        </div>
                    </div>

                </a>
            </div>
        </div>
    </GuestLayout>
</template>
