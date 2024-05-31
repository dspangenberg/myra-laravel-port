<script setup lang="ts">
import { SelectValue, type SelectValueProps } from 'radix-vue'

const props = defineProps<SelectValueProps>()
console.log(props)
</script>

<template>
  <SelectValue
    v-bind="props"
  >
    <slot />
  </SelectValue>
</template>
