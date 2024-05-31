<script setup lang="ts">
import { computed, ref } from 'vue'
import { Menu, MenuButton, MenuItems } from '@headlessui/vue'

export interface Props {
  icon?: string
  iconVariant?: string
  iconStrokeWidth?: number
  shortcut?: string | number
  disabled?: boolean
  iconSize?: string
  label?: string
  widthClass?: string
  origin?: string
}

const props = withDefaults(defineProps<Props>(), {
  icon: 'dots',
  iconSize: 'md',
  iconVariant: 'ghost',
  shortcut: '',
  disabled: false,
  label: '',
  iconStrokeWidth: 1,
  dropdownOffsetDistance: 4,
  widthClass: 'w-full',
  origin: 'top-right'
})

const menuButton = ref()

const originClass = computed(() => {
  return {
    'top-right': 'origin-top-right right-0',
    'top-left': 'origin-top-left left-0',
    'bottom-left': 'origin-bottom-left bottom-10 left-0',
    'bottom-right': 'origin-bottom-right bottom-10 right-1',
    top: 'origin-top left-1/2 transform -translate-x-1/2',
    bottom: 'origin-bottom left-1/2 transform -translate-x-1/2  bottom-10'
  }[props.origin]
})

</script>
<template>
  <Menu
    as="div"
    class="relative inline-block text-left h-auto flex-1  "
  >
    <div
      class="z-100"
    >
      <MenuButton
        ref="menuButton"
        :disabled="disabled"
        class="items-center flex flex-1 w-full  focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75"
      >
        <slot name="trigger">
          <twice-ui-icon-button
            :label="label"
            :icon="icon"
            :variant="iconVariant"
            :size="iconSize"
            :stroke-width="iconStrokeWidth"
          />
        </slot>
      </MenuButton>
    </div>
    <transition
      enter-active-class="transition duration-100 ease-out"
      enter-from-class="transform scale-95 opacity-0"
      enter-to-class="transform scale-100 opacity-100"
      leave-active-class="transition duration-75 ease-in"
      leave-from-class="transform scale-100 opacity-100"
      leave-to-class="transform scale-95 opacity-0"
    >
      <MenuItems
        class="bg-white rounded-t-md absolute rounded-md shadow-md divide-y z-500 ring-1 ring-black/5 focus:outline-none"
        :class="[originClass, widthClass]"
      >
        <slot />
      </Menuitems>
    </Transition>
  </Menu>
</template>
