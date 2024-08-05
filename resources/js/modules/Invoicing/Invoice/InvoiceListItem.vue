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
import { computed } from 'vue'
const invoiceStore = useInvoiceStore()
const { formatDate, formatNumber, round } = useTemplateFilter()

export interface Props {
  item: Invoice
}

const props = defineProps<Props>()

const amountGross = computed(() => round(props.item.lines_sum_amount + props.item.lines_sum_tax))
const amountOpen = computed(() => amountGross.value < 0 ? 0 : Math.abs(props.item.payments_sum_amount - amountGross.value))

const onCreatePdf = async (invoice: Invoice) => {
  const { dataUrl: resUrl, base64: resBase64 } = await invoiceStore.createPdf(invoice.id as unknown as number)
  await promptModal('pdfViewer', {
    base64: resBase64,
    dataUrl: resUrl,
    filename: invoice.filename
  })
}

defineEmits(['select'])

</script>
<template>
  <TableRow :class="amountOpen > 0 ? 'bg-red-50 text-red-500' :''">
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
      {{ formatNumber(amountGross) }}
    </TableCell>
    <TableCell
      class="text-right "
    >
      {{ formatNumber(amountOpen) }}
    </TableCell>
    <TableCell>
      <ShdnUiButton
        v-if="item.id"
        size="icon"
        variant="ghost"
        @click="onCreatePdf(item)"
      >
        <IconPrinter
          class="size-5"
        />
      </ShdnUiButton>
    </TableCell>
    <TableCell />
  </TableRow>
</template>
