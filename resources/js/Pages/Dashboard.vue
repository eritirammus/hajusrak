<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
</script>

<template>
  <Head title="Welcome" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-5xl text-gray-800 leading-tight">
        Hajusrakendused
      </h2>
    </template>

    <div class="lg:py-12">
        <div class="flex items-center lg:max-w-7xl mx-auto">
            <div class="h-fit bg-white divide-solid shadow-sm sm:rounded-lg">
                <div class="flex flex-col lg:flex-row lg:text-2xl text-base justify-between text-left">
                    <ApplicationLogo class="lg:m-8 lg:w-96 lg:h-96 h-64 w-full lg:rounded-lg object-cover"/>
                    <div class="px-4 lg:pt-8 pt-4 space-y-4 ">  
                        <p>Welcome! This is hajusrakendused, a project with multiple features. It is designed to provide a comprehensive solution for building distributed applications. With hajusrakendused, you can easily develop and manage various components and services that work together to create a seamless user experience. Whether you need to handle complex data processing, real-time communication, or scalable infrastructure, hajusrakendused has got you covered. Start exploring the possibilities and unleash the power of distributed application development!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </AuthenticatedLayout>
</template>
