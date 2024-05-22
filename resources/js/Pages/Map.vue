<script setup>
import {useForm} from '@inertiajs/vue3'
import DangerButton from '../Components/DangerButton.vue';

import EditForm from './Edit.vue'
import GuestLayout from '@/Layouts/Layout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    markers: {
        type: Object,
        default: () => ({}),
    },
})
console.log(props.markers)
const form = useForm({
    name: null,
    lat: null,
    lng: null,
    description: null
})

const formDel = useForm({});

function mark(event) {
    form.lat = event.latLng.lat()
    form.lng = event.latLng.lng()

}

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        formDel.delete(route('maps.destroy', id));
    }
}

</script>

<template>
    <GuestLayout>
        <GMapMap id="vue-map" ref="myMapRef" :center="center" :zoom="10" map-type-id="terrain"
                 style="width: 100vw; height: 40rem" @click="mark">
            <GMapMarker v-for="marker in markers" :key="marker.id" :clickable="true"
                        :position="{lat:marker.lat, lng:marker.lng}"
                        @click="openMarker(marker.id)">
                <GMapInfoWindow
                    :closeclick="true"
                    :opened="openedMarkerID === marker.id"
                    @closeclick="openMarker(null)"
                >
                    <div><span>{{ marker.name }}</span>
                        <p>{{ marker.description }}</p>
                    </div>
                    <DangerButton @click="destroy(marker.id)">DELETE</DangerButton>
                    <EditForm :marker=marker></EditForm>
                </GMapInfoWindow>
            </GMapMarker>
            <GMapMarker :position="{lat:form.lat, lng:form.lng}">
            </GMapMarker>
        </GMapMap>
        <form @submit.prevent="form.post('/add-marker')">
            <div class="flex items-center text-center fill-black bg-materialgreenbg p-6 text-2xl justify-center">

                <div class="p-2">
                    <InputLabel for="name" value="Name"/>
                    <TextInput id="name" v-model="form.name" type="text"></TextInput>
                </div>
                <div class="p-2">
                    <InputLabel for="description" value="Description"/>
                    <TextInput id="description" v-model="form.description" type="text"></TextInput>
                </div>

                <div class="p-2">
                    <InputLabel for="lat" value="Latitude"/>
                    <TextInput id="lat" v-model="form.lat" type="text"></TextInput>
                </div>
                <div class="p-2">
                    <InputLabel for="lng" value="Longitude"/>
                    <TextInput id="lng" v-model="form.lng" type="text"></TextInput>
                </div>


            </div>


            <div class="flex p-6 justify-center items-center">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="ml-4">
                    Add marker
                </PrimaryButton>

            </div>
        </form>
    </GuestLayout>
</template>

<script>
export default {
    data() {
        return {
            openedMarkerID: null,
            center: {lat: 58.2449205980223, lng: 22.496933575606914},

        };
    },
    methods: {
        openMarker(id) {
            this.openedMarkerID = id
        },

    }
};
</script>
