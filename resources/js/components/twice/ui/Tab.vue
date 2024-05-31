<script setup lang="ts">
import { inject, computed } from 'vue'

export interface Props {
  title: string
  name: string
  disabled?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  disabled: false
})

const activeTab = inject<string>('activeTab', '')
const setTab = inject<Function>('setTab')

const changed = () => {
  if (!props.disabled && setTab !== undefined) {
    setTab(props.name)
  }
}

const isActive = computed(() => props.name === activeTab || '')

</script>
<template>
  <div
    :disabled="disabled"
    class="flex items-center px-4 pt-2.5 pb-2.5 select-none  text-base h-9 flex-none rounded-t-md"
    :class="[isActive ? 'border-b-0 border bg-white font-medium' : 'border-b', disabled ? 'text-slate-400 cursor-not-allowed' : 'text-slate-900 hover:text-blue-500 cursor-pointer']"
    @click="changed"
    @keyup.space="changed"
  >
    <span>{{ title }}</span>
  </div>
</template>
