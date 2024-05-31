<script lang="ts" setup>
import { storeToRefs } from 'pinia'
import { onMounted, ref, watch } from 'vue'
import { useRouter } from 'vue-router'
import { useStorageLocationStore } from '@/stores/params/StorageLocationStore'
import StorageLocationListItem from './StorageLocationListItem.vue'
import {
  Table,
  TableHeader,
  TableRow,
  TableHead,
  TableBody
} from '@/components/shdn/ui/table'

const router = useRouter()
const storageLocationStore = useStorageLocationStore()
const { locations, meta, isLoading } = storeToRefs(storageLocationStore)

const currentPage = ref(1)

const onSelect = async (id: number) => {
  await storageLocationStore.findById(id)
  router.push({
    name: 'params-business-storage-locations-edit', params: { id }
  })
}

watch(currentPage, async (page) => {
  await storageLocationStore.getAll(page)
})

onMounted(async () => {
  await storageLocationStore.getAll()
})

const onUpdatePage = (page: number) => {
  currentPage.value = page
}

</script>
<template>
  <div>
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
          <StorageLocationListItem
            v-for="(location, index) in locations"
            :key="index"
            :item="location"
            @select="onSelect"
          />
        </TableBody>
      </Table>
    </twice-ui-table-box>
    <router-view />
  </div>
</template>
