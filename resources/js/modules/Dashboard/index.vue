<script setup lang="ts">
import { computed } from 'vue'
import { useGlobalStore } from '@/stores/GlobalStore'

const globalStore = useGlobalStore()
const user = computed(() => globalStore.getUser)

</script>
<template>
  <div class="p-12 text-lg font-medium container">
    <div>Willkommen zurück, {{ user?.first_name }}!</div>
  </div>
</template>
