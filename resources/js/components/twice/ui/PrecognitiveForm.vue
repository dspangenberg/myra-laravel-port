<script generic="Data extends Record<string, unknown>" lang="ts" setup>
import { computed } from 'vue'
import { id as id2 } from 'random-html-id'
import { useForm } from 'laravel-precognition-vue'
import { useRoute } from 'vue-router'
import type { RequestMethod } from 'laravel-precognition'
import type { Form } from 'laravel-precognition-vue/dist/types'
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

const baseRoute = computed(() => props.useParamsId && route.params.id ? `${props.baseUrl}/${route.params.id}` : props.baseUrl)
console.log(baseRoute.value)

const form = useForm(props.method, baseRoute.value, props.initialValues)

const emit = defineEmits<{(e: 'validated', values: Data): void,
  (e: 'changed'): void
  (e: 'dirty'): void
  (e: 'pending'): void
  (e: 'request'): void
}>()

const onSubmit = async () => {
  const result: Form<Data> = form.validate() as Form<Data>
  if (!result.hasErrors) {
    console.log(result)
    emit('validated', result.data as unknown as Data)
  }
}

</script>

<template>
  <form
    :id="id"
    class="flex-1 flex w-full items-stretch flex-col"
    @submit.prevent="onSubmit"
  >
    {{ baseRoute }}
    <slot :form="form" />
  </form>
</template>
