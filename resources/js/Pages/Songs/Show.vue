<script setup>
defineProps({
  song: Object,
})
</script>

<template>
  <div>song page</div>
  <img :src="song.medium_image" alt="" width="232" height="232" />
</template>
