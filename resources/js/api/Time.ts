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
  sumByWeekday: number[]
  sumWeek: number
}

export interface GroupedTimeEntries {
  [key: string]: {
    entries: Time[],
    sum: number
  }
}

export interface ResponseWithMeta {
  data: Time[],
  meta: Meta
  stats: TimeStats
  groupedByDay: GroupedTimeEntries
}

export interface Response {
  time: Time
}

export const getAllTimes = async (page: number = 1): Promise<ResponseWithMeta> => {
  const { meta, data, groupedByDay, stats } = await axios.$get(baseUrl, { page }) as ResponseWithMeta
  return { meta, data, stats, groupedByDay }
}

export const findTimeById = async (id: number): Promise<Response> => {
  const { time } = await axios.$get(`${baseUrl}/${id}`) as unknown as Response
  return { time }
}
export const createTime = async (payload: Time) => {
  await axios.$post(baseUrl, payload)
}

export const updateTime = async (payload: Time) => {
  await axios.$put(`${baseUrl}/${payload.id}`, payload)
}
