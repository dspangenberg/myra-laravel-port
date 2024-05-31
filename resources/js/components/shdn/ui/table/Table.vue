<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { cn } from '@/utils/Shdn'

const props = defineProps<{
  class?: HTMLAttributes['class']
}>()
</script>

<template>
  <div class="relative w-full overflow-auto border-t rounded-md shadow border-stone-100">
    <table :class="cn('w-full caption-bottom select-none text-base', props.class)">
      <slot />
    </table>
  </div>
</template>
