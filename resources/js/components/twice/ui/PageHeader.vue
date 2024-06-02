<script setup lang="ts">
import { type RouteParams, type LocationQuery } from 'vue-router'
import { computed, useSlots } from 'vue'

export interface Props {
  backText?: string
  title?: string
  backRouteName?: string
  backRouteParams?: RouteParams
  loading?: boolean
  backRouteQuery?: LocationQuery
}

withDefaults(defineProps<Props>(), {
  title: '',
  backText: '',
  backRouteName: '',
  backRouteParams: undefined,
  backRouteQuery: undefined,
  loading: false
})

const slots = useSlots()
const hasPivot = computed(() => slots.pivot)
</script>
<template>
  <div class="mx-auto max-w-7xl print:max-w-fit print:mx-0">
    <div class="pb-1.5 mx-3">
      <slot name="breadcrumbs" />
    </div>
  </div>
  <div class="bg-white pt-3 border-t border-b border-stone-100">
    <div
      class="mx-auto max-w-7xl print:max-w-fit print:mx-0 mt-3"
      :class="hasPivot ? '' : 'mb-6'"
    >
      <div
        class="flex items-center mx-2.5 select-none"
      >
        <div class="flex-1">
          <slot name="title">
            <h1 class="text-xl font-medium">
              {{ title }}
            </h1>
          </slot>
        </div>
        <div class="flex items-center flex-none -mr-2 space-x-1">
          <slot name="toolbar" />
        </div>
      </div>
      <div
        v-if="hasPivot"
        class="flex-1 flex flex-col justify-between px-2.5 w-full max-w-7xl mx-auto"
      >
        <div
          class="justify-self-end flex-shrink  max-h-6.5 select-none print-hidden print:hidden mt-3"
        >
          <slot name="pivot" />
        </div>
      </div>
    </div>
  </div>
</template>
