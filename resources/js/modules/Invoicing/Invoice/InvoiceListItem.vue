<script lang="ts" setup>
import type { Invoice } from '@/api/Invoice'
import { IconPrinter } from '@tabler/icons-vue'
import {
  TableCell,
  TableRow
} from '@/components/shdn/ui/table'
import { useInvoiceStore } from '@/stores/InvoiceStore'

import { useTemplateFilter } from '@/composables/useTemplateFilter'
import { promptModal } from 'jenesius-vue-modal'
const invoiceStore = useInvoiceStore()
const { formatDate, formatNumber } = useTemplateFilter()

export interface Props {
  item: Invoice
}

const onCreatePdf = async (id: number) => {
  const { dataUrl: resUrl, base64: resBase64 } = await invoiceStore.createPdf(id)
  await promptModal('pdfViewer', {
    base64: resBase64,
    dataUrl: resUrl
  })
}

defineProps<Props>()
defineEmits(['select'])

</script>
<template>
  <TableRow>
    <TableCell class="">
      {{ formatDate(item.issued_on) }}
    </TableCell>
    <TableCell class="">
      {{ item.formated_invoice_number }}
    </TableCell>
    <TableCell
      class="truncate"
    >
      {{ item.contact?.full_name }}
    </TableCell>
    <TableCell
      class="truncate"
    >
      {{ item.project?.name }}
    </TableCell>
    <TableCell class="text-right ">
      {{ formatNumber(item.lines_sum_amount) }}
    </TableCell>
    <TableCell class="text-right ">
      {{ formatNumber(item.lines_sum_tax) }}
    </TableCell>
    <TableCell class="text-right ">
      {{ formatNumber(item.lines_sum_amount + item.lines_sum_tax) }}
    </TableCell>
    <TableCell class="text-right ">
      {{ formatNumber(0) }}
    </TableCell>
    <TableCell>
      <ShdnUiButton
        v-if="item.id"
        size="icon"
        variant="ghost"
        @click="onCreatePdf(item.id)"
      >
        <IconPrinter
          class="size-5"
        />
      </ShdnUiButton>
    </TableCell>
    <TableCell />
  </TableRow>
</template>
