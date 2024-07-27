<script generic="TValue" lang="ts" setup>
import { computed } from 'vue'
import { SelectRoot } from 'radix-vue'

const props = defineProps<{
  modelValue: TValue | undefined
}>()

const emit = defineEmits<{
  'update:modelValue': [value: TValue | undefined]
}>()

const model = computed<string | undefined>({
  get: () => {
    return JSON.stringify(props.modelValue)
  },
  set: (value) => {
    if (value === undefined) {
      emit('update:modelValue', undefined)
      return
    }

    emit('update:modelValue', JSON.parse(value))
  }
})

</script>

<template>
  <SelectRoot v-model="model">
    <slot />
  </SelectRoot>
</template>
