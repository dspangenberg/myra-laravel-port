<script generic="TValue" lang="ts" setup>
import { computed } from 'vue'
import { id as id2 } from 'random-html-id'
import { useVModel } from '@vueuse/core'

import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectTrigger,
  SelectValue
} from '@/components/shdn/ui/select'
import { type Option } from '@/types'

export interface Props {
  modelValue?: number | undefined
  rules?: string
  label?: string
  placeholder?: string
  id?: string
  empty?: boolean
  disabled?: boolean
  autofocus?: boolean
  required?: boolean
  options: Option[]
  selectClass?: string
  optionName?: string
  hideEmpty?: boolean
  optionsValue?: string
  onlyOptionsWithName?: boolean
  placeholderValue?: number | string | null
}

const props = withDefaults(defineProps<Props>(), {
  id: undefined,
  modelValue: 0,
  rules: undefined,
  label: '',
  placeholder: '(auswählen)',
  selectClass: '',
  disabled: false,
  hideEmpty: true,
  optionsValue: 'id',
  optionName: 'name',
  optionDisabled: 'disabled',
  onlyOptionsWithName: false,
  placeholderValue: 0,
  empty: false,
  autofocus: false,
  required: false
})

const filteredOptions = computed(() => props.options.filter(option => option[props.optionName as keyof Option] !== ''))

const emit = defineEmits(['update:modelValue', 'change'])
const data = useVModel(props, 'modelValue', emit)

const xid = id2()
const htmlId = computed(() => `select-${xid}`)
</script>
<template>
  <div class="p-0 m-0 bg-transparent border-0">
    <twice-ui-label
      v-if="label"
      :for="htmlId"
      :label="label"
      :required="required"
    />
    <Select
      v-model="data"
    >
      <SelectTrigger
        :id="htmlId"
        :autofocus="autofocus"
      >
        <SelectValue
          :class="selectClass"
          :placeholder="placeholder"
        />
      </SelectTrigger>

      <SelectContent
        :class="selectClass"
      >
        <SelectGroup>
          <SelectItem
            v-for="(item, index) in filteredOptions"
            :key="index"
            :group="item.group"
            :selected="item['id'] === data"
            :value="item[optionsValue as keyof Option] as unknown as string"
            class="text-sm"
          >
            {{ item[optionName as keyof Option] }}
          </SelectItem>
        </SelectGroup>
      </SelectContent>
    </Select>
  </div>
</template>
