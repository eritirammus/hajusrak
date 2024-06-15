<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import GuestLayout from '@/Layouts/Layout.vue';


</script>


<template>
    <AuthenticatedLayout>
        <div class="flex justify-center self-center p-5 w-2/2">
            <div class="p-12 bg-white mx-auto rounded-3xl w-96">
                <div class="mb-7">
                    <h3 class="font-semibold text-2xl text-gray-800">Cart</h3>
                </div>
                <div class="space-y-6">
                    <div>
                        <p>Cart is empty</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
