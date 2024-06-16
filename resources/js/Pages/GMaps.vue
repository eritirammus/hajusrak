<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { data } from 'autoprefixer';
import axios from 'axios';
import moment from 'moment';
import { Loader } from "@googlemaps/js-api-loader"
import Radar from '@/Pages/Radar.vue';
</script>

<template>

    <Head title="© Google maps" />

    <AuthenticatedLayout>
        
        <div class="py-12">
            <div class="sm:px-6 lg:px-8 flex flex-wrap">
                <Radar ref="radar" class="w-1/2" @location-selected="updateLocation" />

                <div v-if="editMode == false" class="bg-white overflow-hidden sm:rounded-sm pl-4 w-1/2 flex items-center">
                    <form @submit.prevent="addPoint" class="flex flex-col gap-2">
                        <input v-model="name" type="text" step="any" placeholder="Name"
                            class="rounded border-2 border-black">
                        <textarea v-model="description" name="description" id="description" cols="40" rows="6"
                            placeholder="Description" class="rounded border-2 border-black resize-none"></textarea>
                        <input v-model="newPoint.lat" type="number" step="any" placeholder="Latitude"
                            class="rounded border-2 border-black">
                        <input v-model="newPoint.lng" type="number" step="any" placeholder="Longitude"
                            class="rounded border-2 border-black">
                        <button type="submit" class="rounded border-2 border-black px-4 py-2 ">Add Point</button>
                    </form>
                </div>
                <div v-else class="bg-white overflow-hidden sm:rounded-sm pl-4 w-1/2 flex items-center">
                    <form @submit.prevent="updateMarker" class="flex flex-col gap-2">
                        <input v-model="name" type="text" step="any" placeholder="Name"
                            class="rounded border-2 border-gray-400">
                        <textarea v-model="description" name="description" id="description" cols="40" rows="6"
                            placeholder="Description" class="rounded border-2 border-gray-400 resize-none"></textarea>
                        <input v-model="newPoint.lat" type="number" step="any" placeholder="Latitude"
                            class="rounded border-2 border-gray-400">
                        <input v-model="newPoint.lng" type="number" step="any" placeholder="Longitude"
                            class="rounded border-2 border-gray-400">
                        <button type="submit" class="rounded border-2 border-gray-400 px-4 py-2 ">Update</button>
                    </form>
                </div>
                <div v-for="marker in mapPoints" :key="marker.id"
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2 mt-2 flex">
                    <div class="w-full flex flex-col justify-center ">
                        <h2 class="text-xl font-bold">{{ marker.name }}</h2>
                        <p v-if="marker.description" class="text-lg">{{ marker.description }}</p>
                    </div>
                    <div class="flex flex-row p-4 gap-2">
                        <button @click="focusOnMarker(marker.lat, marker.lng)"
                            class="w-fit p-2 border-2 border-gray-200 rounded" type="submit">Focus</button>
                        <button @click="editMarker(marker)" class="w-fit px-4 py-2 border-2 border-gray-200 rounded"
                            type="submit">Edit</button>
                        <button @click="deletePoint(marker.id)" class="w-fit px-4 py-2 border-2 border-red-500 rounded"
                            type="submit">Delete</button>
                        
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
export default {
    data() {
        return {
            ApiData: [],
            lastUpdated: 0,
            script: null,
            map: null,
            newPoint: {
                lat: null,
                lng: null,
            },
            name: '',
            description: '',
            mapPoints: [],
            editMode: false,
            editMarkerId: null,
        };
    },
    methods: {

        fetchMarkers() {
            axios
                .get('/api/google-maps/markers')
                .then((response) => {
                    this.mapPoints = response.data.markers;
                    console.log(this.mapPoints);
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        focusOnMarker(lat, lng) {
            this.$refs.radar.focusOnPoint(lat, lng);
        },

        updateLocation(location) {
            this.newPoint.lat = location.lat;
            this.newPoint.lng = location.lng;
        },

        async addPoint() {
            await axios.post('/api/google-maps/markers', {
                name: this.name,
                description: this.description,
                lat: this.newPoint.lat,
                lng: this.newPoint.lng,
            });

            this.newPoint = { lat: null, lng: null };
            this.name = '';
            this.description = '';

            this.$refs.radar.loadMarkers();

            this.fetchMarkers();
        },

        editMarker(marker) {
            this.editMode = true;
            this.newPoint.lat = marker.lat;
            this.newPoint.lng = marker.lng;
            this.name = marker.name;
            this.description = marker.description;
            this.editMarkerId = marker.id;
        },

        updateMarker() {
            axios.put(`/api/google-maps/markers/${this.editMarkerId}`, {
                name: this.name,
                description: this.description,
                lat: this.newPoint.lat,
                lng: this.newPoint.lng,
                headers: {
                    'Content-Type': 'application/json',
                    'accept': 'application/json',
                },
            })
                .then(() => {
                    this.newPoint = { lat: null, lng: null };
                    this.name = '';
                    this.description = '';
                    this.editMode = false;

                    this.$refs.radar.clearMarkers();
                    this.$refs.radar.loadMarkers();

                    this.fetchMarkers();
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        async deletePoint(id) {
            await axios.delete(`/api/google-maps/markers/${id}`);

            this.$refs.radar.clearMarkers();
            this.$refs.radar.loadMarkers();

            this.fetchMarkers();
        },
    },
    mounted() {
        this.fetchMarkers();
    },
};
</script>
