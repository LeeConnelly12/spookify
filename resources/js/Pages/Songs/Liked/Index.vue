<script setup>
import Song from '@/Components/Song.vue'

defineProps({
  songs: Array,
})

function play(song) {
    console.log('playing song')
}
</script>

<template>
  <div class="px-4 pt-16 bg-gradient-to-b from-[#202E6D] to-[#121212] from-5% to-20% bg-no-repeat">
    <h1 class="text-2xl font-bold">Liked Songs</h1>
    <p class="mt-1 text-sm text-gray-400">{{ songs.length }} songs</p>
    <button class="grid w-12 h-12 mt-1 ml-auto bg-green-500 rounded-full place-items-center" type="button">
      <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="none" class="w-7 h-7 fill-[#121212]">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
      </svg>
    </button>
  </div>
  <ul class="grid gap-2 px-2 mt-4">
    <Song v-for="song in songs" @play="play(song)" :key="song.id" :song="song" />
  </ul>
</template>
