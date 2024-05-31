<script setup lang="ts">
import { computed, useSlots } from 'vue'

interface ErrorMessages {
  [field: string]: string
}

export interface Props {
  fullWidth?: boolean,
  headline?: string
  errors?: ErrorMessages | null
  hideActions?: boolean
  bannerIcon?: string
  padding?: boolean
  bannerColor?: string
  title?: string
}

const props = withDefaults(defineProps<Props>(), {
  title: '',
  headline: '',
  errors: null,
  bannerColor: 'yellow',
  bannerIcon: '',
  hideActions: false,
  fullWidth: false,
  padding: true
})

const hasErrors = computed(() => props.errors ? Object.keys(props.errors).length : 0)

const bannerIcon = computed(() => {
  if (props.errors) {
    return 'circle-x'
  }
  if (props.bannerIcon) {
    return props.bannerIcon
  }
  return {
    yellow: 'bg-yellow-50 border-yellow-200 ',
    sm: 'max-w-xl',
    md: 'max-w-2xl ',
    lg: 'max-w-4xl',
    xl: 'max-w-7xl'
  }[props.bannerColor]
})

const bannerBgColor = computed(() => {
  if (props.errors) {
    return 'bg-red-50 border-red-200 text-red-500'
  }
  return {
    yellow: 'bg-yellow-50 border-yellow-200',
    sm: 'max-w-xl',
    md: 'max-w-2xl ',
    lg: 'max-w-4xl',
    xl: 'max-w-7xl'
  }[props.bannerColor]
})

const hasActions = computed(() => !!$slots.actions)
const hasSecondardActions = computed(() => !!$slots.secondaryActions)
const hasBanner = computed(() => !!$slots.banner || hasErrors.value)
const hasHeadlineHelp = computed(() => !!$slots.headlineHelp)
const $slots = useSlots()
</script>

<template>
  <div class="flex-1">
    <div
      v-if="headline"
      class="px-6 mb-2 text-lg font-medium text-black"
    >
      {{ headline }}
    </div>
    <div
      v-if="hasHeadlineHelp"

      class="px-6 mb-2 text-sm font-normal text-gray-500"
    >
      <slot name="headlineHelp" />
    </div>

    <div class="rounded-md bg-white shadow border border-b-0 mb-24 border-gray-200/75">
      <div
        v-if="hasBanner"
        class="px-8 py-2.5 border-b rounded-t-md flex items-center text-sm"
        :class="[bannerBgColor]"
      >
        <div class="flex-1 items-start flex space-x-2">
          <slot name="banner">
            <div v-if="errors">
              <div class="flex items-center pb-2">
                <div class="w-7">
                  <twice-ui-icon
                    :name="bannerIcon"
                    fill
                    class="size-5"
                  />
                </div>
                <div class="font-medium">
                  Ups, das Formular konnte nicht gespeichert werden.
                </div>
              </div>
              <div class="flex items-center">
                <div class="w-7" />
                <div class="">
                  <ul class="list-inside list-disc pt-0.5">
                    <li
                      v-for="(message, index) in errors"
                      :key="index"
                    >
                      {{ message }}
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </slot>
        </div>
      </div>
      <div class="py-2 px-0 mx-0">
        <slot name="form" />
      </div>
      <div
        v-if="hasActions || hasSecondardActions"
        class="px-6 py-2 bg-neutral-50 border-t rounded-b-md flex items-center"
      >
        <div class="flex-1 items-start flex space-x-2">
          <slot name="secondard-actions" />
        </div>
        <div class="flex-1 justify-end flex space-x-2">
          <slot name="actions" />
        </div>
      </div>
    </div>
  </div>
</template>
