<script lang="ts" setup>
import {
  Breadcrumb,
  BreadcrumbItem,
  BreadcrumbLink,
  BreadcrumbList,
  BreadcrumbPage,
  BreadcrumbSeparator
} from '@/components/shdn/ui/breadcrumb'
import { useLaravelQuery } from '@/composables/useLaravelQuery'

import { storeToRefs } from 'pinia'
import { computed, onMounted, ref, watch } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useReceiptStore } from '@/stores/ReceiptStore'
import ReceiptDetails from './ReceiptDetails.vue'
import ReceiptGroupedListItem from './ReceiptGroupedListItem.vue'
import {
  Table,
  TableHeader,
  TableRow,
  TableHead,
  TableBody
} from '@/components/shdn/ui/table'
import { useTemplateFilter } from '@/composables/useTemplateFilter'
const { formatDate, formatNumber } = useTemplateFilter()

const router = useRouter()
const route = useRoute()
const receiptStore = useReceiptStore()
const { receipt, receipts, meta, isLoading, groupedReceipts } = storeToRefs(receiptStore)

const qs = computed(() => route.query)
const { queryString } = useLaravelQuery(['page'], { type: 'grouped' })

const onSelect = async (id: number) => {
  await receiptStore.findById(id)
}

watch(qs, async () => {
  await receiptStore.getAll(queryString.value)
}, { immediate: true })

const onUpdatePage = (page: number) => {
  router.push({ query: { ...qs.value, page } })
}

onMounted(() => {
  receiptStore.receipt = null
})

</script>

<template>
  <twice-ui-page-layout title="Belege (gruppiert)">
    <template #breadcrumbs>
      <Breadcrumb>
        <BreadcrumbList>
          <BreadcrumbItem>
            <BreadcrumbLink href="/app/">
              Dashboard
            </BreadcrumbLink>
          </BreadcrumbItem>
          <BreadcrumbSeparator />
          <BreadcrumbItem>
            <BreadcrumbLink href="/app/">
              Fakturierung + Fibu
            </BreadcrumbLink>
          </BreadcrumbItem>
          <BreadcrumbSeparator />
          <BreadcrumbItem>
            <BreadcrumbPage>Belege</BreadcrumbPage>
          </BreadcrumbItem>
        </BreadcrumbList>
      </Breadcrumb>
    </template>
    <template #header-pivot>
      <twice-ui-pivot>
        <twice-ui-pivot-item
          :route-params="{type: 'list'}"
          active-route-path="/app/invoicing/receipts/list"
          label="Belegliste"
          route-name="receipts-list"
        />
        <twice-ui-pivot-item
          :active-route-query="{view: 'debitors'}"
          :route-query="{view: 'debitors', type: 'grouped'}"
          active-route-path="/app/invoicing/receipts/grouped"
          disabled
          label="Debitoren"
          route-name="receipts-grouped-list"
        />
        <twice-ui-pivot-item
          :active-route-query="{view: 'creditors'}"
          :route-query="{view: 'creditors', type: 'grouped'}"
          active-route-path="/app/invoicing/receipts/grouped"
          label="Kreditoren"
          route-name="receipts-grouped-list"
        />
        <twice-ui-pivot-item
          :active-route-query="{view: 'categories'}"
          :route-query="{view: 'categories', type: 'grouped'}"
          active-route-path="/app/invoicing/receipts/grouped"
          disabled
          label="Kategorien"
          route-name="receipts-grouped-list"
        />
      </twice-ui-pivot>
    </template>
    <template #content-full>
      <div class="px-0.5 flex space-x-8 mt-6 overflow-hidden">
        <div class="flex-1">
          <twice-ui-table-box
            :loading="isLoading"
            :meta="meta"
            :record-count="5"
            record-name="Belege"
            @update-page="onUpdatePage"
          >
            <div
              v-for="(value, key) in groupedReceipts"
              :key="key"
            >
              <h2 class="text-xl font-semibold mb-4">
                {{ value.name }}
              </h2>
              <Table>
                <TableHeader>
                  <TableRow>
                    <TableHead class="w-24">
                      Datum
                    </TableHead>
                    <TableHead class="w-124">
                      Kategorie / Referenz
                    </TableHead>
                    <TableHead class="w-28 text-center">
                      Brutto
                    </TableHead>
                    <TableHead class="w-28 text-center">
                      USt. (85)
                    </TableHead>
                    <TableHead class="w-28 text-center">
                      USt. (67)
                    </TableHead>
                    <TableHead class="w-28 text-center">
                      Netto
                    </TableHead>
                    <TableHead class="w-auto" />
                  </TableRow>
                </TableHeader>
                <TableBody>
                  <ReceiptGroupedListItem
                    v-for="(r, index) in value.entries"
                    :key="index"
                    :item="r"
                    @select="onSelect"
                  />
                </TableBody>
                <TableBody>
                  <TableRow class="border-t font-medium bg-stone-50 divide-x">
                    <TableHead />
                    <TableHead />
                    <TableHead class="text-right">
                      {{ formatNumber(value.sum_gross) }}
                    </TableHead>
                    <TableHead class="text-right">
                      <div v-if="value.sum_tax_85">
                        {{ formatNumber(value.sum_tax_85) }}
                      </div>
                    </TableHead>
                    <TableHead class="text-right">
                      <div v-if="value.sum_tax_67">
                        {{ formatNumber(value.sum_tax_67) }}
                      </div>
                    </TableHead>
                    <TableHead class="text-right">
                      {{ formatNumber(value.sum_net) }}
                    </TableHead>
                    <TableHead class="w-auto" />
                  </TableRow>
                </TableBody>
              </Table>
            </div>
          </twice-ui-table-box>
        </div>
      </div>
    </template>
  </twice-ui-page-layout>
</template>
