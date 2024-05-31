<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { cn } from '@/utils/Shdn'

const props = defineProps<{
  class?: HTMLAttributes['class']
}>()
</script>

<template>
  <p :class="cn('text-base text-muted-foreground', props.class)">
    <slot />
  </p>
</template>
