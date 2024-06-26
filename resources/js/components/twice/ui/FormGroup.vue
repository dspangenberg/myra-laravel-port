<script setup lang="ts">
import { computed } from 'vue'

export interface Props {
  border?: boolean
  cols?: number
  fullWidth?: boolean
  grid?: boolean
  margin?: boolean
  title?: string
  titleClass?: string
}

const props = withDefaults(defineProps<Props>(), {
  border: false,
  cols: 24,
  fullWidth: true,
  grid: true,
  margin: true,
  title: '',
  titleClass: 'font-medium text-base text-black mt-6 pb-3 border-b'
})

const gridCols = computed(() => {
  return {
    6: 'grid-cols-6',
    12: 'grid-cols-12',
    24: 'grid-cols-24'
  }[props.cols]
})

</script>

<template>
  <div class="flex-1 border-stone-100">
    <div
      v-if="title !== ''"
      class="px-6 pb-1.5"
      :class="titleClass"
    >
      <slot name="title">
        {{ title }}
      </slot>
    </div>
    <div
      :class="[ border || title !== '' ? ' border-stone-100' : '', grid ? 'px-6 grid  gap-x-3 gap-y-2.5 m-0 p-0' : '', margin ? 'mt-3' : 'not-first:mt-2', grid ? gridCols : '']"
      class="px-0 mb-1 last:mb-3 flex-1"
    >
      <slot />
    </div>
  </div>
</template>
