<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { cn } from '@/utils/Shdn'

const props = defineProps<{
  class?: HTMLAttributes['class']
}>()
</script>

<template>
  <div class="shadow border bg-white rounded overflow-y-auto">
    <table :class="cn('w-full table-fixed caption-bottom select-none text-base rounded  ', props.class)">
      <slot />
    </table>
  </div>
</template>
