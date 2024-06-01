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
  time_category?: TimeCategory
  begin_at: string
  end_at: string
  note: string
  is_locked: boolean
  is_billable: boolean
  is_timer: boolean
}

export interface ResponseWithMeta {
  data: Time[],
  meta: Meta
}

export interface Response {
  time: Time
}

export const getAllTimes = async (page: number = 1): Promise<ResponseWithMeta> => {
  const { meta, data } = await axios.$get(baseUrl, { page }) as ResponseWithMeta
  return { meta, data }
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
