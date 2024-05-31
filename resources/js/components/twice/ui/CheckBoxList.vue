<script setup lang="ts">
import {
  computed,
  toRef
} from 'vue'
import { useField } from 'vee-validate'

export interface Props {
  trueValue: number
  rules?: string
  name: string
  label: string
}

const props = withDefaults(defineProps<Props>(), {
  id: undefined,
  rules: '',
  label: '',
  disabled: false
})

const name = toRef(props, 'name')
const rules = toRef(props, 'rules')
const label = toRef(props, 'label')

const { value, handleChange } = useField<number[]>(name, rules, { label })
console.log(value.value)
const localValue = computed({
  get: () => value.value.includes(props.trueValue),
  set: newValue => {
    if (newValue) {
      value.value.push(props.trueValue)
    } else {
      value.value = value.value.filter(item => item !== props.trueValue)
    }
    handleChange(value.value, false)
  }
})

</script>

<template>
  <div>
    <label class="text-base">
      <input
        v-model="localValue"
        type="checkbox"
        :name="name"
        :value="trueValue"
        class="h-4 w-4 flex-none rounded  border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 focus:ring-offset-0 cursor-pointer disabled:cursor-not-allowed disabled:text-gray-400"
      >
      {{ label }}
    </label>
  </div>
</template>
