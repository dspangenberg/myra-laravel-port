<script setup lang="ts">
import { computed, toRef } from 'vue'
import { useField } from 'vee-validate'
import { id as id2 } from 'random-html-id'
import { cn } from '@/utils/Shdn'

export interface Props {
  name: string
  class?: string
  id?: string
  error?: string,
  autocomplete?: string
  help?: string
  placeholder?: string
  autofocus?: boolean
  max?: number
  min?: number
  hideLabel?: boolean
  readonly?: boolean
  disabled?: boolean
  rules?: string
  label?: string
  type?: string
  maxlength?: number
  inputClass?: string
}

const props = withDefaults(defineProps<Props>(), {
  maxlength: 524288,
  error: '',
  autocomplete: 'off',
  hideLabel: false,
  id: undefined,
  help: '',
  placeholder: '',
  max: 0,
  min: 0,
  autofocus: false,
  type: 'text',
  class: '',
  label: '',
  readonly: false,
  disabled: false,
  rules: '',
  inputClass: ''
})

const name = toRef(props, 'name')
const rules = toRef(props, 'rules')
const emit = defineEmits(['input'])

const { value, errorMessage, meta } = useField<number>(name, rules, {})
const htmlId = computed(() => props.id ?? `input-${id2()}`)
const hasError = computed(() => meta.touched && errorMessage.value !== undefined)
const required = computed(() => props.rules.includes('required'))

const extraClass = computed(() => {
  if (hasError.value) {
    return 'border-destructive focus-within:border-destructive focus-within:ring-destructive/50'
  }
  return ''
})

const onPlus = () => {
  if (props.max !== 0 && value.value === props.max) {
    return
  }
  if (!value.value) {
    value.value = 1
  } else {
    value.value++
  }
  emit('input', value.value)
}

const onMinus = () => {
  if (value.value < props.min) {
    return
  }
  if (!value.value) {
    value.value = props.min
  } else {
    value.value--
  }
  emit('input', value.value)
}

const buttonClass = 'w-5 h-[20px] w-full h-8 px-2  border-gray-300 text-base focus:border-blue-400 focus:ring-blue-200 text-black block rounded font-sans disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-500 focus:ring focus:ring-opacity-50 placeholder:text-gray-400'

</script>
<template>
  <div>
    <twice-ui-label
      :for="htmlId"
      :required="required"
      :label="label"
    />
    <div :class="cn('group relative rounded-md border border-input focus-within:border-primary', extraClass ?? '')">
      <input
        :id="htmlId"
        v-model="value"
        :class="cn('flex h-10 w-full border-0 text-right placeholder:text-left rounded-md bg-background px-3 py-2 pr-10  text-base text-primary focus:outline-none focus:border-primary', props.class ?? '', extraClass ?? '')"
        :placeholder="placeholder"
        :name="name"
        type="text"
      >
      <div class="absolute inset-y-0 right-0 items-center py-0.5 pr-0.5 flex flex-col -gap-y-px divide-y divide-gray-200 border-l border-input">
        <button
          type="button"
          :class="buttonClass"
          @click="onPlus"
        >
          <twice-ui-icon
            class="size-3"
            name="plus"
          />
        </button>
        <button
          type="button"
          :class="buttonClass"
          @click="onMinus"
        >
          <twice-ui-icon
            class="size-3"
            name="minus"
          />
        </button>
      </div>
    </div>
  </div>
</template>
