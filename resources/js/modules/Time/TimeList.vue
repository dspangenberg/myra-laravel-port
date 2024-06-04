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
import dayjs from 'dayjs'
import isoWeek from 'dayjs/plugin/isoWeek'
import type { QueryParams } from '@/api/Time'

import { storeToRefs } from 'pinia'
import { computed, onMounted, ref, watch } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useTimeStore } from '@/stores/TimeStore'

import TimeListGroup from './TimeListGroup.vue'
dayjs.extend(isoWeek)
const { formatDuration } = useTemplateFilter()

const router = useRouter()
const route = useRoute()
const timeStore = useTimeStore()
const { times, groupedTimeEntries, isLoading, timeStats } = storeToRefs(timeStore)
const currentPage = ref(1)
const currentPivot = ref('week')

const qs = computed(() => route.query)
const year = computed(() => qs.value.year || dayjs().year())
const week = computed(() => qs.value.week || dayjs().isoWeek())
const date = computed(() => dayjs().year(year.value as number).isoWeek(week.value as number).startOf('isoWeek').format('YYYY-MM-DD'))
const onAddClicked = async () => {
  await timeStore.createOrEdit(0)
  router.push({ name: 'times-add' })
}

watch(qs, async (qs) => {
  console.log(qs)
  await timeStore.getAll(qs as unknown as QueryParams)
})

onMounted(async () => {
  await timeStore.getAll({ type: 'week' })
})

const onUpdatePage = (page: number) => {
  currentPage.value = page
}

const onCreatePdfClicked = async () => {
  await timeStore.createPdf()
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
          label="Meine Woche"
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
          <div class="text-base text-center font-medium pb-2">
            <twice-ui-week-select v-model="date" />
          </div>
          <shdn-ui-button @click="onCreatePdfClicked">
            Pdf erstellen
          </shdn-ui-button>
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
