<script setup lang="ts">
import { provide, toRefs, computed } from 'vue'
import type { InjectionKey } from 'vue'
const emit = defineEmits(['update:modelValue', 'select'])

const setSegment = (name: string) => {
  emit('update:modelValue', name)
  emit('select', name)
}

export interface Props {
  modelValue?: string
  tag?: string
}

const keySelectedSement = Symbol('selectedSegment') as InjectionKey<string>
const keySetSegment = Symbol('setSegment') as InjectionKey<Function>
const keySegmentProps = Symbol('segmentProps') as InjectionKey<Props>

const props = withDefaults(defineProps<Props>(), {
  modelValue: '',
  tag: 'nav'
})

const { modelValue } = toRefs(props)

const activeSegment = computed<string>(() => modelValue.value)

provide(keySelectedSement, activeSegment.value)
provide(keySetSegment, setSegment)
provide(keySegmentProps, props)

</script>

<template>
  <component
    :is="tag"
    class="inline-flex p-1 bg-gray-200 dark:bg-gray-800 rounded-md space-x-1 text-base leading-tight"
  >
    <slot />
  </component>
</template>
