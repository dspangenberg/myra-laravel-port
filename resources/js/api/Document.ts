import { type Meta, PdfResponse } from '@/types/'
import { useAxios } from '@/composables/useAxios'

import { type Contact } from '@/api/Contact'
import { DocumentFolder } from '@/api/params/DocumentFolder'
const { axios } = useAxios(true)

const baseUrl: string = '/api/documents'

export interface Document {
  id?: number
  issued_on: string
  org_file: string
  doc_file_name: string
  preview: string
  fulltext: string
  subject: string
  contact_id: number
  contact: Contact
  size: number
  received_on: string
  number_of_pages: number
  alternate_subject: string
  is_confirmed: boolean
  is_marked: boolean
  document_folder_id: number
  folder?: DocumentFolder
  sender: string
  year: number
}

export interface QueryParams {
  view: 'list' | 'inbox'
  year?: number
  is_confirmed: boolean
  is_marked: boolean
}

export interface ResponseWithMeta {
  data: Document[],
  meta: Meta
}

export interface Response {
  data: Document
}

export interface CreateResponse extends Response {
}

export const getAllDocuments = async (qs: string = ''): Promise<ResponseWithMeta> => {
  return await axios.$get(`${baseUrl}/${qs}`) as ResponseWithMeta
}
