import { useAxios } from '@/composables/useAxios'

import { type Meta } from '@/types/'
import { type BankAccount } from '@/api/params/BankAccount'
import { type Contact } from '@/api/Contact'
import { Booking } from '@/api/Booking'

const { axios } = useAxios(true)
const baseUrl: string = '/api/transactions'

export interface Transaction {
  id: number
  booked_on: string
  valued_on: string
  contact_id: number
  contact: Contact
  bank_code: number
  account_number: number
  name: string
  purpose: string
  is_private: boolean
  is_transfer: boolean
  amount: number
  currency_code: string
  amount_in_foreign_currency: number
  payable_sum_amount: number
  is_transit: boolean
  currency: string
  booking_text: string
  document_number: string
  bookkepping_text: string
  booking: Booking
}

export interface Response {
  data: Transaction
}

export interface ResponseWithMeta {
  data: Transaction[],
  meta: Meta
  bank_accounts: BankAccount[]
}

export const getAllTransactions = async (qs: string): Promise<ResponseWithMeta> => {
  return await axios.$get(`${baseUrl}/${qs}`) as ResponseWithMeta
}
