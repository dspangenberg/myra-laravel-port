<script setup lang="ts">
import { computed, useSlots } from 'vue'
import { type RouteParams, type LocationQuery, useRouter, useRoute, type RouteLocationNormalized } from 'vue-router'

export interface Props {
  active?: boolean
  activeRoutePath?: string
  badgeAnimate?: boolean
  badgeColor?: string
  badgeCount?: number
  badgeDot?: boolean
  disabled?: boolean
  exact?: boolean
  hidden?: boolean
  i18n?: boolean,
  info?: string
  label: string,
  loading?: boolean
  open?: boolean
  routeName: string,
  routeParams?: RouteParams,
  routeQuery?: LocationQuery
}

const props = withDefaults(defineProps<Props>(), {
  active: false,
  activeRoutePath: '',
  badgeAnimate: false,
  badgeColor: 'red',
  badgeCount: 0,
  badgeDot: true,
  disabled: false,
  exact: false,
  hidden: false,
  i18n: false,
  iconStrokeWidth: 2,
  info: '',
  loading: false,
  routeParams: undefined,
  routeQuery: undefined
})

const iconProps = {
  size: '24',
  stroke: '1.5',
  class: [props.disabled ? 'text-gray-300 hover:text-gray-300' : 'text-gray-700 active:text-black group-hover:text-black', ' flex-none mr-1.5 h-5 w-5 ']
}

const route = useRoute()
const router = useRouter()

const $slots = useSlots()

const hasAction = computed(() => {
  return $slots.action
})

const hasChilds = computed(() => {
  return $slots.default
})

const href = computed(() => {
  try {
    const route = router.resolve({
      name: props.routeName,
      params: props.routeParams,
      query: props.routeQuery
    })
    return route.href
  } catch (error) {
    console.error(error)
    return ''
  }
})

const go = (nRoute: RouteLocationNormalized) => {
  if (!props.disabled && nRoute.fullPath !== route.fullPath) {
    router.push(nRoute)
  }
}
const isActive = computed(() => {
  if (props.active) {
    return true
  }
  const currentRoute = route.path
  if (props.activeRoutePath && !props.exact) {
    return currentRoute.startsWith(props.activeRoutePath)
  }

  return currentRoute === href.value
})

</script>
<template>
  <div>
    <router-link
      v-slot="{ route: lroute }"
      :to="href"
      custom
    >
      <li
        :class="[hidden ? 'hidden' : '', disabled ? 'text-gray-300 cursor-not-allowed' : isActive ? 'bg-stone-200 text-black hover:bg-stone-200' : 'text-stone-800  hover:text-black', 'hover:bg-stone-200/75 select-none cursor-pointer group flex items-center px-2 py-1.5 text-sm font-medium rounded-md']"
        @click="go(lroute)"
      >
        <template v-if="loading">
          <span class="mr-1.5">
            <twice-ui-spinner
              :size="5"
              color="blue"
            />
          </span>
        </template>
        <div
          v-else
          class="flex-none"
        >
          <slot
            name="icon"
            :icon-props="iconProps"
          />
        </div>
        <span
          class="truncate flex-1 text-gray-800 hover:text-black"
          :class="[disabled ? '!text-gray-300 cursor-not-allowed' : '', isActive ? 'text-black' : '']"
        >
          {{ label }}
        </span>
        <template
          v-if="!disabled && info"
        >
          <div class="text-sm flex-none text-right font-normal text-gray-600">
            {{ info }}
          </div>
        </template>
        <template
          v-if="!disabled && badgeCount"
        >
          <twice-ui-status-dot
            :animate="badgeAnimate"
            :color="badgeColor"
            class="ml-auto text-right mr-4"
          />
        </template>
        <div
          v-if="hasAction"
          class="flex-none"
        >
          <div class="hidden group-hover:block">
            <slot name="action" />
          </div>
        </div>
      </li>
    </router-link>
    <div
      v-if="!loading && (hasChilds && (!disabled && (isActive || open)))"
      class="text-sm ml-5 my-2 font-normal text-gray-400 space-y-2"
    >
      <slot />
    </div>
  </div>
</template>
