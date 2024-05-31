<script lang="ts" setup>
import { storeToRefs } from 'pinia'
import { onMounted, ref, watch } from 'vue'
import { useRouter } from 'vue-router'
import { useInstructionCategoryStore } from '@/stores/params/InstructionCategoryStore'
import SafetyInstructionCategoriesListItem from './SafetyInstructionCategoriesListItem.vue'
import {
  Table,
  TableHeader,
  TableRow,
  TableHead,
  TableBody
} from '@/components/shdn/ui/table'

const router = useRouter()
const instructionCategoryStore = useInstructionCategoryStore()
const { categories, meta, isLoading } = storeToRefs(instructionCategoryStore)

const onAddClicked = () => {
  instructionCategoryStore.add()
  router.push({
    name: 'settings-instructions-safety-categories-add'
  })
}

const currentPage = ref(1)

const onSelect = async (id: number) => {
  await instructionCategoryStore.findById(id)
  router.push({
    name: 'settings-instructions-safety-categories-edit', params: { id }
  })
}

onMounted(async () => {
  await instructionCategoryStore.getAll(1)
})

watch(currentPage, async (page) => {
  await instructionCategoryStore.getAll(page)
})

</script>
<template>
  <twice-ui-page-section
    title="Unterweisungskategorien"
    :current-page="currentPage"
    :meta="meta"
    :loading="isLoading"
    empty-state-title="Sie haben noch keine Unterweisungskategorien."
    @update-page="currentPage=$event"
  >
    <template #toolbar>
      <twice-ui-icon-button
        icon="plus"
        tooltip="Neue Unterweisungskategorien hinzufügen"
        variant="gprimary"
        @click="onAddClicked"
      />
    </template>
    <Table>
      <TableHeader>
        <TableRow>
          <TableHead class="w-10" />
          <TableHead>Titel</TableHead>
          <TableHead>Intervall</TableHead>
          <TableHead class="w-auto" />
        </TableRow>
      </TableHeader>
      <TableBody>
        <SafetyInstructionCategoriesListItem
          v-for="(category, index) in categories"
          :key="index"
          :item="category"
          @select="onSelect"
        />
      </TableBody>
    </Table>
    <template #empty-state-button>
      <twice-ui-button
        variant="primary"
        @click="onAddClicked"
      >
        Unterweisungskategorie hinzufügen
      </twice-ui-button>
    </template>
  </twice-ui-page-section>
</template>
