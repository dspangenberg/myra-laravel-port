<script setup lang="ts">
import { computed, toRef } from 'vue'
import { id as id2 } from 'random-html-id'

export interface Options {
  id: number
  name: string
  disabled?: boolean
  group?: string
}

export interface Props {
  value: string | number
  modelValue: string | number | null | boolean | undefined
  rules?: string
  label?: string
  id?: string
  disabled?: boolean
  autofocus?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  id: undefined,
  rules: undefined,
  label: undefined,
  disabled: false,
  optionsValue: 'id',
  optionsName: 'name',
  optionDisabled: 'disabled',
  onlyOptionsWithName: false,
  autofocus: false,
  cols: 3,
  required: false
})
defineEmits(['update:modelValue'])

const label = toRef(props, 'label')
const xid = id2()
const htmlId = computed(() => props.id ? props.id : `select-${xid}`)

</script>
<template>
  <div
    class="flex items-center space-x-1.5 w-auto border-0"
  >
    <input
      :id="htmlId"
      :value="value"
      :checked="modelValue === value"
      type="radio"
      :name="htmlId"
      class="h-4 w-4 rounded-full  border-gray-300 text-primary-600 shadow-sm  focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 focus:ring-offset-0 disabled:cursor-not-allowed disabled:text-gray-400"
      @input="$emit('update:modelValue', value)"
    >
    <slot>
      <label
        v-if="label"
        :for="htmlId"
        class="text-base font-medium flex-1 text-gray-600 cursor-pointer disabled:cursor-not-allowed py-2 border-0 rounded-none"
      >
        {{ label }}
      </label>
    </slot>
  </div>
</template>
