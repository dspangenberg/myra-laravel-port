<script setup lang="ts">
import { type RouteParams, type LocationQuery } from 'vue-router'
import { computed, useSlots, toRefs } from 'vue'

export interface Props {
  overflow?: boolean
  title?: string
  loading?: boolean
  headerLoading?: boolean
  backRouteName?: string
  backRouteParams?: RouteParams
  backRouteQuery?: LocationQuery
  backText?: string
  contentLayout?: 'full' | '2-1'
}

const props = withDefaults(defineProps<Props>(), {
  overflow: true,
  title: '',
  backText: '',
  backRouteName: '',
  backRouteParams: undefined,
  backRouteQuery: undefined,
  headerLoading: false,
  loading: false,
  contentLayout: '2-1'
})

const $slots = useSlots()

const hasContentOnRight = computed(() => $slots['content-right'])
const hasFixedContent = computed(() => $slots.fixed)
const hasContentFull = computed(() => $slots['content-full'])
const { title } = toRefs(props)
</script>

<template>
  <div class="flex flex-col flex-1 w-full overflow-y-hidden h-full items-stretch ">
    <div class="flex-none">
      <div class="my-3">
        <slot name="org-header">
          <TwiceUiPageHeader
            :title="title"
          >
            <template #breadcrumbs>
              <slot name="breadcrumbs" />
            </template>
            <template #title>
              <slot name="header-title" />
            </template>
            <template #toolbar>
              <slot name="header-toolbar" />
            </template>

            <template
              v-if="$slots['header-pivot']"
              #pivot
            >
              <div>
                <slot
                  name="header-pivot"
                />
              </div>
            </template>
          </TwiceUiPageHeader>
        </slot>
      </div>
    </div>
    <div class="flex flex-1 overflow-y-hidden max-w-7xl mx-auto flex-col w-full">
      <slot name="content-full" />
    </div>
  </div>
</template>
