<script setup lang="ts">
import {
  Breadcrumb,
  BreadcrumbItem,
  BreadcrumbLink,
  BreadcrumbList,
  BreadcrumbPage,
  BreadcrumbSeparator
} from '@/components/shdn/ui/breadcrumb'
import dayjs from 'dayjs'
import isoWeek from 'dayjs/plugin/isoWeek'
import type { QueryParams } from '@/api/Time'
import { IconFileTypePdf, IconCircleDashedPlus } from '@tabler/icons-vue'
import { query } from '@vortechron/query-builder-ts'

import { storeToRefs } from 'pinia'
import { computed, onMounted, ref, watch } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useTimeStore } from '@/stores/TimeStore'
import TimePivot from './TimePivot.vue'
import TimeListGroup from './TimeListGroup.vue'
import TimeWeekStats from './TimeWeekStats.vue'
dayjs.extend(isoWeek)

const router = useRouter()
const route = useRoute()
const timeStore = useTimeStore()
const { groupedTimeEntries, isLoading, times } = storeToRefs(timeStore)
const currentPage = ref(1)

const qs = computed(() => route.query)
const year = computed(() => qs.value.year || dayjs().year())
const week = computed(() => qs.value.week || dayjs().isoWeek())
const date = computed(() => dayjs().year(year.value as number).isoWeek(week.value as number).startOf('isoWeek').format('YYYY-MM-DD'))
const onAddClicked = async () => {
  await timeStore.createOrEdit(0)
  router.push({ name: 'times-add' })
}

const isOpen = ref(false)
const pdfDataUrl = ref()
const pdfBase64 = ref('')

watch(qs, async (qs) => {
  const theQuery = query()
    .param('type', 'week')
    .filter('year', qs.year as string)
    .filter('week', qs.week as string)
    .page(1)

  const q = theQuery.build()
  await timeStore.getAll(q)
})

onMounted(async () => {
  await timeStore.getAll('?type=week')
})

const onUpdatePage = (page: number) => {
  currentPage.value = page
}

const onCreatePdfClicked = async () => {
  const { dataUrl: resUrl, base64: resBase64 } = await timeStore.createPdf(qs.value as unknown as QueryParams)
  pdfDataUrl.value = resUrl
  pdfBase64.value = resBase64
  isOpen.value = true
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
      <ShdnUiButton
        size="icon"
        variant="ghost"
        @click="onAddClicked"
      >
        <IconCircleDashedPlus
          class="size-6"
        />
      </ShdnUiButton>

      <shdn-ui-button
        size="icon"
        variant="ghost"
        @click="onCreatePdfClicked"
      >
        <IconFileTypePdf class="size-6" />
      </shdn-ui-button>
    </template>
    <template #header-pivot>
      <TimePivot />
    </template>
    <template #content-full>
      <twice-ui-pdf-viewer
        v-if="pdfDataUrl"
        :is-open="isOpen"
        :base64="pdfBase64"
        :data-url="pdfDataUrl"
        @close="isOpen=false"
      />
      <div class="px-0.5 min-h-0 flex-grow bg-transparent mt-6">
        <twice-ui-table-box
          record-name="Zeiteinträge"
          :border="false"
          :record-count="times?.length"
          :loading="isLoading"
          @update-page="onUpdatePage"
        >
          <template #header>
            <div class="flex-grow flex-1 flex">
              <twice-ui-week-select v-model="date" />
            </div>
            <div class="flex-grow flex-1 flex">
              <TimeWeekStats v-if="!isLoading" />
            </div>
          </template>
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
