<script lang="ts" setup>
import { computed } from 'vue'
import { type RouteParams, type LocationQuery, useRouter, useRoute } from 'vue-router'

export interface Props {
  active?: boolean
  activeRoutePath?: string
  badgeCount?: number
  disabled?: boolean
  hidden?: boolean
  label: string,
  open?: boolean
  parent?: boolean
  separator?: boolean
  routeName: string,
  routeParams?: RouteParams,
  routeQuery?: LocationQuery
}

const props = withDefaults(defineProps<Props>(), {
  active: false,
  activeRoutePath: '',
  badgeCount: 0,
  disabled: false,
  hidden: false,
  info: '',
  loading: false,
  parent: false,
  routeParams: undefined,
  routeQuery: undefined,
  separator: false
})

const route = useRoute()
const router = useRouter()

const href = computed<string>(() => {
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

const go = (nRoute: string) => {
  if (!props.disabled && nRoute !== route.fullPath) {
    router.push(nRoute)
  }
}
const isActive = computed(() => {
  const currentRoute = route.path
  if (props.activeRoutePath) {
    return currentRoute.startsWith(props.activeRoutePath)
  }

  return currentRoute === href.value
})

</script>
<template>
  <div :class="parent ? 'text-base my-2 font-normal text-gray-400 space-y-2' : ''">
    <router-link
      :to="href"
      custom
    >
      <li
        :class="[disabled ? '!text-gray-300 cursor-not-allowed' : 'text-gray-600', 'focus:border-blue-400 focus:ring-1 focus:ring-blue-200 select-none focus:outline-none cursor-pointer group flex items-center px-4 rounded-md']"
        @click="go(href)"
      >
        <span
          v-tooltip="label"
          :class="isActive ? 'font-medium text-blue-500' : ''"
          class="truncate hover:underline text-base"
        >
          {{ label }}
        </span>
        <span
          v-if="!disabled && badgeCount"
          class="ml-auto text-right font-normal text-xs"
        >
          {{ badgeCount }}
        </span>
      </li>
    </router-link>
    <slot />
    <div :class="[separator ? 'space-y-1 border-gray-100 pb-2 ml-3' : '']" />
  </div>
</template>
