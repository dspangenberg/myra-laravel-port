<script lang="ts" setup>
import { storeToRefs } from 'pinia'
import { useReceiptStore } from '@/stores/ReceiptStore'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/shdn/ui/card'
import { useTemplateFilter } from '@/composables/useTemplateFilter'
import { Separator } from '@/components/shdn/ui/separator'
const { formatDate, formatNumber } = useTemplateFilter()

const receiptStore = useReceiptStore()
const { receipt } = storeToRefs(receiptStore)

</script>
<template>
  <Card
    v-if="receipt"
    class="overflow-hidden w-96"
  >
    <CardHeader class="flex flex-row items-start bg-muted/50">
      <div class="grid gap-0.5">
        <CardTitle class="group flex items-center gap-2 text-lg truncate">
          {{ receipt.real_document_number }}
        </CardTitle>
      </div>
    </CardHeader>
    <CardContent class="p-6 text-base">
      <div class="grid gap-3">
        <ul class="grid gap-3 ">
          <li class="flex flex-col space-y-0.5">
            <span class="text-muted-foreground">
              Datum:
            </span>
            <span>
              {{ formatDate(receipt.issued_on) }}
            </span>
          </li>
          <li class="flex flex-col">
            <span class="text-muted-foreground">
              Kreditor:
            </span>
            <span>
              {{ receipt.contact.full_name }}
            </span>
          </li>

          <li class="flex flex-col">
            <span class="text-muted-foreground">
              Referenz:
            </span>
            <span>
              {{ receipt.reference }}
            </span>
          </li>
          <li class="flex flex-col">
            <span class="text-muted-foreground">
              Kategorie:
            </span>
            <span>
              {{ receipt.category.name }}
            </span>
          </li>
        </ul>
        <Separator class="my-4" />
        <div class="font-semibold">
          Rechnungsbeträge:
        </div>
        <ul class="grid gap-3 ">
          <li class="flex items-center justify-between ">
            <span class="text-muted-foreground">
              Bruttobetrag:
            </span>
            <span class="text-right">
              {{ formatNumber(receipt.gross, 2) }} EUR
            </span>
          </li>
          <li class="flex items-center justify-between ">
            <span class="text-muted-foreground">
              Umsatzsteuer ({{ receipt.tax_code_number }}):
            </span>
            <span class="text-right">
              {{ formatNumber(receipt.tax, 2) }} EUR
            </span>
          </li>
          <li class="flex items-center justify-between ">
            <span class="text-muted-foreground">
              Netto:
            </span>
            <span class="text-right">
              {{ formatNumber(receipt.net, 2) }} EUR
            </span>
          </li>
        </ul>
        <Separator class="my-4" />
        <template v-if="receipt.currency_code !== 'EUR'">
          <div class="font-semibold">
            Währungsumrechnung:
          </div>
          <ul class="grid gap-3 ">
            <li class="flex items-center justify-between ">
              <span class="text-muted-foreground">
                Rechnungsbetrag in Fremdwährung:
              </span>
              <span class="text-right">
                {{ formatNumber(receipt.amount, 2) }} {{ receipt.currency_code }}
              </span>
            </li>
            <li class="flex items-center justify-between ">
              <span class="text-muted-foreground">
                Umrechnungskurs:
              </span>
              <span class="text-right">
                {{ formatNumber(receipt.exchange_rate, 4) }}
              </span>
            </li>
          </ul>
        </template>
      </div>
    </CardContent>
  </Card>
</template>
