<script lang="ts" setup>
import { storeToRefs } from 'pinia'
import { onMounted, ref, watch } from 'vue'
import { useRouter } from 'vue-router'
import { useOperatingInstructionStore } from '@/stores/params/OperatingInstructionStore'
import OperatingInstructionsListItem from './OperatingInstructionsListItem.vue'
import {
  Table,
  TableHeader,
  TableRow,
  TableHead,
  TableBody
} from '@/components/shdn/ui/table'

const router = useRouter()
const operatingInstructionStore = useOperatingInstructionStore()
const { instructions, meta, isLoading } = storeToRefs(operatingInstructionStore)

const currentPage = ref(1)

const onSelect = async (id: number) => {
  await operatingInstructionStore.findById(id)
  router.push({
    name: 'params-instructions-operating-instructions-edit', params: { id }
  })
}

const onUpdatePage = (page: number) => {
  currentPage.value = page
}

watch(currentPage, async (page) => {
  await operatingInstructionStore.getAll(page)
})

onMounted(async () => {
  await operatingInstructionStore.getAll()
})

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
          <TableHead class="w-16 text-right">
            Nr.
          </TableHead>
          <TableHead>Bezeichnung</TableHead>
          <TableHead class="w-auto" />
        </TableRow>
      </TableHeader>
      <TableBody>
        <OperatingInstructionsListItem
          v-for="(instruction, index) in instructions"
          :key="index"
          :item="instruction"
          @select="onSelect"
        />
      </TableBody>
    </Table>
    <router-view />
  </twice-ui-table-box>
</template>
