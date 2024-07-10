<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { cn } from '@/utils/Shdn'

const props = defineProps<{
  class?: HTMLAttributes['class']
}>()
</script>

<template>
  <tr :class="cn('border-b cursor-pointer border-stone-100 space-x-1 transition-colors hover:bg-blue-50/50 data-[state=selected]:bg-muted', props.class)">
    <slot />
  </tr>
</template>
