<script setup lang="ts">
import { computed, watch } from 'vue'
import {
  Breadcrumb,
  BreadcrumbItem,
  BreadcrumbLink,
  BreadcrumbList,
  BreadcrumbPage,
  BreadcrumbSeparator
} from '@/components/shdn/ui/breadcrumb'

import { useLaravelQuery } from '@/composables/useLaravelQuery'
import { storeToRefs } from 'pinia'

import { useRoute, useRouter } from 'vue-router'
import { useProjectStore } from '@/stores/ProjectStore'
import ProjectListItem from './ProjectListItem.vue'
import {
  Table,
  TableBody
} from '@/components/shdn/ui/table'
const route = useRoute()
const router = useRouter()
const projectStore = useProjectStore()
const { projects, meta, isLoading } = storeToRefs(projectStore)
const qs = computed(() => route.query)

const { queryString } = useLaravelQuery(['page'])

const onSelect = async (id: number) => {
  await projectStore.findById(id)
  router.push({ name: 'projects-details', params: { id } })
}

const onAddClicked = () => {
  projectStore.add()
  router.push({ name: 'projects-add' })
}

watch(qs, async () => {
  await projectStore.getAll(queryString.value)
}, { immediate: true })

const onUpdatePage = (page: number) => {
  router.push({ query: { ...qs.value, page } })
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
      <twice-ui-table-box
        record-name="Projekte"
        :record-count="projects?.length"
        :loading="isLoading"
        :meta="meta"
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
    </template>
  </TwiceUiPageLayout>
</template>
