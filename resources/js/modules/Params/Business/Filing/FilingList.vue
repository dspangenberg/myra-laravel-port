<script lang="ts" setup>
import { storeToRefs } from 'pinia'
import { onMounted, ref, watch } from 'vue'
import { useRouter } from 'vue-router'
import { useFilingStore } from '@/stores/params/FilingStore'
import FilingListItem from './FilingListItem.vue'
import {
  Table,
  TableHeader,
  TableRow,
  TableHead,
  TableBody
} from '@/components/shdn/ui/table'

const router = useRouter()
const filingStore = useFilingStore()
const { filings, meta, isLoading } = storeToRefs(filingStore)

const currentPage = ref(1)

const onSelect = async (id: number) => {
  await filingStore.findById(id)
  router.push({
    name: 'params-business-filings-edit', params: { id }
  })
}

watch(currentPage, async (page) => {
  await filingStore.getAll(page)
})

onMounted(async () => {
  await filingStore.getAll()
})

const onUpdatePage = (page: number) => {
  currentPage.value = page
}

</script>
<template>
  <twice-ui-table-box
    use-layout
    :meta="meta"
    :loading="isLoading"
    @update-page="onUpdatePage"
  >
    <Table>
      <TableHeader>
        <TableRow>
          <TableHead>Bezeichnung</TableHead>
          <TableHead>Geschäftsbereich</TableHead>
          <TableHead class="w-auto" />
        </TableRow>
      </TableHeader>
      <TableBody>
        <FilingListItem
          v-for="(filing, index) in filings"
          :key="index"
          :item="filing"
          @select="onSelect"
        />
      </TableBody>
    </Table>
    <router-view />
  </twice-ui-table-box>
</template>
