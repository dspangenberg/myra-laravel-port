<script setup lang="ts">
import { computed, useSlots } from 'vue'

export interface Props {
  label: string
  labelClass?: string
  required?: boolean
  maxlength?: number
}

withDefaults(defineProps<Props>(), {
  labelClass: '',
  required: false,
  maxlength: 524288
})

const $slots = useSlots()
const hasRight = computed(() => !!$slots.right)

</script>

<template>
  <label
    class="flex items-center text-base font-medium text-gray-800 mb-1"
    :class="labelClass"
  >
    <div class="flex-1">
      <slot>
        <span
          v-if="label"
          class="leading-tight"
        >
          <span v-if="label === 'x'">
          &nbsp;
          </span>
          <span v-else>{{ label }}:</span>
          <span
            v-if="required"
            class="font-normal sup ml-0.5 text-red-500"
          >*</span>
        </span>
        <span v-if="maxlength !== 524288">
          max. {{ maxlength }} Zeichen
        </span>
      </slot>
    </div>
    <div
      v-if="hasRight"
      flex-none
    >
      <slot name="right" />
    </div>
  </label>
</template>
