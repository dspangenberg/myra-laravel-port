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
  <TableRow @click="$emit('select', item.id)">
    <TableCell>
      {{ formatDate(item.issued_on) }}
      <div class="text-xs text-gray-400">
        {{ item.real_document_number }}
      </div>
    </TableCell>
    <TableCell
      v-tooltip="item.contact.full_name"
      class="truncate"
    >
      {{ item.contact.full_name }}
      <div class="text-sm text-gray-400">
        {{ item.category.name }}
      </div>
    </TableCell>
    <TableCell class="text-right">
      {{ formatNumber(item.gross) }}
      <div class="text-xs text-gray-400">
        <span v-if="item.currency_code !== 'EUR'">
          ({{ formatNumber(item.amount) }} {{ item.currency_code }})
        </span>
      </div>
    </TableCell>
    <TableCell class="text-right">
      {{ formatNumber(item.tax) }}
      <div class="text-xs text-gray-400">
        ({{ item.tax_code_number }})
      </div>
    </TableCell>
    <TableCell class="text-right">
      {{ formatNumber(item.net) }}
    </TableCell>
  </TableRow>
</template>
