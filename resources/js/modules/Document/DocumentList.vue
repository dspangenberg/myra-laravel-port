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
import { useDocumentStore } from '@/stores/DocumentStore'
import DocumentListItem from './DocumentListItem.vue'
import {
  Table,
  TableHeader,
  TableRow,
  TableHead,
  TableBody
} from '@/components/shdn/ui/table'

const router = useRouter()
const route = useRoute()
const documentStore = useDocumentStore()
const { documents, meta, isLoading } = storeToRefs(documentStore)

const qs = computed(() => route.query)
const { queryString } = useLaravelQuery(['page'], { type: 'list' })

const onSelect = async (id: number) => {
}

watch(qs, async () => {
  await documentStore.getAll(queryString.value)
}, { immediate: true })

const onUpdatePage = (page: number) => {
  router.push({ query: { ...qs.value, page } })
}

onMounted(async () => {
  documentStore.getAll()
})

</script>

<template>
  <twice-ui-page-layout
    max-width="full"
    title="Inbox"
  >
    <template #breadcrumbs>
      <Breadcrumb>
        <BreadcrumbList>
          <BreadcrumbItem>
            <BreadcrumbLink href="/app/">
              Dashboard
            </BreadcrumbLink>
          </BreadcrumbItem>
          <BreadcrumbSeparator />
          <BreadcrumbSeparator />
          <BreadcrumbItem>
            <BreadcrumbPage>Dokumente</BreadcrumbPage>
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
            :record-count="documents?.length"
            record-name="Dokumente"
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
                  <TableHead class="w-96">
                    Datei
                  </TableHead>
                  <TableHead class="w-72">
                    Absender
                  </TableHead>
                  <TableHead class="w-full truncate">
                    Beteff
                  </TableHead>
                  <TableHead class="w-auto" />
                </TableRow>
              </TableHeader>
              <TableBody>
                <DocumentListItem
                  v-for="(document, index) in documents"
                  :key="index"
                  :item="document"
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
