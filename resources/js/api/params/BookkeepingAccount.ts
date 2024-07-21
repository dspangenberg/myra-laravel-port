import type { Tax } from './Tax'
export interface BookkeepingAccount {
  id?: number | null
  account_number: number
  name: string
  label: string
  type: string
  is_default: boolean
  tax_id: number
  tax: Tax
}
