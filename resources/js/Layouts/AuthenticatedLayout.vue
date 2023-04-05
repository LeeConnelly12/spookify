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

function closeModal() {
  menu.value = false
}
</script>

<template>
  <div class="grid h-screen grid-cols-[auto,1fr] grid-rows-[1fr,auto]">
    <Sidebar />
    <main class="bg-gradient-to-b from-[#222] to-[#121212] px-8 py-4">
      <div class="grid grid-cols-[max-content,max-content,1fr,max-content] items-center gap-4">
        <button class="grid w-8 h-8 bg-black rounded-full place-items-center" type="button">
          <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
          </svg>
        </button>
        <button class="grid w-8 h-8 bg-black rounded-full place-items-center" type="button">
          <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
          </svg>
        </button>
        <button v-if="user" @click="menu = !menu" type="button" class="relative flex items-center h-8 col-start-4 gap-2 pr-2 leading-none bg-black rounded-full">
          <div class="rounded-full border-2 border-black bg-[#535353] p-[2px]">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>
          </div>
          <p class="font-bold">{{ user.name }}</p>
          <svg class="w-4 h-4 transform" :class="{ 'rotate-180': menu }" viewBox="0 0 16 16">
            <path d="m14 6-6 6-6-6h12z" fill="white" />
          </svg>
          <ul v-if="menu" v-on-click-outside="closeModal" class="absolute right-0 grid justify-start p-1 mt-2 text-sm text-left bg-gray-500 rounded-md shadow-md top-full">
            <li>
              <Link href="/account" class="flex items-center justify-between w-48 h-10 px-3 hover:bg-gray-400">Account</Link>
            </li>
            <li>
              <Link href="/profile" class="flex items-center w-48 h-10 px-3 hover:bg-gray-400">Profile</Link>
            </li>
            <li>
              <Link href="/settings" class="flex items-center w-48 h-10 px-3 border-b border-b-white border-opacity-10 hover:bg-gray-400">Settings</Link>
            </li>
            <li>
              <Link href="/logout" method="post" as="button" class="flex items-center w-48 h-10 px-3 hover:bg-gray-400">Log out</Link>
            </li>
          </ul>
        </button>
        <div class="flex col-start-4 gap-8" v-else>
            <Link href="/register">Sign up</Link>
            <Link href="/login">Log in</Link>
        </div>
      </div>
      <slot />
    </main>
    <Player class="col-span-full" />
  </div>
</template>
