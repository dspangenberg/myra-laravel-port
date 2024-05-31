<script setup lang="ts">
import { computed, useSlots } from 'vue'

defineEmits(['submitted'])

const isFullWidth = computed(() => !!$slots.title || !!$slots.description)
const $slots = useSlots()
</script>

<template>
  <div class="grid grid-cols-4 gap-2 flex-1">
    <div
      v-if="!isFullWidth"
      class="mt-5"
    >
      <div class="sm:px-0">
        <h3 class="text-base font-medium text-gray-800">
          <slot name="title" />
        </h3>

        <p class="mt-1 text-sm text-gray-500">
          <slot name="description" />
        </p>
      </div>
    </div>
    <div
      class="sm:px-0"
      :class="isFullWidth ? 'col-span-4' : 'col-span-3'"
    >
      <slot name="header" />
      <slot name="aside" />
    </div>
  </div>
</template>
