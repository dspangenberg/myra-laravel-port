<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { cn } from '@/utils/Shdn'

const props = defineProps<{
  class?: HTMLAttributes['class']
}>()
</script>

<template>
  <div class="shadow border bg-white rounded">
    <table :class="cn('w-full table-fixed caption-bottom select-none text-base rounded overflow-y-auto ', props.class)">
      <slot />
    </table>
  </div>
</template>
