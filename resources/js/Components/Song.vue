<script setup>
import axios from 'axios'

defineProps({
  song: Object,
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
  <article class="grid grid-cols-[auto,1fr,auto,auto] items-center gap-3 overflow-hidden rounded-md bg-gray-500 pr-4">
    <button @click="$emit('play')" class="relative grid place-items-center" type="button">
      <img :src="song.small_image" width="65" height="65" :alt="`Cover image for ${song.name}`" />
      <svg fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="none" class="absolute w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
      </svg>
    </button>
    <div>
      <p class="line-clamp-1">{{ song.name }}</p>
      <p class="line-clamp-1 opacity-60">{{ song.artist.name }}</p>
    </div>
    <button @click="!song.liked ? like(song) : unlike(song)" type="button">
      <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5" class="w-6 h-6" :class="song.liked ? 'fill-green-500' : 'stroke-gray-400'">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
      </svg>
    </button>
    <menu class="cursor-pointer">
      <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 opacity-60">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
      </svg>
    </menu>
  </article>
</template>
