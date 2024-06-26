export interface Tax {
  id?: number | null
  name: string
  invoice_text: string
  value: number
  needs_vat_id: boolean
  is_default: boolean
}
