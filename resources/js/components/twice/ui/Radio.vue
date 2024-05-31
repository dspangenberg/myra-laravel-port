<script setup lang="ts">
import { computed, toRef } from 'vue'
import { useField } from 'vee-validate'

export interface Options {
  id: number
  name: string
  disabled?: boolean
  group?: string
}

export interface Props {
  name: string
  rules?: string
  label?: string
  disabled?: boolean
  autofocus?: boolean
  cols?: number
  horizontal?: boolean
  required?: boolean
  options: Options[]
  optionsValue?: string
  optionsName?: string
  optionDisabled?: string
  onlyOptionsWithName?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  rules: undefined,
  label: undefined,
  disabled: false,
  optionsValue: 'id',
  optionsName: 'name',
  optionDisabled: 'disabled',
  onlyOptionsWithName: false,
  horizontal: false,
  autofocus: false,
  cols: 3,
  required: false
})

const name = toRef(props, 'name')
const rules = toRef(props, 'rules')
const label = toRef(props, 'label')

const { value } = useField(name, rules, { label })
const gridCols = computed(() => {
  return {
    0: 'flex space-x-2',
    1: 'grid grid-cols-1 space-y-1',
    2: 'grid grid-cols-2',
    3: 'grid grid-cols-3',
    4: 'grid grid-cols-4',
    5: 'grid grid-cols-5',
    6: 'grid grid-cols-6',
    12: 'grid grid-cols-12',
    24: 'grid grid-cols-24'
  }[props.cols]
})

</script>
<template>
  <div
    class="w-full space-y-1 "
    :class="[horizontal ? 'flex items-center' : '']"
  >
    <div
      v-if="label"
      class="block w-full"
    >
      <twice-ui-label
        :label="label"
        :required="required"
      />
    </div>
    <div
      :class="[gridCols]"
      class="flex items-center w-full space-x-2"
    >
      <twice-ui-radio-button
        v-for="(option, index) in options"
        :key="index"
        v-model="value"
        type="radio"
        :label="option.name"
        :horizontal="horizontal"
        :cols="cols"
        :value="option.id"
      />
    </div>
  </div>
</template>
