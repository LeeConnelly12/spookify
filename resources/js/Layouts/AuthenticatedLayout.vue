<script setup>
import Sidebar from '@/Components/Sidebar.vue'
import Player from '@/Components/Player.vue'
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import { vOnClickOutside } from '@vueuse/components'

const user = computed(() => usePage().props.auth.user)

const menu = ref(false)

const ignoreButton = ref(null)

const closeModal = [() => (menu.value = false), { ignore: [ignoreButton] }]
</script>

<template>
  <div class="grid min-h-screen grid-cols-[auto,1fr] grid-rows-[1fr,auto] pb-24">
    <Sidebar />
    <main class="bg-gradient-to-b from-[#222] to-[#121212] px-8 py-4">
      <div class="grid grid-cols-[max-content,max-content,1fr,max-content] items-center gap-4">
        <!-- Navigation arrows -->
        <button class="grid h-8 w-8 place-items-center rounded-full bg-black" type="button">
          <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
          </svg>
        </button>
        <button class="grid h-8 w-8 place-items-center rounded-full bg-black" type="button">
          <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
          </svg>
        </button>

        <!-- Profile dropdown -->
        <button v-if="user" @click="menu = !menu" ref="ignoreButton" type="button" class="relative col-start-4 flex h-8 items-center gap-2 rounded-full bg-black pr-2 leading-none">
          <div class="rounded-full border-2 border-black bg-[#535353] p-[2px]">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>
          </div>
          <p class="font-bold">{{ user.name }}</p>
          <svg class="h-4 w-4 transform" :class="{ 'rotate-180': menu }" viewBox="0 0 16 16">
            <path d="m14 6-6 6-6-6h12z" fill="white" />
          </svg>
          <ul v-if="menu" v-on-click-outside="closeModal" class="absolute right-0 top-full mt-2 grid justify-start rounded-md bg-gray-500 p-1 text-left text-sm shadow-md">
            <li>
              <Link href="/account" class="flex h-10 w-48 items-center justify-between px-3 hover:bg-gray-400">Account</Link>
            </li>
            <li>
              <Link href="/profile" class="flex h-10 w-48 items-center px-3 hover:bg-gray-400">Profile</Link>
            </li>
            <li>
              <Link href="/settings" class="flex h-10 w-48 items-center border-b border-b-white border-opacity-10 px-3 hover:bg-gray-400">Settings</Link>
            </li>
            <li>
              <Link href="/logout" method="post" as="button" class="flex h-10 w-48 items-center px-3 hover:bg-gray-400">Log out</Link>
            </li>
          </ul>
        </button>

        <div class="col-start-4 flex gap-8" v-else>
          <Link href="/register">Sign up</Link>
          <Link href="/login">Log in</Link>
        </div>
      </div>
      <slot />
    </main>
    <Player class="col-span-full" />
  </div>
</template>
