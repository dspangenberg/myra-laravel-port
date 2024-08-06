<script lang="ts" setup>

import { computed, useSlots, toRef, inject } from 'vue'
import { id as id2 } from 'random-html-id'
import { useVModel } from '@vueuse/core'

export interface Props {
  label?: string
  type?: string
  id?: string
  error?: string,
  autocomplete?: string
  prefix?: string
  suffix?: string
  help?: string
  modelValue: string | number
  placeholder?: string
  prefixClass?: string
  suffixClass?: string
  autofocus?: boolean
  required?: boolean
  readonly?: boolean
  disabled?: boolean
  rows?: number
  rules?: string
  maxlength?: number
  inputClass?: string
}

const props = withDefaults(defineProps<Props>(), {
  label: '',
  required: false,
  maxlength: 524288,
  type: 'text',
  error: '',
  autocomplete: 'off',
  prefix: undefined,
  id: undefined,
  suffix: '',
  help: '',
  placeholder: '',
  prefixClass: 'pl-10',
  suffixClass: 'pr-10',
  autofocus: false,
  readonly: false,
  disabled: false,
  rules: '',
  rows: 5,
  inputClass: ''
})

const emit = defineEmits(['update:modelValue', 'change'])
const data = useVModel(props, 'modelValue', emit)

const hasError = computed(() => false)// form  ? form.invalid(props.id) : false)

const label = toRef(props, 'label')

// const { value, errorMessage, meta } = useField<string | number>(name, rules, { label })
const htmlId = computed(() => props.id ?? `input-${id2()}`)
// const hasError = computed(() => meta.touched && errorMessage.value !== undefined)
const $slots = useSlots()
const hasPrefix = computed(() => !!$slots.prefix || props.prefix)
const hasSuffix = computed(() => !!$slots.suffix || props.suffix)

</script>

<template>
  <div>
    <template v-if="label || error">
      <div class="flex-1 flex items-center">
        <div class="flex-1">
          <twice-ui-label
            v-if="label"
            :label="label"
            :required="required"
          />
        </div>
      </div>
    </template>
    <template v-if="type == 'textarea'">
      <textarea
        :id="htmlId"
        ref="textarea"
        v-model="data"
        :class="[disabled ? 'bg-gray-50' : '', inputClass]"
        :disabled="disabled"
        :maxlength="maxlength"
        :readonly="readonly"
        :rows="rows"
        class="w-full rounded-md py-1.5 border-gray-300 text-base font-normal text-gray-800 focus:ring-2 form-textarea resize-none border px-1.5 focus:border-blue-400 focus:outline-none focus:ring-blue-200 placeholder-gray-400"
      />
    </template>
    <template v-else>
      <div class="w-full relative">
        <div
          v-if="hasPrefix || prefix"
          class="flex border absolute items-center pointer-events-none inset-y-0 left-0 border-transparent pl-2"
        >
          <span
            class="text-base text-gray-500"
          >
            <slot name="prefix">
              {{ prefix }}
            </slot>
          </span>
        </div>
        <input
          :id="htmlId"
          v-model="data"
          :autocomplete="autocomplete"
          :autofocus="autofocus"
          :class="
            [
              'font-sans',
              disabled ? 'bg-gray-50' : '',
              hasPrefix ? prefixClass : '',
              hasSuffix ? suffixClass : '',
              hasError ? ' focus:border-red-400 bg-red-50  focus:ring-red-200 border-red-300' : 'border-gray-300 focus:border-blue-400  focus:ring-blue-200',
              inputClass
            ]
          "
          :disabled="disabled"
          :maxlength="maxlength"
          :placeholder="placeholder"
          :readonly="readonly"
          :type="type"
          class="w-full h-9 px-2 border-input text-base text-black block rounded font-sans disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-500 focus:ring focus:ring-opacity-50 placeholder:text-gray-400"
          @change="emit('change')"
        >
        <div
          v-if="hasSuffix || suffix"
          class="absolute inset-y-0 flex items-center border border-transparent right-0 pr-2"
        >
          <slot
            name="suffix"
          >
            <span class="text-base text-gray-500">
              {{ suffix }}
            </span>
          </slot>
        </div>
      </div>
    </template>
    <div
      class="flex text-sm item-center pt-1"
    >
      <div
        class="font-normal flex-1 text-gray-400"
      >
        <slot>{{ help }}</slot>
      </div>
    </div>
  </div>
</template>
