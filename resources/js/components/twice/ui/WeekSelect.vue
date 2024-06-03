<script setup lang="ts">
import { toRefs, computed } from 'vue'
import { IconChevronRight, IconChevronLeft, IconCalendarDot } from '@tabler/icons-vue'
import { useTemplateFilter } from '@/composables/useTemplateFilter'

import dayjs from 'dayjs'
import duration from 'dayjs/plugin/duration'
import relativeTime from 'dayjs/plugin/relativeTime'
import isoWeek from 'dayjs/plugin/isoWeek'
import { useRouter } from 'vue-router'
import 'dayjs/locale/de'

dayjs.extend(duration)
dayjs.extend(relativeTime)
dayjs.extend(isoWeek)
dayjs.locale('de')
const { formatDate } = useTemplateFilter()

export interface Props {
  modelValue?: string
  format?: string
  nextMode?: string
}

const props = withDefaults(defineProps<Props>(), {
  modelValue: dayjs().format('YYYY-MM-DD'),
  format: 'YYYY-MM-DD',
  nextMode: 'day'
})

const router = useRouter()

const { modelValue } = toRefs(props)

const startOfWeek = computed(() => dayjs(modelValue.value).startOf('isoWeek'))
const endOfWeek = computed(() => dayjs(modelValue.value).startOf('isoWeek').endOf('isoWeek'))
const week = computed(() => dayjs(modelValue.value).isoWeek())
const year = computed(() => dayjs(modelValue.value).year())

const formatedStartOfWeek = computed(() => formatDate(startOfWeek.value.toString()))
const formatedEndOfWeek = computed(() => formatDate(endOfWeek.value.toString()))

const canNext = computed(() => dayjs().isoWeek() > week.value)
const onPrevClicked = () => {
  const date = dayjs(startOfWeek.value)
  const week = date.subtract(1, 'weeks')
  console.log(week.year(), week.isoWeek())
  router.push({ query: { week: week.isoWeek(), year: week.year() } })
}

const onNextClicked = () => {
  const date = dayjs(endOfWeek.value)
  const week = date.add(1, 'weeks')
  router.push({ query: { week: week.isoWeek(), year: week.year() } })
}

const onTodayClicked = () => {
  const date = dayjs()
  router.push({ query: { week: date.isoWeek(), year: date.year() } })
}

/*
const nextLink = computed(() => {
  const nextWeek = endOfWeek.value.plus(7, 'days')
  return `/times?year=${nextWeek.weekYear}&week=${nextWeek.weekNumber}`
})

const prevLink = computed(() => {
  const prevWeek = startOfWeek.value.minus(7, 'days')
  return `/times?year=${prevWeek.weekYear}&week=${prevWeek.weekNumber}`
})
*/

</script>
<template>
  <div class="block">
    <div class="flex w-fit justify-between items-center my-1 overflow-hidden border-gray-200 rounded-md  dark:bg-gray-700 dark:border-gray-600">
      <div class="m-1">
        <shdn-ui-button
          size="icon"
          variant="ghost"
          @click="onPrevClicked"
        >
          <IconChevronLeft class="size-5" />
        </shdn-ui-button>
      </div>
      <div
        class="flex items-center px-0.5 text-sm leading-none font-bold text-gray-700 dark:bg-gray-700 dark:text-gray-300 dark:hover:text-gray-50"
      >
        {{ formatedStartOfWeek }} - {{ formatedEndOfWeek }}
      </div>
      <div class="m-1">
        <shdn-ui-button
          size="icon"
          variant="ghost"
          :disabled="!canNext"
          @click="onNextClicked"
        >
          <IconChevronRight class="size-5" />
        </shdn-ui-button>
      </div>
      <div class="m-1">
        <shdn-ui-button
          size="icon"
          variant="ghost"
          @click="onTodayClicked"
        >
          <IconCalendarDot class="size-5" />
        </shdn-ui-button>
      </div>
    </div>
  </div>
</template>
