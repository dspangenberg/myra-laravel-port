<script setup lang="ts">
export interface Props {
  label: string
  value?: string | boolean | number
}

withDefaults(defineProps<Props>(), {
  label: '',
  value: undefined
})
</script>

<template>
  <div
    v-if="value"
    class="px-2 py-2"
  >
    <div
      class="text-sm text-gray-500"
    >
      {{ label }}
    </div>
    <div class="text-base text-gray-900 pt-1 truncate">
      <slot>
        {{ value }}
      </slot>
    </div>
  </div>
</template>
