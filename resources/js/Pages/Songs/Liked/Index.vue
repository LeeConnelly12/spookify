<script setup>
defineProps({
  songs: Array,
})
</script>

<template>
  <div>liked songs page</div>
  <ul>
    <li v-for="song in songs" :key="song.id">
      <p>{{ song.name }}</p>
    </li>
  </ul>
</template>
