<script lang="ts" setup>
import { storeToRefs } from 'pinia'
import { onMounted, ref, watch } from 'vue'
import { useRouter } from 'vue-router'
import { useBusinessSegmentStore } from '@/stores/params/BusinessSegmentStore'
import BusinessSegmentListItem from './BusinessSegmentListItem.vue'
import {
  Table,
  TableHeader,
  TableRow,
  TableHead,
  TableBody
} from '@/components/shdn/ui/table'

const router = useRouter()
const businessSegmentStore = useBusinessSegmentStore()
const { segments, meta, isLoading } = storeToRefs(businessSegmentStore)

const currentPage = ref(1)

const onSelect = async (id: number) => {
  await businessSegmentStore.findById(id)
  router.push({
    name: 'params-business-segments-edit', params: { id }
  })
}

watch(currentPage, async (page) => {
  await businessSegmentStore.getAll(page)
})

onMounted(async () => {
  await businessSegmentStore.getAll()
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
          <TableHead class="w-auto" />
        </TableRow>
      </TableHeader>
      <TableBody>
        <BusinessSegmentListItem
          v-for="(segment, index) in segments"
          :key="index"
          :item="segment"
          @select="onSelect"
        />
      </TableBody>
    </Table>
    <router-view />
  </twice-ui-table-box>
</template>
