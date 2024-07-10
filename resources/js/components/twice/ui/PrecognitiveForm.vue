<script generic="Data extends Record<string, unknown>" lang="ts" setup>
import { computed } from 'vue'
import { id as id2 } from 'random-html-id'
import { useForm } from 'laravel-precognition-vue'
import { useRoute } from 'vue-router'
import type { RequestMethod } from 'laravel-precognition'
const route = useRoute()

const props = withDefaults(defineProps<{
  initialValues: Record<string, unknown>
  method?: RequestMethod,
  baseUrl: string,
  useParamsId?: boolean,
  id?: string
}>(), {
  id: id2(),
  useParamsId: true,
  method: 'put'
})

const baseRoute = computed(() => props.useParamsId && route.params.id ? `/${props.baseUrl}/${route.params.id}` : props.baseUrl)
console.log(baseRoute.value)

const form = useForm(props.method, baseRoute.value, props.initialValues)

</script>

<template>
  <form
    :id="id"
    class="flex-1 flex w-full items-stretch flex-col"
  >
    {{ baseRoute }}
    <slot :form="form" />
  </form>
</template>
