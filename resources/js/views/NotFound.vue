<template>
  <div class="grid h-screen px-4 bg-white place-content-center">
    <div class="text-center">
      <h1 class="font-black text-gray-200 text-9xl">
        404
      </h1>

      <p class="my-8 text-gray-500">
        Die Seite <strong>{{ route.fullPath }}</strong> konnte nicht gefunden werden.
      </p>

      <twice-ui-button
        variant="primary"
        @click="backToDashboard"
      >
        Zurück zum Dashboard
      </twice-ui-button>
    </div>
  </div>
</template>
<script setup lang="ts">
import { useRouter, useRoute } from 'vue-router'

const router = useRouter()
const route = useRoute()

const backToDashboard = () => {
  router.push({ name: 'dashboard' })
}

</script>
