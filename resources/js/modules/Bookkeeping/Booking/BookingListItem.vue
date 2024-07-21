<script lang="ts" setup>
import type { Booking } from '@/api/Booking'

import {
  TableCell,
  TableRow
} from '@/components/shdn/ui/table'

import { useTemplateFilter } from '@/composables/useTemplateFilter'
const { formatDate, formatNumber } = useTemplateFilter()

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
    </TableCell>
    <TableCell class="align-top">
      {{ item.document_number }}
    </TableCell>
    <TableCell
      v-tooltip="item.booking_text"
      class="align-top"
    >
      {{ item.booking_text }}
    </TableCell>
    <TableCell class="text-right align-top">
      {{ formatNumber(item.amount) }}
    </TableCell>
    <TableCell class="text-right align-top">
      {{ formatNumber(item.tax?.value || 0) }}
    </TableCell>
    <TableCell
      v-tooltip="item.account_debit?.label"
      class="truncate align-top"
    >
      {{ item.account_debit?.label }}
    </TableCell>
    <TableCell
      v-tooltip="item.account_credit?.label"
      class="truncate align-top"
    >
      {{ item.account_credit?.label }}
    </TableCell>
    <TableCell class="text-right align-top">
      {{ formatNumber(item.tax_debit || 0) }}
    </TableCell>
    <TableCell class="text-right align-top">
      {{ formatNumber(item.tax_credit || 0) }}
    </TableCell>
  </TableRow>
</template>
