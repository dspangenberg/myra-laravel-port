<script setup lang="ts">
import { provide, toRefs, computed } from 'vue'

const emit = defineEmits(['update:modelValue', 'select'])

const setTab = (name: string) => {
  emit('update:modelValue', name)
  emit('select', name)
}

const activeTab = computed(() => modelValue.value)

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
  <div
    class="flex items-center w-full flex-1"
  >
    <div class="flex-1">
      <div class="text-base w-full flex space-x-6 ">
        <slot />
      </div>
    </div>
    <div class="flex-none">
      <div class="text-base w-full flex space-x-6">
        <slot name="right" />
      </div>
    </div>
  </div>
</template>
