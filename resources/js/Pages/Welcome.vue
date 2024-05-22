<script setup>
import {Head, Link} from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template class="">
    <Head title="Welcome"/>
    <div
        class="relative bg-gray-200 dark:bg-gray-950 justify-center bg-cover grid justify-items-center items-center min-h-screen bg-center selection:bg-gray-950 selection:text-gray-800">
        <div>
            <h1 class="">
                Hajusrakendused
            </h1>

            <div>
                 <Link :href="route('login')">
                    Login
                </Link>
                <br>
            </div>
            <div>
                <Link :href="route('register')">
                    Register
                </Link>
                <br>
            </div>
        </div>

    </div>


</template>
