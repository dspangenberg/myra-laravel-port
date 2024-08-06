import { type Meta, PdfResponse } from '@/types/'
import { useAxios } from '@/composables/useAxios'
import { type Project } from '@/api/Project'
import { type Contact } from '@/api/Contact'
import { PaymentDeadline } from '@/api/params/PaymentDeadline'
const { axios } = useAxios(true)

const baseUrl: string = '/api/invoices'

export interface Invoice {
  id?: number
  issued_on: string
  due_on: string
  invoice_number?: string
  contact_id: number
  contact?: Contact
  project_id: number
  project?: Project
  type_id: number
  is_draft: boolean
  has_dunning_block: boolean
  service_provision: string
  vat_id: string
  address: string
  payment_deadline_id: number
  payment_deadline: PaymentDeadline
  formated_invoice_number: string
  payable_sum_amount: number
  sent_at?: string
  filename: string
  lines_sum_amount: number
  lines_sum_tax: number
}

export interface ResponseWithMeta {
  data: Invoice[],
  meta: Meta
}

export interface Response {
  data: Invoice
}

export const getAllInvoices = async (qs: string = ''): Promise<ResponseWithMeta> => {
  return await axios.$get(`${baseUrl}/${qs}`) as ResponseWithMeta
}

export const createInvoicePdf = async (id: number): Promise<PdfResponse> => {
  const { dataUrl, base64 } = await axios.$getPdf(`${baseUrl}/${id}/pdf`) as PdfResponse
  return { dataUrl, base64 }
}
