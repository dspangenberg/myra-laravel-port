<script lang="ts" setup>
import { storeToRefs } from 'pinia'
import { onMounted, ref, watch } from 'vue'
import { useRouter } from 'vue-router'
import { useEmpowermentStore } from '@/stores/params/EmpowermentStore'
import EmpowermentListItem from './EmpowermentListItem.vue'
import {
  Table,
  TableHeader,
  TableRow,
  TableHead,
  TableBody
} from '@/components/shdn/ui/table'

const router = useRouter()
const empowermentStore = useEmpowermentStore()
const { empowerments, meta, isLoading } = storeToRefs(empowermentStore)

const currentPage = ref(1)

const onSelect = async (id: number) => {
  await empowermentStore.findById(id)
  router.push({
    name: 'params-business-empowerments-edit', params: { id }
  })
}

watch(currentPage, async (page) => {
  await empowermentStore.getAll(page)
})

onMounted(async () => {
  await empowermentStore.getAll()
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
          <TableHead class="w-12">
            Kürzel
          </TableHead>
          <TableHead class="w-auto" />
        </TableRow>
      </TableHeader>
      <TableBody>
        <EmpowermentListItem
          v-for="(empowerment, index) in empowerments"
          :key="index"
          :item="empowerment"
          @select="onSelect"
        />
      </TableBody>
    </Table>
    <router-view />
  </twice-ui-table-box>
</template>
