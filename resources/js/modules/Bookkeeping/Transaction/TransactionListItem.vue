<script lang="ts" setup>
import type { Transaction } from '@/api/Transaction'
import {
  TableCell,
  TableRow
} from '@/components/shdn/ui/table'

import { useTemplateFilter } from '@/composables/useTemplateFilter'
import { computed } from 'vue'
const { formatDate, formatNumber, round, splitBookingText } = useTemplateFilter()
export interface Props {
  item: Transaction
}

const props = defineProps<Props>()

const amountOpen = computed(() => round(props.item.payable_sum_amount - props.item.amount))

defineEmits(['select'])

</script>
<template>
  <TableRow :class="amountOpen > 0 ? 'bg-red-50 text-red-500' :''">
    <TableCell class="align-top space-y-0.5">
      {{ formatDate(item.booked_on) }}
      <div class="text-sm text-gray-400">
        #{{ item.id }}
      </div>
    </TableCell>
    <TableCell class="align-top space-y-0.5">
      {{ item.document_number }}
    </TableCell>
    <TableCell class="align-top truncate">
      <div v-if="item.contact_id">
        {{ item.contact.full_name }}
      </div>
      <div v-if="item.is_private">
        Privat
      </div>
      <div v-if="item.is_transit">
        Geldtransfer
      </div>
      <div v-if="item.booking">
        {{ item.booking.account_id_debit }} / {{ item.booking.account_id_credit }}
      </div>
    </TableCell>
    <TableCell class="align-top">
      <span v-html="splitBookingText(item.bookkepping_text)" />
      <div class="text-sm text-gray-500 pt-0.5">
        {{ item.account_number }}
      </div>
    </TableCell>
    <TableCell
      :class="item.amount < 0 ? 'text-red-600' : 'text-green-600'"
      class="text-right align-top"
    >
      {{ formatNumber(item.amount) }}
      <div v-if="item.currency !== 'EUR'">
        ({{ formatNumber(item.amount_in_foreign_currency) }} {{ item.currency }})
      </div>
    </TableCell>
    <TableCell class="w-auto" />
  </TableRow>
</template>
