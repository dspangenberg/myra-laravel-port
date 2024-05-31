<script setup lang="ts">
import { inject, computed } from 'vue'

export interface Props {
  disabled?: boolean
  label: string
  tag?: string
  value?: string
}

const props = withDefaults(defineProps<Props>(), {
  disabled: false,
  tag: 'button',
  value: ''
})

const selectedSegment = inject<string>('selectedSegment')
const setSegment = inject<Function>('setSegment')

const changed = () => {
  if (!props.disabled && typeof setSegment === 'function') {
    setSegment(props.value)
  }
}

const isActive = computed(() => props.value === selectedSegment)

</script>

<template>
  <component
    :is="tag"
    :disabled="disabled"
    :class="[
      'flex-grow transition-colors duration-150 ease-in-out px-4 py-0.5 rounded focus:outline-none',
      {
        'bg-white dark:bg-gray-600 text-gray-900 dark:text-gray-50 shadow-sm font-medium': isActive,
        'cursor-pointer hover:text-gray-700 dark:hover:text-gray-200 focus:ring-2 focus:ring-white dark:focus:ring-gray-700': !isActive && !disabled,
        'cursor-not-allowed text-gray-400': disabled && !isActive,
      },
    ]"
    :aria-disabled="disabled ? 'true' : null"
    :aria-selected="isActive ? 'true' : 'false'"
    :tabindex="isActive || disabled ? null : 0"
    @click="changed"
    @keyup.enter="changed"
    @keyup.space="changed"
  >
    {{ label }}
  </component>
</template>
