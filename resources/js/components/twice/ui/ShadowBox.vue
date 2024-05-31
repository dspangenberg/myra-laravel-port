<script setup lang="ts">
import { computed } from 'vue'

export interface Props {
  bg?: string
  rounded?: string
  padding?: boolean
  shadow?: string
}

const props = withDefaults(defineProps<Props>(), {
  bg: 'bg-white',
  rounded: 'md',
  padding: true,
  shadow: 'sm'
})

const roudedClass = computed(() => {
  return {
    sm: 'rounded-sm',
    md: 'rounded-md'
  }[props.rounded]
})

const shadowClass = computed(() => {
  return {
    '': 'shadow',
    sm: 'shadow-sm',
    lg: 'shadow-lg',
    md: 'shadow-md'
  }[props.shadow]
})

</script>

<template>
  <div
    class="shadow-sm border border-stone-200/60  border-t   mb-2 border-b-0"
    :class="roudedClass"
  >
    <div
      class=" z-0 content-between"
      :class="[roudedClass, shadowClass, bg, padding ? 'p-4' : '']"
    >
      <slot />
    </div>
  </div>
</template>
