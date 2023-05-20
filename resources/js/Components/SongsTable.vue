<script setup>
import Song from '@/Components/Song.vue'

defineProps({
  songs: Array,
})
</script>

<template>
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
      <Song v-for="(song, index) in songs" :key="song.id" :index="index" :song="song" />
    </tbody>
  </table>
</template>
