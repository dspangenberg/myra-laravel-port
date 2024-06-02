import { type Meta } from '@/types/'
import { useAxios } from '@/composables/useAxios'

const { axios } = useAxios(true)
const baseUrl: string = '/api/contacts'

export interface ContactInterface {
  id?: number
  company_id: number
  is_org: boolean
  name: string
  first_name: string
  salutation_id: number
  title_id: number
  position: string
  department: string
  short_name: string
  ref: string
  debtor_number: number
  creditor_number: number
  is_debtor: boolean
  is_creditor: boolean
  is_archived: boolean
  has_dunning_block: boolean
  archived_reason: string
  payment_deadline_id: number
  tax_id: number
  hourly: number
  register_court: string
  register_number: string
  vat_id: string
  note: string
  dob: string
  reverse_full_name?: string
  full_name?: string
  initials?: string
}

export interface Contact extends ContactInterface {
  company?: Contact
}

export interface ResponseWithMeta {
  data: Contact[],
  meta: Meta
}

export interface Response {
  data: Contact
}

export const getAllContacts = async (page: number = 1): Promise<ResponseWithMeta> => {
  const { meta, data } = await axios.$get(baseUrl, { page }) as ResponseWithMeta
  return { meta, data }
}

export const findContactById = async (id: number): Promise<Response> => {
  const { data } = await axios.$get(`${baseUrl}/${id}`) as unknown as Response
  return { data }
}
export const createContact = async (payload: Contact) => {
  await axios.$post(baseUrl, payload)
}

export const updateContact = async (payload: Contact) => {
  await axios.$put(`${baseUrl}/${payload.id}`, payload)
}
