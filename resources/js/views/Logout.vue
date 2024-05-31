<script setup lang="ts">
import { onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useGlobalStore } from '@/stores/GlobalStore'

const globalStore = useGlobalStore()

const router = useRouter()

onMounted(async () => {
  try {
    globalStore.signOut()
  } catch (error) {}

  router.push({ name: 'login' })
})

</script>
<template>
  <div class="flex items-center justify-center h-full w-full">
    <div class="text-center">
      <div>
        <twice-ui-spinner :size="8" />
      </div>
      <div class="text-base text-gray-500 pt-4">
        Du wirst angemeldet
      </div>
    </div>
  </div>
</template>
