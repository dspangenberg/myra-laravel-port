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
  <TableRow
    class="divide-x"
    @click="$emit('select', item.id)"
  >
    <TableCell>
      {{ item.issued_on }}
      <div class="text-xs text-gray-400 ">
        {{ item.real_document_number }}
      </div>
    </TableCell>
    <TableCell
      class="truncate"
    >
      {{ item.category.name }}
      <div class="text-xs text-gray-400 truncate">
        {{ item.reference }}
      </div>
    </TableCell>
    <TableCell class="text-right">
      {{ formatNumber(item.net) }}
      <div class="text-xs text-gray-400">
        <span v-if="item.currency_code !== 'EUR'">
          ({{ formatNumber(item.amount) }} {{ item.currency_code }})
        </span>
      </div>
    </TableCell>

    <TableCell class="text-right">
      <div v-if="item.tax_code_number === '67'">
        {{ formatNumber(item.tax) }}
      </div>
    </TableCell>
    <TableCell class="text-right">
      <div v-if="item.tax_code_number === '81'">
        {{ formatNumber(item.tax) }}
      </div>
    </TableCell>
    <TableCell class="text-right">
      <div v-if="item.tax_code_number === '85'">
        {{ formatNumber(item.tax) }}
      </div>
    </TableCell>
    <TableCell class="text-right">
      {{ formatNumber(item.gross) }}
    </TableCell>
    <TableCell class="text-right">
      {{ formatNumber(item.amount_to_pay) }}
    </TableCell>
    <TableCell class="w-auto" />
  </TableRow>
</template>
