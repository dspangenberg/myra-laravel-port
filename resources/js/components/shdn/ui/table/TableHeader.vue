<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { cn } from '@/utils/Shdn'

const props = defineProps<{
  class?: HTMLAttributes['class']
}>()
</script>

<template>
  <thead :class="cn('[&_tr]:border-b bg-stone-50/75', props.class)">
    <slot />
  </thead>
</template>
