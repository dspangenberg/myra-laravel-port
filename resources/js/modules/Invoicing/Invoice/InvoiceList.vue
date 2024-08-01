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
import { useInvoiceStore } from '@/stores/InvoiceStore'
import InvoiceListItem from './InvoiceListItem.vue'
import {
  Table,
  TableHeader,
  TableRow,
  TableHead,
  TableBody
} from '@/components/shdn/ui/table'

const router = useRouter()
const route = useRoute()
const invoiceStore = useInvoiceStore()
const { invoices, meta, isLoading } = storeToRefs(invoiceStore)

const qs = computed(() => route.query)
const { queryString } = useLaravelQuery(['page'], { type: 'list' })

const onSelect = async (id: number) => {
}

watch(qs, async () => {
  await invoiceStore.getAll(queryString.value)
}, { immediate: true })

const onUpdatePage = (page: number) => {
  router.push({ query: { ...qs.value, page } })
}

onMounted(async () => {
  invoiceStore.getAll()
})

</script>

<template>
  <twice-ui-page-layout title="Rechnungen">
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
            <BreadcrumbLink href="/app/invoicing">
              Fakturierung
            </BreadcrumbLink>
          </BreadcrumbItem>
          <BreadcrumbSeparator />
          <BreadcrumbItem>
            <BreadcrumbPage>Rechnungen</BreadcrumbPage>
          </BreadcrumbItem>
        </BreadcrumbList>
      </Breadcrumb>
    </template>

    <template #content-full>
      <div class="px-0.5 flex space-x-8 mt-6 overflow-hidden">
        <div class="flex-1">
          <twice-ui-table-box
            :loading="isLoading"
            :meta="meta"
            :record-count="invoices?.length"
            record-name="Buchungen"
            @update-page="onUpdatePage"
          >
            <template #header>
              <router-view />
            </template>
            <Table class="text-sm">
              <TableHeader>
                <TableRow class="items-start sticky top-0 z-50 pb-12 bg-gray-50">
                  <TableHead class="w-24 ">
                    Datum
                  </TableHead>
                  <TableHead class="w-36">
                    Rechnungsnr.
                  </TableHead>
                  <TableHead class="w-full truncate">
                    Debitor
                  </TableHead>
                  <TableHead class="w-64">
                    Projekt
                  </TableHead>
                  <TableHead class="w-24 text-right truncate">
                    Netto
                  </TableHead>
                  <TableHead
                    class="w-24 text-right"
                  >
                    Ust.
                  </TableHead>
                  <TableHead class="w-24 text-right">
                    Brutto
                  </TableHead>
                  <TableHead class="w-24 text-right">
                    Offen
                  </TableHead>
                  <TableHead class="w-24" />
                  <TableHead class="w-auto" />
                </TableRow>
              </TableHeader>
              <TableBody>
                <InvoiceListItem
                  v-for="(invoice, index) in invoices"
                  :key="index"
                  :item="invoice"
                  @select="onSelect"
                />
              </TableBody>
            </Table>
          </twice-ui-table-box>
        </div>
      </div>
    </template>
  </twice-ui-page-layout>
</template>
