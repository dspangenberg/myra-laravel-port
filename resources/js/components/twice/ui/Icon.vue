<script setup lang="ts">
import { defineAsyncComponent, shallowRef, toRefs, watch } from 'vue'

export interface Props {
  strokeWidth?: number
  fill?: boolean
  tooltipPlacement?: string
  tooltip?: string
  name: string
}

const props = withDefaults(defineProps<Props>(), {
  name: '',
  strokeWidth: 2,
  tooltipPlacement: 'auto',
  tooltip: ''
})

const iconPath = shallowRef()
const { name } = toRefs(props)

watch(name, async (icon) => {
  if (!icon) return
  iconPath.value = defineAsyncComponent(() => props.fill
    ? import(`../../../../../node_modules/@tabler/icons/icons/filled/${icon.replace('tabler-', '')}.svg`)
    : import(`../../../../../node_modules/@tabler/icons/icons/outline/${icon.replace('tabler-', '')}.svg`)
  )
}, { immediate: true })
</script>

<template>
  <component
    :is="iconPath"
    v-tooltip="tooltip"
    viewBox="0 0 24 24"
    aria-hidden="true"
    :stroke-width="strokeWidth"
  />
</template>
