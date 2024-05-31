<script setup lang="ts">
import { computed } from 'vue'

interface ErrorMessages {
  [field: string]: string
}

export interface Props {
  errors: ErrorMessages | null | undefined
}

const props = defineProps<Props>()

const errorMessages = computed(() => {
  if (!props.errors) return []
  const errors: string[] = []
  for (const [, value] of Object.entries(props.errors)) {
    errors.push(value)
  }
  return errors
})

</script>

<template>
  <div
    v-if="errorMessages?.length"
    class="px-4"
  >
    <twice-ui-alert
      v-show="errorMessages?.length"
      title="Bitte überprüfen Sie Ihre Eingaben:"
    >
      <ul class="list-inside list-disc pt-2">
        <li
          v-for="(message, index) in errorMessages"
          :key="index"
        >
          {{ message }}
        </li>
      </ul>
    </twice-ui-alert>
  </div>
</template>
