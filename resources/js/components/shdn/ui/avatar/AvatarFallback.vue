<script setup lang="ts">
import { AvatarFallback } from 'radix-vue'
import { computed } from 'vue'
import { type AvatarVariants, avatarVariant } from '.'
import { cn } from '@/utils/Shdn'

const colors = ['#00bcf2', '#0078d4', '#002050', '#008272',
  '#bad80a', '#004b1c', '#e3008c', '#b4a0ff', '#5c2d91',
  '#000000', '#d83b01', '#e81123', '#a80000',
  '#e81123', '#5c005c', '#b4a0ff', '#00188f']

interface Props {
  as?: string
  fullname: string
  asChild?: boolean
  delayMs?: number
  size?: AvatarVariants['size']
}

const props = withDefaults(defineProps<Props>(), {
  as: undefined,
  delayMs: undefined,
  size: 'sm',
  asChild: false
})

const getBackgroundColor = computed(() => {
  if (props.fullname) {
    const charCodes = props.fullname
      .split('')
      .map(char => char.charCodeAt(0))
      .join('') as unknown as number
    return colors[charCodes % colors.length]
  }
  return 'white'
})

</script>

<template>
  <AvatarFallback
    v-bind="props"
    class="object-cover rounded-full text-white font-medium border-4 !border-white uppercase"
    :class="cn(avatarVariant({ size }))"
    :style="{ backgroundColor: getBackgroundColor }"
  >
    <slot />
  </AvatarFallback>
</template>
