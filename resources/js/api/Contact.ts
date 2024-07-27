import { useAxios } from '@/composables/useAxios'

import { type Meta } from '@/types/'
import { type AddressCategory } from '@/api/params/AddressCategory'
import { type Country } from '@/api/params/Country'
import { type EmailCategory } from '@/api/params/EmailCategory'
import { type PaymentDeadline } from '@/api/params/PaymentDeadline'
import { type PhoneCategory } from '@/api/params/PhoneCategory'
import { type Salutation } from '@/api/params/Salutation'
import { type Tax } from '@/api/params/Tax'
import { type Title } from '@/api/params/Title'

const { axios } = useAxios(true)
const baseUrl: string = '/api/contacts'

export interface ContactMail {
  id?: number
  email_category_id: number
  pos: number
  contact_id: number
  email: string
}
export interface ContactInterface {
  id?: number
  company_id: number
  is_org: boolean
  name: string
  first_name: string
  salutation_id: number
  salutation: Salutation
  title_id: number
  title: Title
  position: string
  department: string
  short_name: string
  ref: string
  debtor_number: number
  creditor_number: number
  outturn_account_id: number
  iban: string
  cc_name: string
  is_primary: boolean
  is_debtor: boolean
  is_creditor: boolean
  is_archived: boolean
  has_dunning_block: boolean
  archived_reason: string
  payment_deadline_id: number
  payment_deadline: PaymentDeadline
  tax_id: number
  tax: Tax
  hourly: number
  register_court: string
  tax_number: string
  register_number: string
  vat_id: string
  note: string
  dob: string
  reverse_full_name?: string
  full_name?: string
  initials?: string
  mails: ContactMail[]
}

export interface Contact extends ContactInterface {
  company?: Contact
  contacts: Contact[],
}

export interface ResponseWithMeta {
  data: Contact[],
  meta: Meta
}

export interface Response {
  data: Contact
}
export interface EditOrCreateResponse extends Response {
  data: Contact
  address_categories: AddressCategory[],
  countries: Country[],
  email_categories: EmailCategory[],
  payment_deadlines: PaymentDeadline[],
  phone_categories: PhoneCategory[],
  salutations: Salutation[],
  taxes: Tax[]
  titles: Title[]
}

export const getAllContacts = async (qs: string): Promise<ResponseWithMeta> => {
  const { meta, data } = await axios.$get(`${baseUrl}/${qs}`) as ResponseWithMeta
  return { meta, data }
}

export const createOrEditContact = async (id?: number): Promise<EditOrCreateResponse> => {
  const url = id ? `${baseUrl}/${id}/edit` : `${baseUrl}/create`
  return await axios.$get(url)
}

export const findContactById = async (id: number): Promise<Response> => {
  const { data } = await axios.$get(`${baseUrl}/${id}`) as unknown as Response
  return { data }
}
export const createContact = async (payload: Contact): Promise<Response> => {
  return await axios.$post(baseUrl, payload)
}

export const updateContact = async (payload: Contact) => {
  await axios.$put(`${baseUrl}/${payload.id}`, payload)
}
