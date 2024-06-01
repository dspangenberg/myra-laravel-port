<!--suppress ES6MissingAwait -->
<script lang="ts" setup>
import { storeToRefs } from 'pinia'
import { onMounted, ref, watch } from 'vue'
import { useRouter } from 'vue-router'
import { useDepartmentStore } from '@/stores/params/DepartmentStore'
import DepartmentListItem from './DepartmentListItem.vue'
import {
  Table,
  TableHeader,
  TableRow,
  TableHead,
  TableBody
} from '@/components/shdn/ui/table'

const router = useRouter()
const departmentStore = useDepartmentStore()
const { departments, meta, isLoading } = storeToRefs(departmentStore)

const currentPage = ref(1)

const onSelect = async (id: number) => {
  await departmentStore.findById(id)
  router.push({
    name: 'params-business-departments-edit', params: { id }
  })
}

watch(currentPage, async (page) => {
  await departmentStore.getAll(page)
})

onMounted(async () => {
  await departmentStore.getAll()
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
        <DepartmentListItem
          v-for="(department, index) in departments"
          :key="index"
          :item="department"
          @select="onSelect"
        />
      </TableBody>
    </Table>
    <router-view />
  </twice-ui-table-box>
</template>
