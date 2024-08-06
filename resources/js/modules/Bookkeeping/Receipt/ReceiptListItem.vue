<script lang="ts" setup>
import type { Receipt } from '@/api/Receipt'
import {
  TableCell,
  TableRow
} from '@/components/shdn/ui/table'

import { useTemplateFilter } from '@/composables/useTemplateFilter'
import { computed } from 'vue'
const { formatDate, formatNumber, round } = useTemplateFilter()
export interface Props {
  item: Receipt
}

const props = defineProps<Props>()

const amountOpen = computed(() => round(props.item.payable_sum_amount - props.item.gross))

defineEmits(['select'])

</script>
<template>
  <TableRow :class="amountOpen > 0 ? 'bg-red-50 text-red-500' :''">
    <TableCell>
      {{ item.id }}
    </TableCell>
    <TableCell>
      {{ formatDate(item.issued_on) }}
    </TableCell>
    <TableCell class="truncate">
      {{ item.contact.full_name }}
    </TableCell>
    <TableCell class="truncate">
      {{ item.reference }}
    </TableCell>

    <TableCell
      v-tooltip="item.category.name"
      class="truncate"
    >
      {{ item.category.name }}
    </TableCell>
    <TableCell
      :class="item.amount < 0 ? 'text-red-600' : 'text-green-600'"
      class="text-right "
    >
      {{ formatNumber(item.net) }}
      <div
        :class="item.amount < 0 ? 'text-red-600' : 'text-green-600'"
        class="text-xs !text-gray-400"
      >
        <span v-if="item.currency_code !== 'EUR'">
          ({{ formatNumber(item.amount) }} {{ item.currency_code }})
        </span>
      </div>
    </TableCell>
    <TableCell
      :class="item.amount < 0 ? 'text-red-600' : 'text-green-600'"
      class="text-right"
    >
      {{ formatNumber(item.tax) }}
      <div
        :class="item.amount < 0 ? 'text-red-600' : 'text-green-600'"
        class="text-xs !text-gray-400"
      >
        ({{ item.tax_code_number }})
      </div>
    </TableCell>
    <TableCell
      :class="item.amount < 0 ? 'text-red-600' : 'text-green-600'"
      class="text-right"
    >
      {{ formatNumber(item.gross) }}
    </TableCell>
    <TableCell
      class="text-right "
    >
      {{ formatNumber(amountOpen) }}
    </TableCell>
  </TableRow>
</template>
