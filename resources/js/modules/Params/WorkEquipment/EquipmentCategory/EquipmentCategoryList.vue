<script lang="ts" setup>
import { storeToRefs } from 'pinia'
import { onMounted, ref, watch } from 'vue'
import { useRouter } from 'vue-router'
import { useEquipmentCategoryStore } from '@/stores/params/EquipmentCategoryStore'
import EquipmentCategoryListItem from './EquipmentCategoryListItem.vue'
import {
  Table,
  TableHeader,
  TableRow,
  TableHead,
  TableBody
} from '@/components/shdn/ui/table'

const router = useRouter()
const equipmentCategoryStore = useEquipmentCategoryStore()
const { categories, meta, isLoading } = storeToRefs(equipmentCategoryStore)

const currentPage = ref(1)

const onSelect = async (id: number) => {
  await equipmentCategoryStore.findById(id)
  router.push({
    name: 'params-work-equipment-categories-edit', params: { id }
  })
}

watch(currentPage, async (page) => {
  await equipmentCategoryStore.getAll(page)
})

onMounted(async () => {
  await equipmentCategoryStore.getAll()
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
          <TableHead
            class="w-72"
          >
            Elternkategorie
          </TableHead>
          <TableHead
            class="w-72"
          >
            Inventargruppen
          </TableHead>
          <TableHead class="w-auto" />
        </TableRow>
      </TableHeader>
      <TableBody>
        <EquipmentCategoryListItem
          v-for="(category, index) in categories"
          :key="index"
          :item="category"
          @select="onSelect"
        />
      </TableBody>
    </Table>
    <router-view />
  </twice-ui-table-box>
</template>
