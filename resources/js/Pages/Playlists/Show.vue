<script setup>
import Layout from '@/Layouts/AuthenticatedLayout.vue'
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import { vOnClickOutside } from '@vueuse/components'

defineProps({
  playlist: Object,
})

const menu = ref(false)

const ignoreOptions = ref(null)

const closeModal = [() => (menu.value = false), { ignore: [ignoreOptions] }]
</script>

<template>
  <Layout>
    <div class="flex items-end gap-6 pt-10">
      <div class="grid h-48 w-48 flex-shrink-0 place-items-center bg-gray-500 text-gray-600 shadow-md xl:h-60 xl:w-60">
        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-14 w-14">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z" />
        </svg>
      </div>
      <div class="font-bold">
        <p>Playlist</p>
        <h1 class="mt-2 text-2xl md:text-4xl xl:mt-4 xl:text-8xl">{{ playlist.name }}</h1>
        <p class="mt-4 xl:mt-6">{{ playlist.user.name }}</p>
      </div>
    </div>
    <button @click="menu = !menu" ref="ignoreOptions" type="button" class="relative pt-4">
      <svg viewBox="0 0 20 20" fill="currentColor" class="h-8 w-8 text-gray-600 hover:text-white">
        <path d="M3 10a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM8.5 10a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM15.5 8.5a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" />
      </svg>
      <ul v-if="menu" v-on-click-outside="closeModal" class="absolute left-0 top-full mt-2 grid justify-start rounded-md bg-gray-500 p-1 text-left text-sm shadow-md">
        <li>
          <Link :href="route('playlists.destroy', playlist)" method="delete" as="button" class="flex h-10 w-48 items-center px-3 hover:bg-gray-400">Delete</Link>
        </li>
      </ul>
    </button>

    <table class="mt-4 w-full text-left text-gray-300">
      <thead class="border-b border-white border-opacity-10 text-sm">
        <tr>
          <th scope="col" class="w-12 py-3 pl-6">#</th>
          <th scope="col" class="py-3 pl-2 pr-6 font-normal">Title</th>
          <th scope="col" class="px-6 py-3 font-normal">Album</th>
          <th scope="col" class="px-6 py-3 font-normal">Date added</th>
          <th scope="col" class="px-6 py-3 font-normal">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="song in playlist.songs">
          <th scope="row" class="whitespace-nowrap py-4 pl-6 font-medium">
            {{ song.id }}
          </th>
          <td class="py-4 pl-2 pr-6">
            <p class="text-white">{{ song.name }}</p>
            <p class="text-sm">{{ song.artist.name }}</p>
          </td>
          <td class="px-6 py-4 text-sm">Rebola</td>
          <td class="px-6 py-4 text-sm">3 days ago</td>
          <td class="px-6 py-4 text-sm">{{ song.duration }}</td>
        </tr>
      </tbody>
    </table>
  </Layout>
</template>
