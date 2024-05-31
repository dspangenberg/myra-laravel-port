import { computed } from 'vue'
import { type Props } from '@/components/twice/ui/IconButton.vue'

interface KeyValue {
  [field: string]: string
}

export function useButton (props: Props, variant: string = 'ghost') {
  if (variant) {
    props.variant = variant
  }

  const variants: KeyValue = {
    outline: 'cursor-pointer shadow-sm border border-neutral-200 rounded relative text-neutral-900 bg-transparent hover:bg-neutral-100 hover:border-neutral-300  focus:border-transparent focus:outline-none focus:ring-2 ring-offset-white focus:ring-blue-500 active:bg-neutral-200',
    primary: 'cursor-pointer shadow-sm border border-transparent rounded relative text-white bg-blue-600 hover:bg-blue-500  focus:border-white focus:outline-none focus:ring-2 ring-offset-white focus:ring-blue-500 active:bg-blue-700',
    danger: 'cursor-pointer shadow-sm border border-transparent rounded relative text-white bg-red-600 hover:bg-red-500  focus:border-white focus:outline-none focus:ring-2 ring-offset-white focus:ring-red-500 active:bg-red-700',
    solid: 'cursor-pointer shadow-sm border border-neutral-300 rounded relative text-neutral-900 bg-neutral-200 hover:bg-neutral-300 hover:border-neutral-400  focus:border-transparent focus:outline-none focus:ring-2 ring-offset-white focus:ring-blue-500 active:bg-neutral-200',
    solidWhite: 'cursor-pointer shadow-sm border border-neutral-300 rounded relative text-neutral-900 bg-white hover:bg-neutral-300 hover:border-neutral-400  focus:border-transparent focus:outline-none focus:ring-2 ring-offset-white focus:ring-blue-500 active:bg-neutral-200',
    light: 'cursor-pointer shadow-sm border border-transparent rounded relative text-neutral-900 bg-neutral-100 hover:bg-neutral-200 hover:border-transparent  focus:border-transparent focus:outline-none focus:ring-2 ring-offset-white focus:ring-blue-500 active:bg-neutral-300',
    ghost: 'cursor-pointer border border-transparent rounded text-center text-neutral-900 bg-transparent hover:bg-neutral-100 hover:border-neutral-300 focus:outline-none  focus:border-blue-400  focus:ring-2 focus:ring-blue-200 focus:outline-none active:bg-neutral-200',
    lghost: 'cursor-pointer border border-transparent rounded text-center text-gray-500 bg-transparent hover:bg-neutral-100 hover:border-neutral-300 focus:outline-none  focus:border-blue-400  focus:ring-2 focus:ring-blue-200 focus:outline-none active:bg-neutral-200',
    dghost: 'cursor-pointer border border-transparent rounded text-center text-neutral-900 bg-transparent hover:bg-neutral-100 hover:text-red-600 hover:border-red-300 focus:outline-none focus:ring-2 focus:ring-red-200 active:!bg-red-50 focus:text-red-400 focus:border-red-400',
    pghost: 'cursor-pointer border border-transparent rounded relative text-blue-500 hover:text-white bg-transparent hover:bg-blue-400  focus:border-white focus:outline-none focus:ring-2 ring-offset-white focus:ring-blue-500 active:bg-blue-700',
    navbar: 'cursor-pointer border rounded border-transparent text-center text-gray-700 disabled:text-gray-300 bg-transparent hover:text-black focus:outline-none focus:ring-2 ring-offset-white focus:ring-blue-500 active:bg-neutral-900',
    link: 'cursor-pointer border border-transparent text-blue-500 bg-transparent hover:text-blue-600 hover:border-neutral-300 focus:outline-none  focus:border-blue-400  focus:ring-2 focus:ring-blue-200 focus:outline-none active:bg-neutral-900',
    'dark-ghost': 'cursor-pointer border border-transparent rounded text-center text-white hover:text-black bg-transparent hover:bg-neutral-100 hover:border-neutral-300 focus:outline-none  focus:border-blue-400  focus:ring-2 focus:ring-blue-200 focus:outline-none active:bg-neutral-200'
  }

  const sizes: KeyValue = {
    lg: 'h-10 w-10',
    md: 'h-8 w-8',
    sm: 'h-6 w-6',
    full: 'w-full h-8',
    auto: 'h-8 text-sm',
    link: 'm-0'
  }

  const iconSizes: KeyValue = {
    lg: 'size-8',
    sm: 'h-5 w-5',
    md: 'size-6',
    full: 'h-5 h-5',
    auto: 'h-5 h-5'
  }

  const getClasses = computed(() => getVariant.value + ' ' + getSize.value)
  const getVariant = computed(() => {
    if (!props.variant) {
      props.variant = 'default'
    }

    let classes: string = props.disabled ? disable(variants[props.variant]) : variants[props.variant]

    if (props?.active) {
      classes = classes + ' active'
    }

    if (props.disabled) {
      classes = classes + ' cursor-not-allowed text-gray-400'
    }

    if (props.removeBorder) {
      classes = removeClasses(classes, ['border', 'hover:border', 'rounded'])
    }

    if (props.active === true && props.variant === 'navbar') {
      console.log('****')
      classes = classes.replace('bg-transparent', 'bg-gray-800')
      classes = classes.replace('text-gray-700', 'text-yellow-500')
    }

    return props.focusOnClick ? classes : removeClasses(classes, ['focus:', 'active:'])
  })

  const getSize = computed(() => props.size ? sizes[props.size] : 'md')
  const getIconSize = computed(() => props.size ? iconSizes[props.size] : 'md')

  const removeClasses = (classes: string, classesToRemove: string[]) => {
    const removes: string[] = []
    let classesArray: string[] = classes.split(' ')

    for (const name of classesArray) {
      for (const remove of classesToRemove) {
        if (name.startsWith(remove)) {
          removes.push(name)
        }
      }
    }

    classesArray = classesArray.filter(item => !removes.includes(item))
    return classesArray.join(' ')
  }

  const disable = (classes: string) => {
    classes = classes.replace(
      props.variant === 'primary' ? 'bg-blue-600' : '',
      props.variant === 'primary' ? 'bg-gray-300' : ''
    )

    classes = classes.replace(
      props.variant === 'primary' ? 'text-white' : 'text-neutral-900',
      props.variant === 'primary' ? 'text-gray-500' : 'text-neutral-300'
      // props.variant === 'iconbar' ? 'text-white' : 'text-gray-600'
    )
    classes = classes.replace('cursor-pointer', '')

    return removeClasses(classes, [
      'active:', 'hover:', 'focus:'
    ])
  }

  return { getClasses, getIconSize }
}
