<script setup lang="ts" generic="T extends Record<string, any>">
import { useForm } from 'vee-validate'
import { ref, watch, computed } from 'vue'
import { id as id2 } from 'random-html-id'

const props = withDefaults(defineProps<{
  initialValues?: T | null | {} | undefined
  id?: string
}>(), {
  id: id2(),
  initialValues: null
})

const form = ref<HTMLFormElement | null>(null)

const emit = defineEmits<{(e: 'submitted', values: T): void,
(e: 'changed'): void
(e: 'dirty'): void
(e: 'pending'): void
(e: 'request'): void
}>()

const { setValues, handleSubmit, submitForm, validate, errors, meta, isSubmitting, isValidating, values, setFieldValue } = useForm({
  validateOnMount: false,
  keepValuesOnUnmount: true,
  initialValues: props.initialValues
})

watch(meta, async (meta) => {
  if (meta.dirty) {
    emit('dirty')
  }
})

const isRequestPending = computed(() => isSubmitting.value || isValidating.value)

watch(isRequestPending, async () => {
  emit('request')
})

const onSubmit = handleSubmit(values => {
  emit('submitted', values as T)
})

defineExpose({ setValues, form, meta, isSubmitting, submitForm, errors, setFieldValue, validate, values })

</script>

<template>
  <form
    :id="id"
    ref="form"
    class="flex-1 flex w-full items-stretch flex-col"
    @submit.stop="onSubmit"
  >
    <twice-ui-form-errors :errors="errors" />
    <slot />
  </form>
</template>
