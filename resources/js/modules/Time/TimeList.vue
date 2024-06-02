<script setup lang="ts">
import {
  Breadcrumb,
  BreadcrumbItem,
  BreadcrumbLink,
  BreadcrumbList,
  BreadcrumbPage,
  BreadcrumbSeparator
} from '@/components/shdn/ui/breadcrumb'
import { useTemplateFilter } from '@/composables/useTemplateFilter'

import { storeToRefs } from 'pinia'
import { onMounted, ref, watch } from 'vue'
import { useRouter } from 'vue-router'
import { useTimeStore } from '@/stores/TimeStore'

import TimeListGroup from './TimeListGroup.vue'
const { formatDate } = useTemplateFilter()

const router = useRouter()
const timeStore = useTimeStore()
const { times, groupedTimeEntries, isLoading, timeStats } = storeToRefs(timeStore)
const currentPage = ref(1)

const onAddClicked = () => {
  timeStore.add()
  router.push({ name: 'times-add' })
}

watch(currentPage, async (page) => {
  await timeStore.getAll(page)
})

onMounted(async () => {
  await timeStore.getAll()
})

const onUpdatePage = (page: number) => {
  currentPage.value = page
}

</script>

<template>
  <TwiceUiPageLayout>
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
            <BreadcrumbPage>Zeiterfassung</BreadcrumbPage>
          </BreadcrumbItem>
        </BreadcrumbList>
      </Breadcrumb>
    </template>
    <template #header-title>
      <h1 class="text-xl text-gray-900 font-medium leading-relaxed">
        Zeiterfassung
      </h1>
      <p class="text-base text-gray-500">
        {{ formatDate(timeStats?.start) }} - {{ formatDate(timeStats?.end) }} ({{ timeStats?.week }})
      </p>
    </template>
    <template #header-toolbar>
      <ShdnUiButton @click="onAddClicked">
        Eintrag hinzufügen
      </ShdnUiButton>
    </template>
    <template #content-full>
      <div class="px-0.5">
        <twice-ui-table-box
          record-name="Zeiteinträge"
          :record-count="times?.length"
          :loading="isLoading"
          @update-page="onUpdatePage"
        >
          <TimeListGroup
            v-for="(value, key) in groupedTimeEntries"
            :key="key"
            :date="key as string"
            :entries="value"
          />
        </twice-ui-table-box>
      </div>
      <router-view />
    </template>
  </TwiceUiPageLayout>
</template>
