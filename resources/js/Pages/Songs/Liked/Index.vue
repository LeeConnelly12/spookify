<script setup>
import Layout from '@/Layouts/AuthenticatedLayout.vue'
import { computed } from 'vue'
import { usePage, Link } from '@inertiajs/vue3'
import SongsTable from '@/Components/SongsTable.vue'

defineProps({
  songs: Array,
})

const user = computed(() => usePage().props.auth.user)
</script>

<template>
  <Layout>
    <header class="mt-10 flex items-end gap-6">
      <div class="group relative grid h-48 w-48 flex-shrink-0 place-items-center bg-gray-500 text-gray-600 shadow-md xl:h-[14.5rem] xl:w-[14.5rem]">
        <svg viewBox="0 0 24 24" fill="currentColor" class="h-20 w-20">
          <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
        </svg>
      </div>
      <div>
        <p class="text-sm font-bold">Playlist</p>
        <h1 class="mt-2 text-2xl font-bold md:text-4xl xl:mt-4 xl:text-8xl">Liked Songs</h1>
        <div class="mt-4 flex items-center gap-2 xl:mt-10">
          <Link :href="route('users.show', user)" class="inline-block text-sm font-bold hover:underline">{{ user.name }}</Link>
          <div v-if="songs.length" class="h-1 w-1 rounded-full bg-white"></div>
          <p v-if="songs.length">{{ songs.length }} song{{ songs.length > 1 ? 's' : '' }}</p>
        </div>
      </div>
    </header>

    <SongsTable :songs="songs" />
  </Layout>
</template>
