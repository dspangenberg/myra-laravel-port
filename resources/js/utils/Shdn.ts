import { type ClassValue, clsx } from 'clsx'
import { twMerge } from 'tailwind-merge'

// https://tailwindui.com/components/application-ui/data-display/description-lists

export function cn (...inputs: ClassValue[]) {
  return twMerge(clsx(inputs))
}
