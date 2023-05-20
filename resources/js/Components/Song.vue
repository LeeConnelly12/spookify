<script setup>
import { Link } from '@inertiajs/vue3'
import axios from 'axios'

defineProps({
  song: Object,
  index: Number,
})

const emit = defineEmits(['play'])

async function like(song) {
  await axios.put(route('liked-songs.update', song))
  song.liked = true
}

async function unlike(song) {
  await axios.delete(route('liked-songs.destroy', song))
  song.liked = false
}
</script>

<template>
  <tr class="group bg-gray-100 bg-opacity-0 hover:bg-opacity-10">
    <th scope="row" class="whitespace-nowrap py-4 pl-6 font-medium">
      {{ index + 1 }}
    </th>
    <td class="h-16 pl-2 pr-6">
      <p class="text-white">{{ song.name }}</p>
      <p class="text-sm">{{ song.artist.name }}</p>
    </td>
    <td class="line-clamp-1 flex h-16 items-center px-6 text-sm">
      <Link :href="route('albums.show', song.album)">{{ song.album.name }}</Link>
    </td>
    <td class="h-16 px-6 text-sm">{{ song.added }}</td>
    <td class="relative flex h-16 items-center px-6 text-sm">
      <button @click="!song.liked ? like(song) : unlike(song)" type="button" class="absolute -left-5 group-hover:block" :class="song.liked ? '' : 'hidden'">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5" class="h-6 w-6" :class="song.liked ? 'fill-green-500' : 'stroke-white'">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
        </svg>
      </button>
      <p>{{ song.duration }}</p>
    </td>
  </tr>
</template>
