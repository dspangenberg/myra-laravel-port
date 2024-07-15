<script lang="ts" setup>
import { computed, inject, type Ref } from 'vue'
import { type LocationQuery, type RouteParams, useRoute, useRouter } from 'vue-router'
import { IKeyValueMulitTypeStore } from '@/types'

const router = useRouter()
const route = useRoute()

export interface Props {
  active?: boolean
  activeRoutePath?: string
  activeRouteQuery?: IKeyValueMulitTypeStore
  badgeAnimate?: boolean
  badgeColor?: string
  badgeCount?: number
  badgeDot?: boolean
  disabled?: boolean
  hidden?: boolean
  icon?: string
  iconStrokeWidth?: number
  i18n?: boolean,
  info?: string
  label: string,
  name?: string,
  loading?: boolean
  open?: boolean
  routeName?: string,
  routeParams?: RouteParams,
  routeQuery?: IKeyValueMulitTypeStore,
}

const props = withDefaults(defineProps<Props>(), {
  active: false,
  activeRoutePath: '',
  badgeAnimate: false,
  badgeColor: 'red',
  badgeCount: 0,
  badgeDot: true,
  name: '',
  disabled: false,
  hidden: false,
  i18n: false,
  icon: '',
  iconStrokeWidth: 2,
  activeRouteQuery: undefined,
  info: '',
  loading: false,
  routeName: '',
  routeParams: undefined,
  routeQuery: undefined
})

const activeTab = inject<Ref>('activeTab')
const setTab = inject<Function>('setTab')

const href = computed(() => {
  try {
    return router.resolve({
      name: props.routeName,
      params: props.routeParams,
      query: props.routeQuery as unknown as LocationQuery | undefined
    })
  } catch (error) {
    console.error(error)
    return ''
  }
})

const isActive = computed(() => {
  if (props.name) {
    return activeTab?.value === props.name
  }

  const currentRoute = route.path
  if (props.activeRouteQuery) {
    const key = Object.keys(props.activeRouteQuery)[0]
    const value = Object.values(props.activeRouteQuery)[0]

    if (props.activeRouteQuery[key] === null && !route.query[key]) {
      return true
    }

    return currentRoute.startsWith(props.activeRoutePath) && route.query[key] === value
  }

  if (props.activeRoutePath) {
    return currentRoute.startsWith(props.activeRoutePath)
  }

  return currentRoute === href.value
})

const onClick = () => {
  if (props.routeName) {
    router.push(href.value)
  }
  if (!props.disabled && !props.loading && setTab !== undefined) {
    setTab(props.name)
  }
}

</script>

<template>
  <li
    :class="
      [
        isActive ? ' border-blue-500 hover:border-blue-600 hover:text-blue-600 text-blue-500 font-medium' : 'border-transparent font-medium hover:border-gray-500 text-gray-500',
        disabled ? '!text-gray-300 cursor-not-allowed hover:border-transparent' : 'cursor-pointer',
      ]"
    class="border-b-2 pb-1 flex items-center"
    @click="onClick"
  >
    <slot>
      <div class="flex items-center">
        <div
          v-if="icon"
          class="flex-shrink-0"
        >
          <twice-ui-icon
            :name="icon"
            class="w-5 h-5 mr-0.5"
          />
        </div>
        <div>
          {{ label }}
          <span
            v-if="badgeCount && badgeCount > 0"
            class="relative"
          >
            <span
              v-if="!disabled && badgeCount && badgeDot"
              class="absolute -top-1.5 left-0.5"
            >
              <twice-ui-status-dot
                :animate="badgeAnimate"
                :color="badgeColor"
                class="ml-auto text-right mr-4"
              />

            </span>
            <span v-else>
              {{ badgeCount }}
            </span>
          </span>
        </div>
      </div>
    </slot>
  </li>
</template>
