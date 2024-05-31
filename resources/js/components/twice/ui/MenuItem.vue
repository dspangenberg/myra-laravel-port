<script setup lang="ts">
import { computed, ref, useSlots } from 'vue'
import { MenuItem } from '@headlessui/vue'

export interface Props {
  icon?: string
  iconVariant?: string
  iconStrokeWidth?: number
  shortcut?: string | number
  checked?: boolean
  checkable?: boolean
  disabled?: boolean
  danger?: boolean
  primary?: boolean
  preventClose?: boolean
  small?: boolean
  iconSize?: string
  href?: string
  label?: string
  defaultItem?: boolean
  help?: string
  widthClass?: string
  origin?: string
}

const props = withDefaults(defineProps<Props>(), {
  icon: 'dots',
  iconSize: 'md',
  iconVariant: 'ghost',
  shortcut: '',
  help: '',
  disabled: false,
  primary: false,
  label: '',
  default: false,
  checkable: false,
  defaultItem: false,
  href: '',
  checked: true,
  iconStrokeWidth: 1,
  preventClose: false,
  widthClass: 'w-72',
  origin: 'top-right'
})

const emit = defineEmits(['click', 'closeMenu'])

const hasShortcut = computed(() => !!$slots.shortcut || props.shortcut)
const hasHelp = computed(() => !!$slots.help || props.help)
const $slots = useSlots()

const closeFunction = ref(null)

defineExpose({ closeFunction })
const getIcon = computed(() => {
  return props.checkable && props.checked === true ? 'tabler-check' : props.icon
})

const onMenuClicked = (close: Function) => {
  if (!props.disabled) {
    if (props.href) {
      if (props.preventClose === false) {
        close()
      }
      if (props.href) {
        window.location.href = props.href
      }
    } else {
      if (props.preventClose === false) {
        close()
      }
      emit('click')
    }
  }
}
</script>
<template>
  <MenuItem
    v-slot="{ close, active }"
    :disabled="disabled"
  >
    <button
      :class="[
        danger && !disabled ? 'hover:text-red-500 hover:bg-red-50' : '',
        disabled ? 'cursor-not-allowed' : 'cursor-pointer',
        active ? 'bg-stone-100 text-black' : 'text-gray-800',
        'group flex w-full items-center rounded px-2 py-2 text-sm hover:bg-stone-100'
      ]"
      @click.prevent="onMenuClicked(close)"
    >
      <span
        v-if="icon || checked ||checkable"
        class="w-4.5 flex-none"
      >
        <twice-ui-icon
          v-if="icon || checked "
          :name="getIcon"
          :stroke-width="2"
          class="flex-none  w-5 h-5"
          :class="[danger && !disabled ? 'group-hover:text-red-500 hover:bg-red-50' : '', disabled ? '!text-gray-300' : '', checkable && checked ? 'text-blue-500' : 'text-gray-600']"
        />
      </span>
      <span
        class="flex-1 text-left ml-2"
        :class="[danger && !disabled ? 'group-hover:text-red-500 hover:bg-red-50' : '', disabled ? 'text-gray-300' : '', primary ? '' : '', defaultItem ? 'font-medium' : '']"
      >
        {{ label }}
        <div
          v-if="hasHelp"
          class="text-xs  pt-1"
          :class="disabled ? 'text-gray-300' : 'text-gray-400'"
        >
          <slot name="help">{{ help }}</slot>
        </div>
      </span>
      <span
        v-if="hasShortcut"
        class="flex-none text-gray-400"
        :class="[danger && !disabled ? 'group-hover:text-red-500 hover:bg-red-50' : '', disabled ? 'text-gray-300' : '']"
      >
        <slot name="shortcut">{{ shortcut }}</slot>
      </span>
    </button>
  </MenuItem>
</template>
