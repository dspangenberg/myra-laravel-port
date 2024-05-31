<script setup lang="ts">
import { defineAsyncComponent, computed, shallowRef, toRefs, watch } from 'vue'

export interface Props {
  size?: number
  bgColor?: string
  iconColor?: string
  name: string
}

const props = withDefaults(defineProps<Props>(), {
  name: '',
  bgColor: '#cccc',
  size: 2,
  iconColor: '#000'
})

const iconPath = shallowRef()
const { name } = toRefs(props)

const iconSize = computed(() => {
  return {
    2: 'size-2',
    2.5: 'size-2.5',
    3: 'size-3',
    4: 'size-4',
    5: 'size-5',
    6: 'size-7',
    8: 'size-8',
    10: 'size-10'
  }[props.size]
})

const dotSize = computed(() => {
  return {
    2: 'size-4',
    2.5: 'size-5',
    3: 'size-6',
    4: 'size-8',
    5: 'size-8',
    6: 'size-12',
    8: 'size-16',
    10: 'size-20'
  }[props.size]
})

watch(name, async (icon) => {
  if (!icon) return
  iconPath.value = defineAsyncComponent(() =>
    import(`../../assets/icons/${icon.replace('tabler-', '')}.svg`)
  )
}, { immediate: true })

</script>

<template>
  <div
    class="rounded-full border flex items-center justify-center"
    :class="[dotSize]"
    :style="{backgroundColor: bgColor, color: iconColor }"
  >
    <twice-ui-icon
      :name="name"
      :class="iconSize"
    />
  </div>
</template>
