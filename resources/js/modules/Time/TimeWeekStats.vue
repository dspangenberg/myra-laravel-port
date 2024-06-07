<script setup lang="ts">
import { useTemplateFilter } from '@/composables/useTemplateFilter'
import dayjs from 'dayjs'
import isoWeek from 'dayjs/plugin/isoWeek'
import { storeToRefs } from 'pinia'
import { useTimeStore } from '@/stores/TimeStore'

dayjs.extend(isoWeek)
const { formatDuration } = useTemplateFilter()

const timeStore = useTimeStore()
const { timeStats } = storeToRefs(timeStore)
</script>

<template>
  <div class="mb-3 rounded-md shadow border-stone-100 bg-white text-sm grid grid-cols-9 text-center divide-x w-full mx-64 border-t">
    <div class="py-3 ">
      <div class="text-sm font-medium">
        {{ timeStats?.week }}.
      </div>
      <div class="text-xs text-gray-500 pt-0.5">
        KW
      </div>
    </div>
    <div
      v-for="(value, key) in timeStats?.sumByWeekday"
      :key="key"
      class="py-3"
    >
      <div class="text-sm font-medium">
        {{ formatDuration(value) }}
      </div>
      <div class="text-xs text-gray-500 pt-0.5">
        {{ key }}
      </div>
    </div>
    <div class="py-3">
      <div class="text-sm font-medium">
        {{ formatDuration(timeStats?.sumWeek || 0) }}
      </div>
      <div class="text-xs text-gray-500 pt-0.5">
        Summe
      </div>
    </div>
  </div>
</template>
