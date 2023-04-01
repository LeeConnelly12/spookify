<script setup>
import { usePage } from '@inertiajs/vue3'
import { computed } from '@vue/reactivity'
import axios from 'axios'

defineProps({
  songs: Array,
})

const user = computed(() => usePage().props.auth.user)

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
  <div>songs page</div>
  <ul>
    <li v-for="song in songs" :key="song.id" class="flex gap-4">
      <p>{{ song.name }}</p>
      <p>{{ song.artist.name }}</p>
      <button
        v-if="user"
        @click="song.liked === false ? like(song) : unlike(song)"
        class="px-2 bg-green-200"
      >
        like
      </button>
    </li>
  </ul>
</template>
