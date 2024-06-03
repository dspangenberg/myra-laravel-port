<script lang="ts" setup>
import type { Time } from '@/api/Time'
import { IconChevronRight, IconClockDollar, IconClockRecord, IconLockExclamation, IconClockX } from '@tabler/icons-vue'
import {
  TableCell,
  TableRow
} from '@/components/shdn/ui/table'
import { useTemplateFilter } from '@/composables/useTemplateFilter'
const { durationUntilNow, formatDate, formatDuration } = useTemplateFilter()

export interface Props {
  item: Time
}

defineProps<Props>()
defineEmits(['select'])

</script>
<template>
  <TableRow @click="$emit('select', item.id)">
    <TableCell class="w-12 max-w-12 min-w-12 text-center pr-0">
      <template v-if="item.is_locked">
        <IconLockExclamation
          class="size-6 text-red-600"
          stroke-width="1.5"
        />
      </template>
      <template v-else>
        <template v-if="!item.end_at">
          <IconClockRecord
            class="size-6 text-blue-600"
            stroke-width="1.5"
          />
        </template>
        <template v-else>
          <IconClockX
            v-if="!item.is_billable"
            class="size-6 text-stone-600"
            stroke-width="1.5"
          />
          <IconClockDollar
            v-if="item.is_billable"
            class="size-6 text-indigo-400"
            stroke-width="1.5"
          />
        </template>
      </template>
    </TableCell>
    <TableCell class="max-w-40 w-40 text-sm pl-0">
      <p class="font-medium">
        {{ formatDate(item.begin_at, 'HH:mm') }} <span v-if="item.end_at">- {{ formatDate(item.end_at, 'HH:mm') }}</span>
      </p>
      <p class="text-stone-500 truncate">
        {{ item?.category?.name }}
      </p>
    </TableCell>
    <TableCell class="text-sm w-auto">
      <p class="font-medium">
        {{ item.project?.name }}
      </p>
      <p class="truncate text-sm text-gray-500 pt-1 line-clamp-2">
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
      <template v-if="item.end_at">
        {{ formatDuration(item.mins) }}
      </template>
      <template v-else>
        <span class="text-red-600 animate-pulse">
          {{ durationUntilNow(item.begin_at) }}
        </span>
      </template>
    </TableCell>
    <TableCell class="w-12">
      <IconChevronRight
        class="size-5 text-stone-500"
        stroke-width="1.5"
      />
    </TableCell>
  </TableRow>
</template>
