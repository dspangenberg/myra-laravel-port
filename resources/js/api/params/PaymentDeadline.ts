export interface PaymentDeadline {
  id?: number | null
  name: string
  days: number
  is_immediately: boolean
  is_default: boolean
}
