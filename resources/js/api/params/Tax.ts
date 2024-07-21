export interface Tax {
  id?: number | null
  name: string
  invoice_text: string
  value: number
  needs_vat_id: boolean
  account_input_tax: number,
  account_vat: number,
  is_default: boolean,
  tax_code_number: number,
  is_bidirectional: boolean,
}
