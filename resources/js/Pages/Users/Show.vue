<script setup>
import Layout from '@/Layouts/AuthenticatedLayout.vue'
import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const user = computed(() => usePage().props.auth.user)
</script>

<template>
  <Layout>
    <header class="mt-10 flex items-end gap-6">
      <div class="group relative grid h-48 w-48 flex-shrink-0 place-items-center overflow-hidden rounded-full bg-gray-500 text-gray-600 shadow-md xl:h-[14.5rem] xl:w-[14.5rem]">
        <img v-if="user.profile_picture" :src="user.profile_picture" alt="" />
        <svg v-else fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
        </svg>
        <label class="absolute inset-0 hidden place-items-center bg-black bg-opacity-60 text-center text-white group-hover:grid" for="playlistImage">
          <div>
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto h-12 w-12">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
            </svg>
            <p>Choose photo</p>
          </div>
        </label>
        <input type="file" @input="submit" class="hidden" id="playlistImage" />
      </div>
      <div>
        <p class="text-sm font-bold">Profile</p>
        <h1 class="mt-2 text-2xl font-bold md:text-4xl xl:mt-4 xl:text-8xl">{{ user.name }}</h1>
        <div class="mt-4 flex items-center gap-2 text-sm xl:mt-10">
          <p v-if="user.playlists.length">{{ user.playlists.length }} Public Playlist {{ user.playlists.length > 1 ? 's' : '' }}</p>
        </div>
      </div>
    </header>
  </Layout>
</template>
