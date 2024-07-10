<script setup lang="ts">
import {
  Breadcrumb,
  BreadcrumbItem,
  BreadcrumbLink,
  BreadcrumbList,
  BreadcrumbPage,
  BreadcrumbSeparator
} from '@/components/shdn/ui/breadcrumb'
import { promptModal } from 'jenesius-vue-modal'
import { useTemplateFilter } from '@/composables/useTemplateFilter'
import dayjs from 'dayjs'
import isoWeek from 'dayjs/plugin/isoWeek'
import { useLaravelQuery } from '@/composables/useLaravelQuery'
import { IconPrinter, IconCircleDashedPlus } from '@tabler/icons-vue'
import { storeToRefs } from 'pinia'
import { computed, ref, watch } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useTimeStore } from '@/stores/TimeStore'
import TimeWeekStats from './TimeWeekStats.vue'
import TimeListGroup from './TimeListGroup.vue'

dayjs.extend(isoWeek)

const { formatDate, formatSumDuration } = useTemplateFilter()

const router = useRouter()
const route = useRoute()
const timeStore = useTimeStore()
const { times, timesByDate, isLoading, meta, timesByProject, timeStats } = storeToRefs(timeStore)

const { queryString } = useLaravelQuery(['page'], { type: 'list' })
const qs = computed(() => route.query)

const onAddClicked = async () => {
  await timeStore.createOrEdit(0)
  router.push({ name: 'times-add', params: { type: route.params.type }, query: route.query })
}

const waitingForPdf = ref(false)

const onProjectClicked = async (id: number) => {
  router.push({ query: { ...qs.value, project_id: id as unknown as string } })
}

watch(qs, async () => {
  await timeStore.getAll(queryString.value)
}, { immediate: true })

const onUpdatePage = (page: number) => {
  router.push({ query: { ...qs.value, page } })
}

const year = computed(() => qs.value.year || dayjs().year())
const week = computed(() => qs.value.week || dayjs().isoWeek())
const date = computed(() => dayjs().year(year.value as number).isoWeek(week.value as number).startOf('isoWeek').format('YYYY-MM-DD'))

const onCreatePdfClicked = async () => {
  waitingForPdf.value = true
  const { dataUrl: resUrl, base64: resBase64 } = await timeStore.createPdf(queryString.value)
  waitingForPdf.value = false
  await promptModal('pdfViewer', {
    base64: resBase64,
    dataUrl: resUrl
  })
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
        :disabled="waitingForPdf"
        size="icon"
        variant="ghost"
        @click="onCreatePdfClicked"
      >
        <template v-if="waitingForPdf">
          <twice-ui-spinner :size="6" />
        </template>
        <template v-else>
          <IconPrinter class="size-6" />
        </template>
      </shdn-ui-button>
    </template>
    <template #header-pivot>
      <twice-ui-pivot>
        <twice-ui-pivot-item
          label="Meine Woche"
          route-name="times-list"
          :route-params="{type: 'week'}"
          active-route-path="/app/times/week"
        />
        <twice-ui-pivot-item
          label="Liste"
          route-name="times-list"
          :route-params="{type: 'list'}"
          :route-query="{view: 'all'}"
          active-route-path="/app/times/list"
          :active-route-query="{view: 'all'}"
        />
        <twice-ui-pivot-item
          label="Abrechenbare Zeiten"
          route-name="times-list"
          :route-params="{type: 'list'}"
          :route-query="{view: 'billable'}"
          active-route-path="/app/times/list"
          :active-route-query="{view: 'billable'}"
        />
      </twice-ui-pivot>
    </template>
    <template #content-full>
      <div class="px-0.5 min-h-0 flex-grow bg-transparent mt-6">
        <twice-ui-table-box
          record-name="Zeiteinträge"
          :border="false"
          :record-count="times?.length"
          :loading="isLoading"
          :meta="meta"
          @update-page="onUpdatePage"
        >
          <template #header>
            <template v-if="route.params.type === 'week'">
              <div class="flex-grow flex-1 flex">
                <twice-ui-week-select v-model="date" />
              </div>
              <div class="flex-grow flex-1 flex">
                <TimeWeekStats v-if="!isLoading" />
              </div>
            </template>
            <template v-else>
              <div class="text-sm font-medium ml-4 py-3">
                {{ formatDate(timeStats?.end) }} - {{ formatDate(timeStats?.start) }}
              </div>
              <div
                v-if="route.query?.view === 'billable'"
                class="rounded  bg-white grid grid-cols-4 shadow text-sm mb-6 mt-1 divide-x"
              >
                <div
                  v-for="(value, key) in timesByProject"
                  :key="key"
                  class="flex items-center px-4 py-2"
                >
                  <div class="flex-1 truncate p-4">
                    <a
                      href="#"
                      @click="onProjectClicked(key)"
                    >
                      {{ value.name }}
                    </a>
                  </div>
                  <div class="flex-none text-right font-medium px-4 py-2">
                    {{ formatSumDuration(value.sum as number) }}
                  </div>
                </div>
              </div>
            </template>
          </template>
          <TimeListGroup
            v-for="(value, key) in timesByDate"
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
