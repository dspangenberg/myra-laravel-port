import { useAxios } from '@/composables/useAxios'

import { type Meta } from '@/types/'
import { type ReceiptCategory } from '@/api/params/ReceiptCategory'
import { type Contact } from '@/api/Contact'

const { axios } = useAxios(true)
const baseUrl: string = '/api/receipts'

export interface Receipt {
  id?: number
  receipts_ref: string
  reference: string
  receipt_category_id: number
  category: ReceiptCategory
  contact_id: number
  contact: Contact
  issued_on: string
  tax_rate: number
  amount: number
  currency_code: string
  real_document_number: string
  exchange_rate: number
  gross: number
  net: number
  tax: number
  title: string
  pdf_file: string
  export_file_name: string
  amount_to_pay: number
  text: string
  tax_code_number: string
  payments_sum_amount: number
}

export interface Response {
  data: Receipt
}
export interface EditOrCreateResponse extends Response {
  data: Receipt
}

export interface GroupedEntry {
  entries: Receipt[],
  name: string,
  sum_gross: number,
  sum_net: number,
  sum_tax: number,
  sum_tax_67: number,
  sum_amount_to_pay: number,
  sum_tax_85: number
  sum_tax_81: number
}

export interface GroupedList {
  [key: number]: GroupedEntry
}

export interface ResponseWithMeta {
  data: Receipt[],
  meta: Meta
  grouped: GroupedList
}

export const getAllReceipt = async (qs: string): Promise<ResponseWithMeta> => {
  const { meta, data, grouped } = await axios.$get(`${baseUrl}/${qs}`) as ResponseWithMeta
  return { meta, data, grouped }
}

export const createOrEditReceipt = async (id?: number): Promise<EditOrCreateResponse> => {
  const url = id ? `${baseUrl}/${id}/edit` : `${baseUrl}/create`
  return await axios.$get(url)
}

export const findReceiptById = async (id: number): Promise<Response> => {
  const { data } = await axios.$get(`${baseUrl}/${id}`) as unknown as Response
  return { data }
}
export const createReceipt = async (payload: Receipt): Promise<Response> => {
  return await axios.$post(baseUrl, payload)
}

export const updateReceipt = async (payload: Receipt) => {
  await axios.$put(`${baseUrl}/${payload.id}`, payload)
}
