<script setup lang="ts">
import { computed, toRefs, useSlots } from 'vue'
import { useButton } from '@/composables/useButton.js'
import { id as id2 } from 'random-html-id'

export interface Props {
  focusOnClick?: boolean
  removeBorder?: boolean
  active?: boolean
  variant?: string
  tag?: string
  icon?: string
  iconStrokeWidth?: number
  iconClass?: string
  id?: string
  href?: string
  extraClasses?: string
  disabled?: boolean
  type?: string
  target?: string
  tooltip?: string
  autofocus?: boolean
  size?: string
  loading?: boolean
  label?: string
  full?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  focusOnClick: true,
  removeBorder: false,
  variant: 'default',
  tag: 'button',
  icon: '',
  href: '',
  label: '',
  id: '',
  active: false,
  target: '',
  extraClasses: '',
  disabled: false,
  type: 'button',
  tooltip: '',
  tooltipPlacement: 'auto',
  autofocus: false,
  iconStrokeWidth: 2,
  size: 'md',
  loading: false,
  full: false,
  iconClass: '',
  spanClasses: ''
})

const $slots = useSlots()
const { active } = toRefs(props)

const htmlId = computed(() => props.id ?? `icon-button-${id2()}`)
const getVariant = computed(() => active.value && props.variant === 'ghost' ? 'solid' : props.variant)

const realProps = computed(() => {
  const realProps: Props = Object.assign({}, props)
  realProps.variant = getVariant.value
  return realProps
})

const getAs = computed(() => props.tag ? props.tag : props.href ? 'router-link' : 'button')
const getType = computed(() => getAs.value === 'button' ? 'button' : null)
const { getIconSize, getClasses } = useButton(realProps.value, getVariant.value)

const iconClasses = computed(() => props.iconClass + ' ' + getIconSize.value)

const hasSlot = computed(() => !!$slots.default)
const emit = defineEmits(['click'])

const onClick = () => {
  if (props.tag === 'a') return
  if (!props.disabled && !props.loading) {
    console.log('click')
    emit('click')
  }
}
</script>

<template>
  <component
    :is="getAs"
    :id="htmlId"
    v-tooltip="tooltip"
    :class="getClasses"
    :disabled="props.disabled"
    :target="target"
    :type="getType"
    class="flex items-center"
    @click="onClick"
  >
    <twice-ui-icon
      v-if="icon"
      :name="props.icon"
      :class="iconClasses"
      :stroke-width="iconStrokeWidth"
      class="mx-auto"
    />
    <div v-if="hasSlot">
      <slot />
    </div>
  </component>
</template>
