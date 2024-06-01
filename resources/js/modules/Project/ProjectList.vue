<script setup lang="ts">
import {
  Breadcrumb,
  BreadcrumbItem,
  BreadcrumbLink,
  BreadcrumbList,
  BreadcrumbPage,
  BreadcrumbSeparator
} from '@/components/shdn/ui/breadcrumb'

import { storeToRefs } from 'pinia'
import { onMounted, ref, watch } from 'vue'
import { useRouter } from 'vue-router'
import { useProjectStore } from '@/stores/ProjectStore'
import ProjectListItem from './ProjectListItem.vue'
import {
  Table,
  TableBody
} from '@/components/shdn/ui/table'

const router = useRouter()
const projectStore = useProjectStore()
const { projects, meta, isLoading } = storeToRefs(projectStore)
const currentPage = ref(1)

const onSelect = async (id: number) => {
  await projectStore.findById(id)
  router.push({ name: 'users-edit', params: { id } })
}

const onAddClicked = () => {
  projectStore.add()
  router.push({ name: 'users-add' })
}

watch(currentPage, async (page) => {
  await projectStore.getAll(page)
})

onMounted(async () => {
  await projectStore.getAll()
})

const onUpdatePage = (page: number) => {
  currentPage.value = page
}

</script>

<template>
  <TwiceUiPageLayout title="Accounts + Kontakte">
    <template #breadcrumbs>
      <Breadcrumb>
        <BreadcrumbList>
          <BreadcrumbItem>
            <BreadcrumbLink href="/app/">
              Dashboard
            </BreadcrumbLink>
          </BreadcrumbItem>
          <BreadcrumbSeparator />
          <BreadcrumbItem>
            <BreadcrumbPage>Accounts + Kontakte</BreadcrumbPage>
          </BreadcrumbItem>
        </BreadcrumbList>
      </Breadcrumb>
    </template>
    <template #header-toolbar>
      <ShdnUiButton @click="onAddClicked">
        Kontakt hinzufügen
      </ShdnUiButton>
    </template>
    <template #content-full>
      <div class="px-0.5">
        <twice-ui-table-box
          v-if="meta"
          :meta="meta"
          record-name="Kontakte|Kontakt"
          :loading="isLoading"
          @update-page="onUpdatePage"
        >
          <Table>
            <TableBody>
              <ProjectListItem
                v-for="(project, index) in projects"
                :key="index"
                :item="project"
                @select="onSelect"
              />
            </TableBody>
          </Table>
        </twice-ui-table-box>
      </div>
      <router-view />
    </template>
  </TwiceUiPageLayout>
</template>
