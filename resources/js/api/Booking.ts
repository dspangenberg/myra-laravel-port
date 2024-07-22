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
