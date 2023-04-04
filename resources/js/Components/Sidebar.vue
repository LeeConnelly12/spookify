<script setup>
import { Link } from '@inertiajs/vue3'
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

const user = computed(() => usePage().props.auth.user)
</script>

<template>
  <aside class="w-64 bg-black py-6 pl-6">
    <nav class="grid text-sm">
      <Link href="/" class="text-2xl font-bold">Spookify</Link>
      <div class="mt-6 font-bold">
        <Link href="/" :class="route().current('home') ? 'opacity-100' : 'opacity-70'" class="flex h-10 items-center gap-4 transition-opacity duration-300 hover:opacity-100">
          <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-7 w-7">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
          </svg>
          Home
        </Link>
        <Link href="/search" class="flex h-10 items-center gap-4 opacity-70 transition-opacity duration-300 hover:opacity-100">
          <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-7 w-7">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
          </svg>
          Search
        </Link>
        <Link href="/playlists" class="flex h-10 items-center gap-4 opacity-70 transition-opacity duration-300 hover:opacity-100">
          <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-7 w-7">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
          </svg>
          Your Library
        </Link>
      </div>
      <div class="mt-6 font-bold">
        <Link href="/playlists" method="post" as="button" type="button" class="flex h-10 w-full items-center gap-4 opacity-70 transition-opacity duration-300 hover:opacity-100">
          <div class="grid h-6 w-6 place-items-center rounded-sm bg-white">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000" class="h-4 w-4">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
          </div>
          Create Playlist
        </Link>
        <Link href="/songs" :class="route().current('songs') ? 'opacity-100' : 'opacity-70'" class="flex h-10 items-center gap-4 transition-opacity duration-300 hover:opacity-100">
          <svg viewBox="0 0 24 24" fill="currentColor" class="h-7 w-7">
            <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
          </svg>

          Liked Songs
        </Link>
      </div>
      <div v-if="user.playlists.length > 0" class="mt-2 border-t border-t-[#282828] pt-1">
        <Link v-for="playlist in user.playlists" :key="playlist.id" :href="route('playlists.show', playlist)" :class="route().current('playlists.show', playlist) ? 'opacity-100' : 'opacity-70'" class="flex h-8 w-full items-center transition-opacity duration-300 hover:opacity-100">
          {{ playlist.name }}
        </Link>
      </div>
    </nav>
  </aside>
</template>
