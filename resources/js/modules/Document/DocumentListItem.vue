<script lang="ts" setup>
import type { Document } from '@/api/Document'
import { IconPrinter } from '@tabler/icons-vue'
import {
  TableCell,
  TableRow
} from '@/components/shdn/ui/table'
import { useTemplateFilter } from '@/composables/useTemplateFilter'
const { formatDate, formatNumber } = useTemplateFilter()

export interface Props {
  item: Document
}

defineProps<Props>()
defineEmits(['select'])

</script>
<template>
  <TableRow>
    <TableCell class="">
      {{ formatDate(item.issued_on) }}
    </TableCell>
    <TableCell class="truncate">
      {{ item.org_file }}
    </TableCell>
    <TableCell class="truncate">
      {{ item.contact?.reverse_full_name || item.sender }}
    </TableCell>
    <TableCell
      class="truncate"
    >
      {{ item.alternate_subject }}
    </TableCell>
    <TableCell />
  </TableRow>
</template>
