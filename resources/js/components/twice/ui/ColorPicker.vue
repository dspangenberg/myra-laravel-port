<script setup lang="ts">
import { computed, onMounted, ref, toRef } from 'vue'
import { onClickOutside } from '@vueuse/core'
import { getHexFromTailwind } from '@/utils/Tailwind.js'
import { useField } from 'vee-validate'

export interface Props {
  label?: string
  name: string,
  rules?: string
  placeholder?: string
  disabled?: boolean
  autofocus?: boolean
  readonly?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  label: '',
  rules: '',
  placeholder: '',
  disabled: false,
  autofocus: false,
  readonly: false
})

const name = toRef(props, 'name')
const rules = toRef(props, 'rules')
const label = toRef(props, 'label')

const target = ref(null)
onClickOutside(target, () => { isOpen.value = false })
const { value, errorMessage, meta } = useField<string>(name, rules, { label })
const colors = ref(['red', 'pink', 'purple', 'indigo', 'blue', 'cyan', 'teal', 'green', 'yellow', 'orange'])
const variants = ref([100, 200, 300, 400, 500, 600, 700, 800, 900])
const isOpen = ref(false)

defineEmits(['update:modelValue'])

const getStyle = (color: string, variant: number = 0) => {
  if (variant) {
    color = color + '-' + variant
  }

  const hex = getHexFromTailwind(color)
  return {
    backgroundColor: hex
  }
}

const selectColor = (color: string, variant: number = 0) => {
  if (variant) {
    color = color + '-' + variant
  }

  const hex = getHexFromTailwind(color)
  value.value = hex.toUpperCase()
  isOpen.value = false
}

onMounted(() => {
  value.value = value.value?.toUpperCase()
})

const hasError = computed(() => meta.touched && errorMessage.value !== undefined)

</script>

<template>
  <div>
    <template v-if="label">
      <div class="flex items-center flex-1">
        <div class="flex-1">
          <twice-ui-label
            v-if="label"
            :label="label"
            :required="rules.includes('required')"
          />
        </div>
      </div>
    </template>
    <div class="bg-white ">
      <div>
        <div class="relative flex flex-row">
          <div
            class="absolute inset-y-0 left-0 flex items-center pl-2 border border-transparent"
          >
            <div
              class="w-5 h-5 border rounded-full"
              :style="{
                backgroundColor: value
              }"
            />
          </div>
          <input
            id="color-picker"
            v-model="value"
            class="block w-full h-8 px-2 pl-8 font-sans text-base text-black border-gray-300 rounded focus:border-blue-400 focus:ring-blue-200 disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-500 focus:ring focus:ring-opacity-50 placeholder:text-gray-400"
            :class="
              [
                'font-sans',
                disabled ? 'bg-gray-50' : '',
                hasError ? ' focus:border-red-400 bg-red-50  focus:ring-red-200 border-red-300' : 'border-gray-300 focus:border-blue-400  focus:ring-blue-200',
              ]
            "
            :disabled="disabled"
            autocomplete="off"
            :autofocus="autofocus"
            :placeholder="placeholder"
            :name="name"
            type="text"
            :readonly="readonly"
            @click="isOpen = true"
          >
        </div>
        <div class="relative">
          <div
            v-show="isOpen"
            ref="target"
            transition:enter="transition ease-out duration-100 transform"
            transition:enter-start="opacity-0 scale-95"
            transition:enter-end="opacity-100 scale-100"
            transition:leave="transition ease-in duration-75 transform"
            transition:leave-start="opacity-100 scale-100"
            transition:leave-end="opacity-0 scale-95"
            class="absolute left-0 z-0 mt-2 origin-top-left bg-white border border-gray-300 rounded-md shadow-lg top-full"
          >
            <div class="p-2 bg-white rounded-md shadow-xs">
              <div class="flex space-x3 space-y2">
                <template
                  v-for="(variant, index) in variants"
                  :key="index"
                >
                  <div class="">
                    <template
                      v-for="(color, index2) in colors"
                      :key="index2"
                    >
                      <div class="flex items-center justify-center border border-gray-100 rounded-full w-7 h-7">
                        <div
                          class="w-6 h-6 border border-white rounded-full cursor-pointer"
                          :style="getStyle(color, variant)"
                          @click="selectColor(color, variant)"
                        />
                      </div>
                    </template>
                  </div>
                </template>
                <div class="flex items-center justify-center border border-gray-100 rounded-full w-7 h-7">
                  <div
                    class="w-6 h-6 border border-gray-400 rounded-full cursor-pointer"
                    :style="getStyle('white')"
                    @click="selectColor('white')"
                  />
                </div>
                <div class="flex items-center justify-center border border-gray-100 rounded-full w-7 h-7">
                  <div
                    class="w-6 h-6 border border-white rounded-full cursor-pointer"
                    :style="getStyle('black')"
                    @click="selectColor('black')"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
