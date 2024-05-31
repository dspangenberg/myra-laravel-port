<script setup lang="ts">
import { type Meta } from '@/types/'

export interface Props {
  meta: Meta | null
  currentPage?: number
  title: string,
  emptyStateTitle?: string,
  emptyStateSubTitle?: string,
  loading?: boolean,
}

withDefaults(defineProps<Props>(), {
  currentPage: 1,
  emptyStateTitle: 'Sie haben noch keine Dings',
  emptyStateSubTitle: '',
  loading: false
})

const emit = defineEmits(['updatePage'])
</script>

<template>
  <div class="flex flex-col flex-1 p-1">
    <div class="flex items-center  py-2.5 px-4">
      <div class="flex-1 text-lg font-medium ">
        {{ title }}&nbsp;
      </div>
      <div class="flex-none">
        <slot name="toolbar" />
      </div>
    </div>
    <div
      v-if="loading"
      class="flex items-center justify-center w-full h-full overflow-x-hidden bg-white border rounded-md shadow-sm text-card-foreground"
    >
      <div class="text-center">
        <twice-ui-spinner :size="8" />
      </div>
    </div>
    <div v-else>
      <div
        v-if="meta?.total || 0"
        class="w-full overflow-x-hidden bg-white border rounded-md shadow-sm  text-card-foreground"
      >
        <div class="flow-root">
          <div class="">
            <slot

              name="default"
            />
          </div>
        </div>
      </div>
      <div
        v-else
        class="flex items-center justify-center w-full h-full overflow-x-hidden bg-white border rounded-md shadow-sm  text-card-foreground"
      >
        <div>
          <slot name="emptyState">
            <div class="text-center">
              <div class="text-xl font-medium">
                {{ emptyStateTitle }}
              </div>
              <div
                v-if="emptyStateSubTitle"
                class="pt-2 text-base text-gray-500"
              >
                {{ emptyStateSubTitle }}
              </div>
            </div>
            <div class="my-6 text-center">
              <slot name="empty-state-button" />
            </div>
          </slot>
        </div>
      </div>
      <twice-ui-pagination
        v-if="meta"
        :meta="meta"
        :current-page="currentPage"
        @update-page="emit('updatePage', $event)"
      />
    </div>
  </div>
</template>
