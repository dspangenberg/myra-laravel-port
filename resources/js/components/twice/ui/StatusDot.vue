<script setup lang="ts">
import { computed } from 'vue'

export interface Props {
  animate?: boolean
  color?: string
  size?: number
}

const props = withDefaults(defineProps<Props>(), {
  animate: false,
  color: 'red',
  size: 2
})

const colorClass = computed(() => {
  return {
    red: 'bg-red-500',
    green: 'bg-green-500',
    yellow: 'bg-yellow-500',
    orange: 'bg-orange-500',
    blue: 'bg-blue-500'
  }[props.color]
})

const sizeClass = computed(() => {
  return {
    1: 'h-1 w-1',
    1.5: 'h-1.5 w-1.5',
    2: 'h-2 w-2',
    4: 'h-4 w-4',
    5: 'h-5 w-5'
  }[props.size]
})

</script>
<template>
  <span
    :class="[sizeClass]"
    class="inline-block relative"
  >
    <span
      v-if="animate"
      :class="colorClass"
      class="animate-ping absolute h-full w-full rounded-full opacity-75"
    />
    <span
      :class="colorClass"
      class="absolute rounded-full h-full w-full"
    />

  </span>
</template>
