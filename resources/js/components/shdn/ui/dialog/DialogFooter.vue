<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { cn } from '@/utils/Shdn'

const props = defineProps<{ class?: HTMLAttributes['class'] }>()
</script>

<template>
  <div
    :class="
      cn(
        'flex flex-col-reverse sm:flex-row sm:justify-end justify-center bg-stone-50',
        props.class,
      )
    "
  >
    <slot />
  </div>
</template>
