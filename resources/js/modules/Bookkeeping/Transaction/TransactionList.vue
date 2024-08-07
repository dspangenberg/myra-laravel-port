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
import { computed, onMounted, watch } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useTransactionStore } from '@/stores/TransactionStore'
import TransactionListItem from './TransactionListItem.vue'
import {
  Table,
  TableHeader,
  TableRow,
  TableHead,
  TableBody
} from '@/components/shdn/ui/table'

const router = useRouter()
const route = useRoute()
const transactionStore = useTransactionStore()
const { transactions, meta, isLoading, bank_accounts } = storeToRefs(transactionStore)

const qs = computed(() => route.query)
const { queryString } = useLaravelQuery(['page'], { type: 'list' })

watch(qs, async () => {
  if (route.name === 'transactions-list') {
    await transactionStore.getAll(queryString.value)
  }
}, { immediate: true })

const onUpdatePage = (page: number) => {
  router.push({ query: { ...qs.value, page } })
}

onMounted(() => {
  transactionStore.getAll()
})

</script>

<template>
  <twice-ui-page-layout title="Transaktionen">
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
          v-for="bank_account in bank_accounts"
          :active-route-query="{bank_account: bank_account.id}"
          :label="bank_account.name"
          :route-query="{bank_account: bank_account.id}"
          active-route-path="/app/invoicing/transactions"
          route-name="transactions-list"
        />
        <twice-ui-pivot-item
          :route-params="{type: 'list'}"
          active-route-path="/app/invoicing/transactions"
          disabled
          label="Transaktionen ohne Beleg"
          route-name="transactions-list"
        />
      </twice-ui-pivot>
    </template>
    <template #content-full>
      <div class="px-0.5 flex space-x-8 mt-6 overflow-hidden">
        <div class="flex-1">
          <twice-ui-table-box
            :loading="isLoading"
            :meta="meta"
            :record-count="transactions?.length"
            record-name="Transaktionen"
            @update-page="onUpdatePage"
          >
            <template #header>
              <router-view />
            </template>
            <Table class="text-sm">
              <TableHeader>
                <TableRow class="align-top">
                  <TableHead class="w-24">
                    Datum
                  </TableHead>
                  <TableHead class="w-32">
                    Belegnr.
                  </TableHead>
                  <TableHead class="w-64">
                    Kontakt
                  </TableHead>
                  <TableHead class="w-auto">
                    Buchungstext
                  </TableHead>
                  <TableHead class="w-32 text-right">
                    Betrag
                  </TableHead>
                  <TableHead class="w-16" />
                </TableRow>
              </TableHeader>
              <TableBody>
                <TransactionListItem
                  v-for="(transaction, index) in transactions"
                  :key="index"
                  :item="transaction"
                />
              </TableBody>
            </Table>
          </twice-ui-table-box>
        </div>
      </div>
    </template>
  </twice-ui-page-layout>
</template>
