<template>
  <div class="flex items-center min-h-screen bg-white min-w-screen sm:pt-0 bg-cover bg-center flex-row-reverse;">
    <video
      autoplay
      class="flex-1 object-cover  min-h-full top-0 "
      loop
      muted
      playsinline
      src="/Untitled 1-4.mov"
      type="video/mp4"
    />
    <div
      class="px-6 py-4 overflow-hidden bg-white h-screen shadow-md sm:max-w-md sm:rounded-lg flex-none w-3/4"
    >
      <router-view />
    </div>
  </div>
</template>
<script lang="ts" setup>
</script>
