<script setup>
import { ref } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/vue3";

const showingNavigationDropdown = ref(false);
</script>

<template>
  <div>
    <div class="min-h-screen bg-gray-100">
      <nav class="bg-gray border-b border-gray-100">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between h-16">
            <div class="flex">
              <!-- Logo -->
              <div class="shrink-0 flex items-center">
                <Link :href="route('dashboard')">
                  <ApplicationLogo
                    class="block h-9 w-auto fill-current text-gray-800"
                  />
                </Link>
              </div>

              <!-- Navigation Links -->
              <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <NavLink
                  :active="route().current('dashboard')"
                  :href="route('dashboard')"
                >
                  Dashboard
                </NavLink>
                <NavLink
                  :active="route().current('weather')"
                  :href="route('weather')"
                >
                  Weather
                </NavLink>
                <NavLink
                  :active="route().current('chirps.index')"
                  :href="route('chirps.index')"
                >
                  Chirps
                </NavLink>
                <NavLink
                  :active="route().current('gmaps')"
                  :href="route('gmaps')"
                >
                  Maps
                </NavLink>
                <NavLink
                  :active="route().current('ralf')"
                  :href="route('ralf')"
                >
                  Movies
                </NavLink>
                <NavLink
                  :active="route().current('products')"
                  :href="route('products')"
                >
                  Add Products
                </NavLink>
                <NavLink
                  :active="route().current('store')"
                  :href="route('store')"
                >
                  Store
                </NavLink>
                <NavLink
                  :active="route().current('cart')"
                  :href="route('cart')"
                >
                  Cart
                </NavLink>
              </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
              <!-- Settings Dropdown -->
              <div class="ml-3 relative">
                <Dropdown align="right" width="48">
                  <template #content>
                    <DropdownLink :href="route('profile.edit')">
                      Profile</DropdownLink
                    >
                    <DropdownLink
                      :href="route('logout')"
                      as="button"
                      method="post"
                    >
                      Log Out
                    </DropdownLink>
                  </template>
                </Dropdown>
              </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
              <button
                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                @click="showingNavigationDropdown = !showingNavigationDropdown"
              >
                <svg
                  class="h-6 w-6"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    :class="{
                      hidden: showingNavigationDropdown,
                      'inline-flex': !showingNavigationDropdown,
                    }"
                    d="M4 6h16M4 12h16M4 18h16"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                  />
                  <path
                    :class="{
                      hidden: !showingNavigationDropdown,
                      'inline-flex': showingNavigationDropdown,
                    }"
                    d="M6 18L18 6M6 6l12 12"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                  />
                </svg>
              </button>
            </div>
          </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div
          :class="{
            block: showingNavigationDropdown,
            hidden: !showingNavigationDropdown,
          }"
          class="sm:hidden"
        >
          <div class="pt-2 pb-3 space-y-1">
            <ResponsiveNavLink
              :active="route().current('dashboard')"
              :href="route('dashboard')"
            >
              Dashboard
            </ResponsiveNavLink>
            <ResponsiveNavLink
              :active="route().current('chirps.index')"
              :href="route('chirps.index')"
            >
              Chirps
            </ResponsiveNavLink>
          </div>

          <!-- Responsive Settings Options -->
        </div>
      </nav>

      <!-- Page Heading -->
      <header v-if="$slots.header" class="bg-gray shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <slot name="header" />
        </div>
      </header>

      <!-- Page Content -->
      <main>
        <slot />
      </main>
    </div>
  </div>
</template>
