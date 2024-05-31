<script setup lang="ts">
import { computed, ref, toRefs, watch } from 'vue'
import { id } from 'random-html-id'

const emit = defineEmits(['update:modelValue'])


export interface Props {
  trueValue: number | string
  label: string
  id?: string
  disabled?: boolean
  modelValue: number | string
}

const props = withDefaults(defineProps<Props>(), {
  id: undefined
})

const checkbox = ref()

const elementId = computed(() => 'stormy-checkbox-' + id(8))

const proxyChecked = computed({
  get () {
    if (Array.isArray(props.modelValue)) {
      return props.modelValue.includes(props.trueValue)
    }
    return props.modelValue === props.trueValue
  },
  set (newValue) {
    if (Array.isArray(props.modelValue)) {
      emit('update:modelValue', { id: props.trueValue, checked: newValue })
    } else {
      emit('update:modelValue', newValue ? props.trueValue : 0)
    }
  }
})

</script>

<template>
  <div class="flex items-center space-x-2">
    <input
      :id="elementId"
      ref="checkbox"
      v-model="proxyChecked"
      :disabled="disabled"
      type="checkbox"
      :value="trueValue"
      class="h-4 w-4 flex-none rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 focus:ring-offset-0 cursor-pointer disabled:cursor-not-allowed disabled:text-gray-400"
    >
    <label
      :for="elementId"
      :disabled="disabled"

      class="text-sm flex-1 text-gray-600 cursor-pointer disabled:cursor-not-allowed truncate disabled:text-gray-400"
      :class="disabled ? '!cursor-not-allowed !text-gray-400' : 'cursor-pointer'"
    >
      {{ label }}
    </label>
  </div>
</template>

