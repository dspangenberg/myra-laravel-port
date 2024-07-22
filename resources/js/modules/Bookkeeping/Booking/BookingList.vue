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
import { useBookingStore } from '@/stores/BookingStore'
import BookingListItem from './BookingListItem.vue'
import {
  Table,
  TableHeader,
  TableRow,
  TableHead,
  TableBody
} from '@/components/shdn/ui/table'

const router = useRouter()
const route = useRoute()
const bookingStore = useBookingStore()
const { bookings, meta, isLoading } = storeToRefs(bookingStore)

const qs = computed(() => route.query)
const { queryString } = useLaravelQuery(['page'], { type: 'list' })

const onSelect = async (id: number) => {
}

watch(qs, async () => {
  await bookingStore.getAll(queryString.value)
}, { immediate: true })

const onUpdatePage = (page: number) => {
  router.push({ query: { ...qs.value, page } })
}

</script>

<template>
  <twice-ui-page-layout title="Buchungen">
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

    <template #content-full>
      <div class="px-0.5 flex space-x-8 mt-6 overflow-hidden">
        <div class="flex-1">
          <twice-ui-table-box
            :loading="isLoading"
            :meta="meta"
            :record-count="bookings?.length"
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
                    Beleg
                  </TableHead>
                  <TableHead class="w-full truncate">
                    Buchungstext
                  </TableHead>
                  <TableHead class="w-28 text-right">
                    Brutto
                  </TableHead>
                  <TableHead class="w-20 text-right truncate">
                    USt.%
                  </TableHead>
                  <TableHead
                    class="w-44"
                  >
                    Soll-Konto
                  </TableHead>
                  <TableHead class="w-44">
                    Haben-Konto
                  </TableHead>
                  <TableHead class="w-20 text-right">
                    USt. Soll
                  </TableHead>
                  <TableHead class="w-20 text-right truncate">
                    USt. Haben
                  </TableHead>
                  <TableHead class="w-auto" />
                </TableRow>
              </TableHeader>
              <TableBody>
                <BookingListItem
                  v-for="(booking, index) in bookings"
                  :key="index"
                  :item="booking"
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
