<script setup>
import { Head } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/Layout.vue";

const props = defineProps({
  weather: {
    type: Object,
    default: null,
  },
});

function timeConverter(UNIX_timestamp) {
  var a = new Date(UNIX_timestamp * 1000);
  var months = [
    "Jan",
    "Feb",
    "Mar",
    "Apr",
    "May",
    "Jun",
    "Jul",
    "Aug",
    "Sep",
    "Oct",
    "Nov",
    "Dec",
  ];
  var year = a.getFullYear();
  var month = months[a.getMonth()];
  var date = a.getDate();
  var hour = a.getHours();
  var min = a.getMinutes();
  var sec = a.getSeconds();
  var time =
    date + " " + month + " " + year + " " + hour + ":" + min + ":" + sec;
  return time;
}

console.log(timeConverter(props.weather.dt));
console.log(props.weather);
console.log(props.weather.weather[0].icon);
</script>
<template>
  <Head title="Weather" />
  <GuestLayout>
    <div
      class="flex flex-col items-center justify-center bg-gray-200 dark:bg-gray-950 min-h-screen bg-center selection:bg-gray-950 selection:text-gray-800"
    >
      <span>Location: {{ weather.name }} maakond</span>
      <span>Date and time: {{ timeConverter(weather.dt) }}</span>
      <span>Wind speed: {{ weather.wind.speed }} m/s</span>
      <span>Temperature: {{ weather.main.temp }}°C</span>
      <span>Current conditions: {{ weather.weather[0].description }}</span>
      <img
        class="w-20 h-20 fill-current text-gray-500"
        :src="
          'https://openweathermap.org/img/wn/' +
          weather.weather[0].icon +
          '.png'
        "
        alt=""
      />
    </div>
  </GuestLayout>
</template>
