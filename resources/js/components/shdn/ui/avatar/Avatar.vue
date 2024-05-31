<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { AvatarRoot } from 'radix-vue'
import { type AvatarVariants, avatarVariant } from '.'
import { cn } from '@/utils/Shdn'

const props = withDefaults(defineProps<{
  class?: HTMLAttributes['class']
  size?: AvatarVariants['size']
  shape?: AvatarVariants['shape']
}>(), {
  size: 'sm',
  shape: 'circle',
  class: ''
})
</script>

<template>
  <AvatarRoot :class="cn(avatarVariant({ size, shape }), 'border bg-white border-stone-200', props.class)">
    <div class="border-2 border-white">
      <slot />
    </div>
  </AvatarRoot>
</template>
