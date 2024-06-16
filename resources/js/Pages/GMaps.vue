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
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- <div id="map" class="h-96 rounded-md border-2 border-grat-200"></div> -->
                <!-- <Radar ref="radar" @location-selected="updateLocation" @markerPoints="setMarkerPoints" /> -->
                <Radar ref="radar" @location-selected="updateLocation" />

                <div v-if="editMode == false" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2 mt-2">
                    <form @submit.prevent="addPoint" class="flex flex-col gap-2">
                        <input v-model="name" type="text" step="any" placeholder="Name"
                            class="rounded border-2 border-gray-200">
                        <textarea v-model="description" name="description" id="description" cols="30" rows="4"
                            placeholder="Description" class="rounded border-2 border-gray-200 resize-none"></textarea>
                        <input v-model="newPoint.lat" type="number" step="any" placeholder="Latitude"
                            class="rounded border-2 border-gray-200">
                        <input v-model="newPoint.lng" type="number" step="any" placeholder="Longitude"
                            class="rounded border-2 border-gray-200">
                        <button type="submit" class="rounded border-2 border-gray-200 px-4 py-2 ">Add Point</button>
                    </form>
                </div>
                <div v-else class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2 mt-2">
                    <p class="py-2 text-gray-400 font-bold">EDIT MODE ENABLED</p>
                    <form @submit.prevent="updateMarker" class="flex flex-col gap-2">
                        <input v-model="name" type="text" step="any" placeholder="Name"
                            class="rounded border-2 border-gray-200">
                        <textarea v-model="description" name="description" id="description" cols="30" rows="4"
                            placeholder="Description" class="rounded border-2 border-gray-200 resize-none"></textarea>
                        <input v-model="newPoint.lat" type="number" step="any" placeholder="Latitude"
                            class="rounded border-2 border-gray-200">
                        <input v-model="newPoint.lng" type="number" step="any" placeholder="Longitude"
                            class="rounded border-2 border-gray-200">
                        <button type="submit" class="rounded border-2 border-gray-200 px-4 py-2 ">Edit marker</button>
                    </form>
                </div>
                <div v-for="marker in mapPoints" :key="marker.id"
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2 mt-2 flex">
                    <div class="w-full flex flex-col justify-center ">
                        <h2 class="text-lg font-bold">{{ marker.name }}</h2>
                        <p v-if="marker.description" class="text-sm">{{ marker.description }}</p>
                    </div>
                    <div class="w-fit flex gap-2">
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

        // setMarkerPoints(points) {
        //     this.mapPoints = [];
        //     this.mapPoints = points;
        //     console.log(points);
        // },

        updateLocation(location) {
            this.newPoint.lat = location.lat;
            this.newPoint.lng = location.lng;
        },

        async addPoint() {
            // Make a POST request to your API to save the new point's coordinates
            await axios.post('/api/google-maps/markers', {
                name: this.name,
                description: this.description,
                lat: this.newPoint.lat,
                lng: this.newPoint.lng,
            });

            // Clear the form
            this.newPoint = { lat: null, lng: null };
            this.name = '';
            this.description = '';

            // Load the markers
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
            // Make a PUT request to your API to update the point with the specified latitude and longitude
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
                    // Clear the form
                    this.newPoint = { lat: null, lng: null };
                    this.name = '';
                    this.description = '';
                    this.editMode = false;

                    // Load the markers
                    this.$refs.radar.clearMarkers();
                    this.$refs.radar.loadMarkers();

                    this.fetchMarkers();
                })
                .catch((error) => {
                    console.error(error);
                });


        },

        async deletePoint(id) {
            // Make a DELETE request to your API to delete the point with the specified latitude and longitude
            await axios.delete(`/api/google-maps/markers/${id}`);

            // Remove the point from the mapPoints array
            this.$refs.radar.clearMarkers();
            this.$refs.radar.loadMarkers();

            this.fetchMarkers();
        },
    },
    mounted() {
        // Executes the fetchData method when the component is mounted.
        // this.fetchData();
        this.fetchMarkers();
    },
};
</script>