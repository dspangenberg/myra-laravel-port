<script lang="ts" setup>
import type { GroupedEntries, Time } from '@/api/Time'
import {
  Table,
  TableBody
} from '@/components/shdn/ui/table'
import { useTemplateFilter } from '@/composables/useTemplateFilter'
import TimeListItem from './TimeListItem.vue'
import { useTimeStore } from '@/stores/TimeStore'
import { useRouter, useRoute } from 'vue-router'
const router = useRouter()
const route = useRoute()

const timeStore = useTimeStore()
const { formatDate, formatDuration } = useTemplateFilter()
export interface Props {
  date: string
  sum: number
  entries: GroupedEntries
}

defineProps<Props>()

const onSelect = async (id: number) => {
  await timeStore.createOrEdit(id)
  router.push({ name: 'times-edit', params: { id, type: route.params.type }, query: route.query })
}
defineEmits(['select'])
</script>
<template>
  <div
    class="mb-6"
  >
    <div
      class="flex items-center justify-between text-sm"
    >
      <div
        class="font-medium pl-3.5 pb-1"
      >
        {{ formatDate(date, 'dd. DD. MMMM YYYY', 'en') }}
      </div>
      <div class="font-medium pr-14 pb-1 text-right">
        {{ formatDuration(sum) }}
      </div>
    </div>
    <div>
      <Table>
        <TableBody>
          <TimeListItem
            v-for="(time, index) in entries"
            :key="index"
            :item="time as unknown as Time"
            @select="onSelect"
          />
        </TableBody>
      </Table>
    </div>
  </div>
</template>
