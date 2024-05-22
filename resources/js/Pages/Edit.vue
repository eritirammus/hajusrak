<script setup>
import {useForm} from '@inertiajs/vue3'

const props = defineProps({
    marker: {
        type: Object,
        default: () => ({}),
    },
})
const Editform = useForm({
    id: props.marker.id,
    name: props.marker.name,
    lat: props.marker.lat,
    lng: props.marker.lng,
    description: props.marker.description
})
</script>
<template>
    <form class="text-xl font-bold text-gray-500" @submit.prevent="Editform.put(route('maps.update', props.marker.id))">
        <div class="p-2">
            <input v-model="Editform.name" class="p-5 text-xl border-gray-500 text-gray-500" type="text">
            <input v-model="Editform.lat" class="p-5 text-xl border-gray-500 text-gray-500" type="text">
            <input v-model="Editform.lng" class="p-5 text-xl border-gray-500 text-gray-500" type="text">
            <input v-model="Editform.description" class="p-5 text-xl border-gray-500 text-gray-500" type="text">
            <button :disabled="Editform.processing" class="p-5 text-gray-500" type="submit">Submit</button>
        </div>

    </form>
</template>
