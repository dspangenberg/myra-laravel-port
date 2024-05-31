<script setup lang="ts">
import { useForm } from 'vee-validate'
import { ref, watch, computed } from 'vue'
import { id as id2 } from 'random-html-id'
import { type IKeyValueMulitTypeStore } from '@/types/'

export interface Props {
  initialValues: IKeyValueMulitTypeStore | null;
  id?: string;
}

const props = withDefaults(defineProps<Props>(), {
  initialValues: null,
  id: id2()
})

const form = ref<HTMLFormElement | null>(null)

// const emit = defineEmits(['submitted', 'changed', 'dirty', 'pending', 'request'])

const emit = defineEmits<{(e: 'submitted', values: IKeyValueMulitTypeStore): IKeyValueMulitTypeStore,
(e: 'changed'): void
(e: 'dirty'): void
(e: 'pending'): void
(e: 'request'): void
}>()

const { setValues, handleSubmit, submitForm, validate, errors, meta, isSubmitting, isValidating, values, setFieldValue } = useForm({
  validateOnMount: false,
  keepValuesOnUnmount: true,
  initialValues: props.initialValues || null
})

watch(meta, async (meta) => {
  if (meta.dirty === true) {
    emit('dirty')
  }
})

const isRequestPending = computed(() => isSubmitting.value || isValidating.value)

watch(isRequestPending, async () => {
  emit('request')
})

const onSubmit = handleSubmit(values => {
  emit('submitted', values)
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
