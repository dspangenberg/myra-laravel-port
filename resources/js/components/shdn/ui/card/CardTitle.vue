<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { cn } from '@/utils/Shdn'

const props = defineProps<{
  class?: HTMLAttributes['class']
}>()
</script>

<template>
  <h3
    :class="
      cn('text-xl font-medium leading-none', props.class)
    "
  >
    <slot />
  </h3>
</template>
