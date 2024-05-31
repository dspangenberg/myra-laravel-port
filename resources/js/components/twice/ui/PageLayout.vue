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
  <div class="flex flex-col flex-1 w-full h-full overflow-hidden">
    <div class="bg-white flex-shrink-1 ">
      <div class="mx-auto max-w-7xl print:max-w-fit print:mx-0">
        <div>
          <slot name="org-header">
            <twice-ui-page-header
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
              <template #pivot>
                <slot name="pivot" />
              </template>
            </twice-ui-page-header>
          </slot>
        </div>
      </div>
    </div>
    <div
      v-if="hasFixedContent"
      class="flex flex-1 w-full h-full px-1 py-6 mx-auto overflow-hidden max-w-7xl"
    >
      <slot name="fixed" />
    </div>
    <template v-if="hasContentFull || hasContentOnRight">
      <div
        v-show="!loading"
        :class="[overflow ? 'flex overflow-y-auto flex-1' : 'flex flex-1']"
        class="flex flex-col flex-1 py-3"
      >
        <div

          class="flex items-start flex-1"
        >
          <div class="max-w-7xl mx-auto flex flex-col flex-1 space-x-3 print:max-w-[270mm] print:mx-0 !print:text-black">
            <div
              class="!print:text-black grid grid-cols-3 h-full"
            >
              <div class="h-full col-span-3 ">
                <slot name="content-full" />
              </div>
              <div class="flex-1 col-span-2">
                <slot name="content-left" />
              </div>
              <div
                v-if="hasContentOnRight"
                class="ml-12"
              >
                <slot name="content-right" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div
        v-show="loading"
        class="items-center justify-center flex-1 text-center"
      >
        <twice-ui-spinner :size="8" />
      </div>
    </template>
    <div class="h-6" />
  </div>
</template>
