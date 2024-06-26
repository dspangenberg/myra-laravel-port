import { type Meta, PdfResponse } from '@/types/'
import { useAxios } from '@/composables/useAxios'
import { type Project } from '@/api/Project'
import { type User } from '@/api/User'
import { TimeCategory } from '@/api/params/TimeCategory'
import { EditOrCreateResponse } from '@/api/Contact'
const { axios } = useAxios(true)

const baseUrl: string = '/api/times'

export interface Time {
  id?: number
  project_id: number
  project?: Project
  user_id: number
  user?: User
  time_category_id: number
  ts?: string
  mins: number
  category?: TimeCategory
  minutes: number
  begin_at: string
  end_at: string
  sum?: number
  note: string
  is_locked: boolean
  is_billable: boolean
  is_timer: boolean
}

export interface TimeStats {
  start?: string
  end?: string
  week: number
  year: number
  sumByWeekday: number[]
  sumWeek: number
}

export interface GroupedEntries {
  entries: {
    [key: number]: Time
  },
}

export interface GroupedByDate {
  [key: string]: {
    entries:GroupedEntries,
    date: string,
    formatedDate: string
    sum: number
  }
}

export interface GroupedByProject {
  [key: number]: {
    entries: GroupedEntries,
    sum: number
    name: string
  }
}

export interface QueryParams {
  type: 'week' | 'list'
  year?: number
  week?: number
}

export interface ResponseWithMeta {
  data: Time[],
  meta: Meta
  stats: TimeStats
  groupedByDate: GroupedByDate,
  groupedByProject: GroupedByProject
}

export interface Response {
  data: Time
}

export interface CreateResponse extends Response {
  projects: Project[],
  users: User[]
  categories: TimeCategory[]
}

export const getAllTimes = async (qs: string = ''): Promise<ResponseWithMeta> => {
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
