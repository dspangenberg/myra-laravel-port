<script setup lang="ts">
import { computed, ref, useSlots } from 'vue'
import { useFocusTrap } from '@vueuse/integrations/useFocusTrap'
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle
} from '@headlessui/vue'

const dialogRef = ref<HTMLElement | null>(null)
useFocusTrap(dialogRef)

export interface Props {
  show: boolean
  title?: string
  canClose?: boolean
  hideHeader?: boolean
  overflow?: boolean
  width?: string
  height?: string
}

const props = withDefaults(defineProps<Props>(), {
  show: false,
  title: '',
  canClose: true,
  hideHeader: false,
  overflow: true,
  width: 'md',
  height: 'auto'
})

const emit = defineEmits(['hide'])

const hide = () => {
  emit('hide')
}

const $slots = useSlots()
const hasHeader = computed(() => !!$slots.header)

const widthClass = computed(() => {
  return {
    xs: 'max-w-md',
    sm: 'max-w-xl',
    md: 'max-w-2xl ',
    lg: 'max-w-3xl',
    xl: 'max-w-7xl'
  }[props.width]
})

const getTitle = computed(() => {
  if (props.title.includes('|')) {
    return props.title.split('|').map(item => item.trim())
  }
  return props.title
})

const heightClass = computed(() => {
  return {
    auto: 'h-auto max-h-auto',
    sm: 'h-[20vh] max-h-[20vh] min-h-[20vh]',
    md: 'h-[50vh] max-h-[50vh] min-h-[50vh]',
    lg: 'max-h-4xl',
    xl: 'max-h-7xl'
  }[props.height]
})

</script>
<template>
  <div>
    <TransitionRoot
      :show="show"
      as="template"
    >
      <Dialog
        :open="show"
        class="relative z-50"
      >
        <TransitionChild
          enter="duration-300 ease-out"
          enter-from="opacity-0"
          enter-to="opacity-100"
          leave="duration-200 ease-in"
          leave-from="opacity-100"
          leave-to="opacity-0"
        >
          <div class="fixed inset-0 bg-black/30" />
        </TransitionChild>

        <TransitionChild
          enter="duration-300 ease-out"
          enter-from="opacity-0 scale-95"
          enter-to="opacity-100 scale-100"
          leave="duration-200 ease-in"
          leave-from="opacity-100 scale-100"
          leave-to="opacity-0 scale-95"
        >
          <div class="fixed inset-0 overflow-y-auto">
            <!-- Container to center the panel -->
            <div class="flex items-center justify-center min-h-full ">
              <DialogPanel
                ref="dialogRef"
                class="relative flex flex-col w-full h-full overflow-hidden text-left transition-all transform bg-white border rounded-md shadow-xl select-none"
                :class="[widthClass]"
              >
                <div
                  v-if="!hideHeader"
                  class="flex-none text-left"
                >
                  <div class="flex items-center bg-stone-100">
                    <DialogTitle
                      as="h3"
                      class="flex-1 py-3 pl-4 text-lg font-bold leading-6 text-gray-900"
                    >
                      <slot name="title">
                        <span v-if="Array.isArray(getTitle)">
                          {{ getTitle[0] }} &mdash; {{ getTitle[1] }}
                        </span>
                        <span v-else>
                          {{ getTitle }}
                        </span>
                      </slot>
                    </DialogTitle>

                    <button
                      type="button"
                      tabindex="-1"
                      class="flex-none mr-4 text-gray-400 rounded-md hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                      @click="hide"
                    >
                      <span class="sr-only">Close</span>
                      <twice-ui-icon
                        name="x"
                        class="w-4 h-4"
                      />
                    </button>
                  </div>
                </div>
                <div
                  v-if="hasHeader"
                  class="flex-none text-left"
                >
                  <slot name="header" />
                </div>
                <div
                  class="flex flex-1 mb-0 border-t-2 border-b-2 border-r-2 border-white"
                  :class="[heightClass, hasHeader ? '-mt-6' : '', overflow ? 'overflow-y-auto' : 'overflow-hidden flex flex-1']"
                >
                  <div
                    :class="[height !== 'auto' ? 'py-4 flex flex-1 ' : 'px-0 py-1', overflow ? '' : '!p-0']"
                    class="w-full flex items-stretch z-50 overflow-x-hidden overflow-y-hidden relative"
                  >
                    <slot name="content" />
                  </div>
                </div>
                <div class="flex flex-row-reverse items-start flex-none w-full px-4 py-3 bg-stone-50">
                  <slot
                    name="footer"
                    :close="hide"
                  >
                    <button
                      type="button"
                      class="inline-flex justify-center w-full h-2 px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                      @click="hide"
                    >
                      Schließen
                    </button>
                  </slot>
                </div>
              </DialogPanel>
            </div>
          </div>
        </TransitionChild>
      </Dialog>
    </TransitionRoot>
  </div>
</template>
