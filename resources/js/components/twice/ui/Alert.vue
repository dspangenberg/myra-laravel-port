<script setup lang="ts">
export interface Props {
  title: string
  variant?: string
}

withDefaults(defineProps<Props>(), {
  title: '',
  variant: 'error'
})
</script>

<template>
  <div>
    <div
      class="flex rounded-md text-base text-red-500 bg-red-50 p-4"
    >
      <twice-ui-icon
        name="circle-x"
        fill
        class="mr-3 w-6 flex-shrink-0 h-6"
      />
      <div>
        <h4 class="font-bold">
          {{ title }}
        </h4>
        <div class="mt-1">
          <slot />
        </div>
      </div>
      <button
        class="ml-auto"
      >
        <twice-ui-icon
          name="x"
          class="h-5 w-5"
        />
      </button>
    </div>
  </div>
</template>
