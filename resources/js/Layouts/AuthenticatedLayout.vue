<script setup>
import Sidebar from '@/Components/Sidebar.vue'
import Player from '@/Components/Player.vue'
</script>

<template>
  <div class="grid h-screen grid-cols-[auto,1fr] grid-rows-[1fr,auto]">
    <Sidebar />
    <main class="bg-gradient-to-b from-[#222] to-[#121212] px-8 py-4">
      <slot />
    </main>
    <Player class="col-span-full" />
  </div>
</template>
