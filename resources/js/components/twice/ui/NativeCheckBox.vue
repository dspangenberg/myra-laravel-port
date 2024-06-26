<script setup lang="ts">
import { useVModel } from '@vueuse/core'
import { id as htmlId } from 'random-html-id'

export interface Props {
  modelValue: boolean
  label: string
  trueValue?: boolean
  disabled?: boolean
  autofocus?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  disabled: false,
  autofocus: false,
  trueValue: true,
  modelValue: false
})
console.log(props)
const emit = defineEmits(['update:modelValue'])
const data = useVModel(props, 'modelValue', emit)

</script>
<template>
  <div class="flex items-center space-x-2">
    <input
      :id="htmlId"
      v-model="data"
      type="checkbox"
      :value="trueValue"
      class="h-4 w-4 flex-none rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 focus:ring-offset-0 cursor-pointer disabled:cursor-not-allowed disabled:text-gray-400"
    >
    <label
      :for="htmlId"
      class="flex-1 text-black text-base cursor-pointer disabled:cursor-not-allowed"
    >
      <slot>{{ label }}</slot>
    </label>
  </div>
</template>
