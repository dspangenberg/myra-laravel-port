<script setup lang="ts">
import { computed } from 'vue'
import { type RouteParams, type LocationQuery, useRouter } from 'vue-router'

const router = useRouter()

export interface Props {
  label: string
  routeName: string,
  routeParams?: RouteParams,
  routeQuery?: LocationQuery
}

const props = withDefaults(defineProps<Props>(), {
  routeParams: undefined,
  routeQuery: undefined
})

defineEmits(['canceled'])

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

</script>

<template>
  <div class="inline hover:text-gray-600 cursor-pointer text-gray-400 text-base">
    <router-link
      v-if="href"
      v-slot="{ navigate }"
      :to="href"
      custom
    >
      <li
        class="inline-flex items-center"
        @click="navigate"
      >
        <twice-ui-icon
          :stroke-width="2"
          name="tabler-arrow-narrow-left"
          class="w-5 h-5 mr-1"
        />
        <span>
          <slot>{{ label }}</slot>
        </span>
      </li>
    </router-link>
    <div
      v-else
      class="inline-flex items-center"
      @click="$emit('canceled')"
    >
      <twice-ui-icon
        :stroke-width="2"
        name="tabler-arrow-narrow-left"
        class="w-5 h-5 mr-1"
      />
      <span>
        <slot>{{ label }}</slot>
      </span>
    </div>
  </div>
</template>
