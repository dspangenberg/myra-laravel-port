import { type Meta, PdfResponse } from '@/types/'
import { useAxios } from '@/composables/useAxios'
import { type Project } from '@/api/Project'
import { type User } from '@/api/User'
import type { Tax } from '@/api/params/Tax'
import type { BookkeepingAccount } from '@/api/params/BookkeepingAccount'

const { axios } = useAxios(true)

const baseUrl: string = '/api/bookings'

export interface Booking {
  id?: number
  transaction_id: number
  receipt_id: number
  payment_id: number
  account_id_credit: number
  account_credit: BookkeepingAccount
  account_id_debit: number
  account_debit: BookkeepingAccount
  tax_id: number
  tax: Tax
  amount: number
  date: string
  is_split: boolean
  split_id: number | null
  booking_text: string
  note: string
  document_number: string
  tax_credit: number
  tax_debit: number
  is_locked: boolean
}

export interface QueryParams {
  type: 'week' | 'list'
  year?: number
  week?: number
}

export interface ResponseWithMeta {
  data: Booking[],
  meta: Meta
}

export interface Response {
  data: BookkeepingAccount
}

export const getAllBookings = async (qs: string = ''): Promise<ResponseWithMeta> => {
  return await axios.$get(`${baseUrl}/${qs}`) as ResponseWithMeta
}

export const findTimeById = async (id: number): Promise<Response> => {
  const { data } = await axios.$get(`${baseUrl}/${id}`) as Response
  return { data }
}

export const createProofOfActivityPdf = async (qs: string = ''): Promise<PdfResponse> => {
  const { dataUrl, base64 } = await axios.$getPdf(`${baseUrl}/${qs}`) as PdfResponse
  return { dataUrl, base64 }
}

export const createOrEditTime = async (id?: number): Promise<CreateResponse> => {
  const url = id ? `${baseUrl}/${id}/edit` : `${baseUrl}/create`
  return await axios.$get(url)
}
export const editTime = async (id: number): Promise<CreateResponse> => {
  const { data, projects, users, categories } = await axios.$get(`${baseUrl}/${id}/edit`) as CreateResponse
  console.log({ data, projects, users, categories })
  return { data, projects, users, categories }
}

export const storeTime = async (payload: Time) => {
  await axios.$post(baseUrl, payload)
}

export const updateTime = async (payload: Time) => {
  await axios.$put(`${baseUrl}/${payload.id}`, payload)
}
