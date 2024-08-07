<script lang="ts" setup>
import type { Booking } from '@/api/Booking'

import {
  TableCell,
  TableRow
} from '@/components/shdn/ui/table'

import { useTemplateFilter } from '@/composables/useTemplateFilter'
const { formatDate, formatNumber, splitBookingText } = useTemplateFilter()

export interface Props {
  item: Booking
}

defineProps<Props>()
defineEmits(['select'])

</script>
<template>
  <TableRow>
    <TableCell class="align-top">
      {{ formatDate(item.date) }}
      <div class="text-sm text-gray-400">
        #{{ item.id }}
      </div>
    </TableCell>
    <TableCell class="align-top">
      {{ item.document_number }}
    </TableCell>
    <TableCell
      v-tooltip="item.booking_text"
      class="align-top"
    >
      <span v-html="splitBookingText(item.booking_text)" />
      <span
        v-if="item.note"
        class="text-red-500"
      >
        {{ item.note }}
      </span>
    </TableCell>
    <TableCell class="text-right align-top">
      {{ formatNumber(item.amount) }}
    </TableCell>
    <TableCell class="text-right align-top">
      {{ formatNumber(item.tax?.value || 0) }}
    </TableCell>
    <TableCell
      v-tooltip="item.account_debit?.label"
      class="align-top"
    >
      <div class="flex gap-x-2">
        <div class="w-12 text-right flex-none">
          {{ item.account_debit?.account_number }}
        </div>
        <div class="flex-1 truncate">
          {{ item.account_debit?.name }}
        </div>
      </div>
    </TableCell>
    <TableCell
      v-tooltip="item.account_credit?.label"
      class="align-top"
    >
      <div class="flex gap-x-2">
        <div class="w-12 text-right flex-none">
          {{ item.account_credit?.account_number }}
        </div>
        <div class="flex-1 truncate">
          {{ item.account_credit?.name }}
        </div>
      </div>
    </TableCell>
    <TableCell class="text-right align-top">
      {{ formatNumber(item.tax_debit || 0) }}
    </TableCell>
    <TableCell class="text-right align-top">
      {{ formatNumber(item.tax_credit || 0) }}
    </TableCell>
  </TableRow>
</template>
