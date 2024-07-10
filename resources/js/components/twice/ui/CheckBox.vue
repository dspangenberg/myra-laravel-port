<script lang="ts" setup>
import { computed, toRef } from 'vue'
import { id as id2 } from 'random-html-id'
import { useField } from 'vee-validate'

export interface Props {
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

const name = toRef(props, 'name')
const rules = toRef(props, 'rules')
const label = toRef(props, 'label')

const xid = id2()
const htmlId = computed(() => `checkbox-${xid}`)

const { value } = useField<number>(name, rules, { label })
defineEmits(['input'])

</script>
<template>
  <div class="flex items-center space-x-1.5">
    <input
      :id="htmlId"
      v-model="value"
      :value="trueValue"
      class="h-4 w-4 flex-none rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 focus:ring-offset-0 cursor-pointer disabled:cursor-not-allowed disabled:text-gray-400"
      type="checkbox"
      @change="$emit('input', ($event.target as HTMLInputElement).checked)"
    >
    <label
      :for="htmlId"
      class="flex-1 text-black text-base cursor-pointer disabled:cursor-not-allowed"
    >
      <slot>{{ label }}</slot>
    </label>
  </div>
</template>
