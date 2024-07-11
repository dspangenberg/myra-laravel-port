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
import ReceiptListItem from './ReceiptListItem.vue'
import {
  Table,
  TableHeader,
  TableRow,
  TableHead,
  TableBody
} from '@/components/shdn/ui/table'

const router = useRouter()
const route = useRoute()
const receiptStore = useReceiptStore()
const { receipt, receipts, meta, isLoading } = storeToRefs(receiptStore)

const qs = computed(() => route.query)
const { queryString } = useLaravelQuery(['page'], { type: 'list' })

const onSelect = async (id: number) => {
  await receiptStore.findById(id)
}

watch(qs, async () => {
  if (route.name === 'receipts-list') {
    await receiptStore.getAll(queryString.value)
  }
}, { immediate: true })

const onUpdatePage = (page: number) => {
  router.push({ query: { ...qs.value, page } })
}

onMounted(() => {
  receiptStore.receipt = null
})

</script>

<template>
  <twice-ui-page-layout title="Belege">
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
          :route-query="{view: 'debitors'}"
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
          :route-query="{view: 'categories'}"
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
            :record-count="receipts?.length"
            record-name="Kontakte"
            @update-page="onUpdatePage"
          >
            <template #header>
              <router-view />
            </template>
            <Table>
              <TableHeader>
                <TableRow>
                  <TableHead class="w-24">
                    Datum
                  </TableHead>
                  <TableHead class="w-48">
                    Kreditor
                  </TableHead>
                  <TableHead class="w-28 text-right">
                    Brutto
                  </TableHead>
                  <TableHead class="w-28 text-right">
                    Steuer
                  </TableHead>
                  <TableHead class="w-28 text-right">
                    Netto
                  </TableHead>
                  <TableHead class="w-auto" />
                </TableRow>
              </TableHeader>
              <TableBody>
                <ReceiptListItem
                  v-for="(receipt, index) in receipts"
                  :key="index"
                  :item="receipt"
                  @select="onSelect"
                />
              </TableBody>
            </Table>
          </twice-ui-table-box>
        </div>
        <div class="flex-none overflow-hidden w-96">
          <template v-if="receipt">
            <ReceiptDetails />
          </template>
        </div>
      </div>
    </template>
  </twice-ui-page-layout>
</template>
