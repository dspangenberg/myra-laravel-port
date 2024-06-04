import { type Meta } from '@/types/'
import { useAxios } from '@/composables/useAxios'
import { type Project } from '@/api/Project'
import { type User } from '@/api/User'
import { TimeCategory } from '@/api/params/TimeCategory'

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

export interface GroupedTimeEntries {
  [key: string]: {
    entries: Time[],
    sum: number
  }
}

export interface QueryParams {
  type: 'week' | 'all' | 'filtered'
  year?: number
  week?: number
}

export interface ResponseWithMeta {
  data: Time[],
  meta: Meta
  stats: TimeStats
  groupedByDay: GroupedTimeEntries
}

export interface Response {
  data: Time
}

export interface CreateResponse extends Response {
  projects: Project[],
  users: User[]
  categories: TimeCategory[]
}

export const getAllTimes = async (params?: QueryParams): Promise<ResponseWithMeta> => {
  const { meta, data, groupedByDay, stats } = await axios.$get(baseUrl, params) as ResponseWithMeta
  return { meta, data, stats, groupedByDay }
}

export const findTimeById = async (id: number): Promise<Response> => {
  const { data } = await axios.$get(`${baseUrl}/${id}`) as Response
  return { data }
}

export const createProofOfActivityPdf = async () => {
  const response = await axios.$get(`${baseUrl}/pdf`, {}, { responseType: 'blob' })
  const url = window.URL.createObjectURL(new Blob([response as unknown as BlobPart]))
  const link = document.createElement('a')
  link.href = url
  link.setAttribute('download', 'file.pdf')
  document.body.appendChild(link)
  link.click()
}

export const createTime = async (): Promise<CreateResponse> => {
  const { data, projects, users, categories } = await axios.$get(`${baseUrl}/create`) as CreateResponse
  return { data, projects, users, categories }
}

export const editTime = async (id: number): Promise<CreateResponse> => {
  const { data, projects, users, categories } = await axios.$get(`${baseUrl}/${id}/edit`) as CreateResponse
  return { data, projects, users, categories }
}

export const storeTime = async (payload: Time) => {
  await axios.$post(baseUrl, payload)
}

export const updateTime = async (payload: Time) => {
  await axios.$put(`${baseUrl}/${payload.id}`, payload)
}
