import { type VariantProps, cva } from 'class-variance-authority'

export { default as Avatar } from './Avatar.vue'
export { default as AvatarImage } from './AvatarImage.vue'
export { default as AvatarFallback } from './AvatarFallback.vue'

export const avatarVariant = cva(
  'inline-flex items-center justify-center font-medium text-foreground select-none shrink-0 overflow-hidden border border-stone-200',
  {
    variants: {
      size: {
        xs: 'size-7 text-xxs',
        sm: 'size-8 text-xxs',
        md: 'size-10 text-sm',
        lg: 'size-12 text-base'
      },
      shape: {
        circle: 'rounded-full',
        square: 'rounded-md'
      }
    }
  }
)

export type AvatarVariants = VariantProps<typeof avatarVariant>
