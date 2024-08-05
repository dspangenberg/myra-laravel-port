<script lang="ts" setup>
import { computed, toRef } from 'vue'
import { id as id2 } from 'random-html-id'
import { useVModel } from '@vueuse/core'

export interface Props {
  modelValue: number
  trueValue?: boolean
  name: string
  rules?: string
  label: string
  id?: string
  disabled?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  id: undefined,
  rules: undefined,
  trueValue: true,
  disabled: false
})

const emit = defineEmits(['update:modelValue', 'change'])
const data = useVModel(props, 'modelValue', emit)

const xid = id2()
const htmlId = computed(() => `checkbox-${xid}`)

</script>
<template>
  <div class="flex items-center space-x-1.5">
    <input
      :id="htmlId"
      v-model="data"
      :value="trueValue"
      class="h-4 w-4 flex-none rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 focus:ring-offset-0 cursor-pointer disabled:cursor-not-allowed disabled:text-gray-400"
      type="checkbox"
    >
    <label
      :for="htmlId"
      class="flex-1 text-black text-base cursor-pointer disabled:cursor-not-allowed"
    >
      <slot>{{ label }}</slot>
    </label>
  </div>
</template>
