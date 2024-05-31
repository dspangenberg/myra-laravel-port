<script lang="ts" setup>
import { storeToRefs } from 'pinia'
import { onMounted, ref, watch } from 'vue'
import { useRouter } from 'vue-router'
import { useInstructionCategoryStore } from '@/stores/params/InstructionCategoryStore'
import SafetyInstructionsListItem from './SafetyInstructionsListItem.vue'
import {
  Table,
  TableHeader,
  TableRow,
  TableHead,
  TableBody
} from '@/components/shdn/ui/table'

const router = useRouter()
const instructionCategoryStore = useInstructionCategoryStore()
const { categories, meta } = storeToRefs(instructionCategoryStore)

const onAddClicked = () => {
  router.push({
    name: 'settings-instructions-safety-categories-add'
  })
}

const currentPage = ref(1)

onMounted(async () => {
  await instructionCategoryStore.getAll()
})

watch(currentPage, async (page) => {
  console.log(page)
  await instructionCategoryStore.getAll(page)
}, { immediate: true })

</script>
<template>
  <twice-ui-page-section
    title="Unterweisungen"
    :current-page="currentPage"
    :meta="meta"
    empty-state-title="Sie haben noch keine Unterweisungen."
    @update-page="currentPage=$event"
  >
    <template #toolbar>
      <twice-ui-icon-button
        icon="plus"
        tooltip="Neue Unterweisung hinzufügen"
        variant="gprimary"
        @click="onAddClicked"
      />
    </template>
  </twice-ui-page-section>
</template>
