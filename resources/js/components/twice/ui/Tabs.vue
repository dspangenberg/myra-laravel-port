<script setup lang="ts">
import { provide, toRefs, computed } from 'vue'

const emit = defineEmits(['update:modelValue', 'select'])

const setTab = (name: string) => {
  emit('update:modelValue', name)
  emit('select', name)
}

const activeTab = computed(() => modelValue.value)
const isFirst = computed(() => props.first === activeTab.value)

provide('activeTab', activeTab)
provide('setTab', setTab)
export interface Props {
  modelValue?: string
  tag?: string
  first?: string
  span?: boolean
  border?: boolean
  bg?: string
}

const props = withDefaults(defineProps<Props>(), {
  modelValue: '',
  tag: 'nav',
  first: '',
  span: true,
  border: true,
  bg: 'bg-stone-100'
})

const { modelValue } = toRefs(props)

</script>

<template>
  <component
    :is="tag"
    class="flex items-start overflow-x-auto overflow-y-hidden flex-nowrap border-stone-300  text-sm mb-6"
    :class="bg"
  >
    <div
      v-if="span"
      class="w-2.5 border-b h-9 flex-none"
    />
    <slot />
    <div
      class="h-9 flex-1"
      :class="[border ? 'border-b ' : '', isFirst ? '' : 'rounded-t-md']"
    />
  </component>
</template>
