<script setup>
import Layout from '@/Layouts/AuthenticatedLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import { vOnClickOutside } from '@vueuse/components'
import axios from 'axios'

const props = defineProps({
  playlist: Object,
})

const menu = ref(false)

const ignoreOptions = ref(null)

const closeModal = [() => (menu.value = false), { ignore: [ignoreOptions] }]

const form = useForm({
  image: null,
})

async function submit(event) {
  form.image = event.target.files[0]
  form.post(route('playlists.images.store', props.playlist), {
    only: ['playlist'],
  })
}
</script>

<template>
  <Layout>
    <div class="flex items-end gap-6 pt-10">
      <div class="group relative grid h-48 w-48 flex-shrink-0 place-items-center bg-gray-500 text-gray-600 shadow-md xl:h-[14.5rem] xl:w-[14.5rem]">
        <img v-if="playlist.image" :src="playlist.image" alt="" />
        <svg v-else fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-14 w-14">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z" />
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
      <div class="font-bold">
        <p>Playlist</p>
        <h1 class="mt-2 text-2xl md:text-4xl xl:mt-4 xl:text-8xl">{{ playlist.name }}</h1>
        <p class="mt-4 xl:mt-6">{{ playlist.user.name }}</p>
      </div>
    </div>
    <div class="mt-6 flex items-center gap-8">
      <button type="button" class="grid h-14 w-14 transform place-items-center rounded-full bg-green-500 hover:scale-105 hover:bg-green-400">
        <svg viewBox="0 0 20 20" fill="currentColor" class="h-7 w-7 text-black">
          <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" />
        </svg>
      </button>
      <button @click="menu = !menu" ref="ignoreOptions" type="button" class="relative">
        <svg viewBox="0 0 20 20" fill="currentColor" class="h-8 w-8 text-gray-600 hover:text-white">
          <path d="M3 10a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM8.5 10a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM15.5 8.5a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" />
        </svg>
        <ul v-if="menu" v-on-click-outside="closeModal" class="absolute left-0 top-full mt-2 grid justify-start rounded-md bg-gray-500 p-1 text-left text-sm shadow-md">
          <li>
            <Link :href="route('playlists.destroy', playlist)" method="delete" as="button" class="flex h-10 w-48 items-center px-3 hover:bg-gray-400">Delete</Link>
          </li>
        </ul>
      </button>
    </div>

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
        <tr v-for="(song, index) in playlist.songs" class="bg-gray-100 bg-opacity-0 hover:bg-opacity-10">
          <th scope="row" class="whitespace-nowrap py-4 pl-6 font-medium">
            {{ index + 1 }}
          </th>
          <td class="py-4 pl-2 pr-6">
            <p class="text-white">{{ song.name }}</p>
            <p class="text-sm">{{ song.artist.name }}</p>
          </td>
          <td class="line-clamp-1 px-6 py-4 text-sm">
            <Link :href="route('albums.show', song.album)">{{ song.album.name }}</Link>
          </td>
          <td class="px-6 py-4 text-sm">3 days ago</td>
          <td class="px-6 py-4 text-sm">{{ song.duration }}</td>
        </tr>
      </tbody>
    </table>
  </Layout>
</template>
