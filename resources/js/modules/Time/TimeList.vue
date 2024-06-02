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
const { formatDate, formatDuration } = useTemplateFilter()

const router = useRouter()
const timeStore = useTimeStore()
const { times, groupedTimeEntries, isLoading, timeStats } = storeToRefs(timeStore)
const currentPage = ref(1)
const currentPivot = ref('week')

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
    </template>
    <template #header-toolbar>
      <ShdnUiButton @click="onAddClicked">
        Eintrag hinzufügen
      </ShdnUiButton>
    </template>
    <template #header-pivot>
      <twice-ui-pivot v-model="currentPivot">
        <twice-ui-pivot-item
          name="week"
          label="Woche"
        />
      </twice-ui-pivot>
    </template>
    <template #content-full>
      <div class="px-0.5">
        <twice-ui-table-box
          record-name="Zeiteinträge"
          :record-count="times?.length"
          :loading="isLoading"
          @update-page="onUpdatePage"
        >
          <div class="text-base text-center font-medium px-3 mx-64 pb-2">
            {{ formatDate(timeStats?.start) }} - {{ formatDate(timeStats?.end) }}
          </div>
          <div class="mb-6 border-t rounded-md shadow border-stone-100 bg-white text-sm mx-64">
            <div class="grid grid-cols-9 text-center divide-x">
              <div class="py-3">
                <div class="text-sm font-medium">
                  {{ timeStats?.week }}.
                </div>
                <div class="text-xs text-gray-500 pt-0.5">
                  KW
                </div>
              </div>
              <div
                v-for="(value, key) in timeStats?.sumByWeekday"
                :key="key"
                class="py-3"
              >
                <div class="text-sm font-medium">
                  {{ formatDuration(value) }}
                </div>
                <div class="text-xs text-gray-500 pt-0.5">
                  {{ key }}
                </div>
              </div>
              <div class="py-3">
                <div class="text-sm font-medium">
                  {{ formatDuration(timeStats?.sumWeek || 0) }}
                </div>
                <div class="text-xs text-gray-500 pt-0.5">
                  Summe
                </div>
              </div>
            </div>
          </div>
          <TimeListGroup
            v-for="(value, key) in groupedTimeEntries"
            :key="key"
            :date="key as string"
            :sum="value.sum"
            :entries="value.entries"
          />
        </twice-ui-table-box>
      </div>
      <router-view />
    </template>
  </TwiceUiPageLayout>
</template>
