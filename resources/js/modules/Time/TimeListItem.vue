<script lang="ts" setup>
import type { Time } from '@/api/Time'
import { IconChevronRight, IconClock } from '@tabler/icons-vue'
import {
  TableCell,
  TableRow
} from '@/components/shdn/ui/table'
import { useTemplateFilter } from '@/composables/useTemplateFilter'
const { formatDate, formatDuration } = useTemplateFilter()

export interface Props {
  item: Time
}

defineProps<Props>()
defineEmits(['select'])

</script>
<template>
  <TableRow @click="$emit('select', item.id)">
    <TableCell class="w-12 max-w-12 min-w-12 text-center pr-0">
      <IconClock
        class="size-6 text-stone-400"
        stroke-width="1.5"
      />
    </TableCell>
    <TableCell class="max-w-40 w-40 text-sm pl-0">
      <p class="font-medium">
        {{ formatDate(item.begin_at, 'HH:mm') }} - {{ formatDate(item.end_at, 'HH:mm') }}
        <span class="text-stone-500 pl-1">
          ({{ item?.category?.short_name }})
        </span>
      </p>
    </TableCell>
    <TableCell class="text-sm w-auto">
      <p class="font-medium">
        {{ item.project?.name }}
      </p>
      <p class="truncate text-sm text-gray-500 pt-1 line-clamp-1">
        {{ item?.note }}
      </p>
    </TableCell>
    <TableCell class="text-sm w-12">
      <twice-ui-avatar
        size="xs"
        :avatar="item.user?.avatar_url"
        :fullname="item.user?.full_name"
        :initials="item.user?.initials"
      />
    </TableCell>
    <TableCell class="text-sm font-medium w-12 text-stone-700">
      {{ formatDuration(item.mins) }}
    </TableCell>
    <TableCell class="w-12">
      <IconChevronRight
        class="size-5 text-stone-500"
        stroke-width="1.5"
      />
    </TableCell>
  </TableRow>
</template>
