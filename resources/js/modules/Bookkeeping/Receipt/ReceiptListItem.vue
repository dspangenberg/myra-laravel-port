<script lang="ts" setup>
import type { Receipt } from '@/api/Receipt'
import {
  TableCell,
  TableRow
} from '@/components/shdn/ui/table'

import { useTemplateFilter } from '@/composables/useTemplateFilter'
const { formatDate, formatNumber } = useTemplateFilter()

export interface Props {
  item: Receipt
}

defineProps<Props>()
defineEmits(['select'])

</script>
<template>
  <TableRow>
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
  </TableRow>
</template>
