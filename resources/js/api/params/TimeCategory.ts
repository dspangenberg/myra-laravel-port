import { useAxios } from '@/composables/useAxios'
import { type Meta } from '@/types/'

const { axios } = useAxios(true)
const baseUrl: string = '/api/params/time-categories'

export interface TimeCategory {
  id?: number | null
  name: string
  short_name: string
  pos: number
  is_default: boolean
  hourly: number
}

export interface ResponseWithMeta {
  data: TimeCategory[],
  meta: Meta
}

export interface Response {
  department: TimeCategory
}

export const getAllDepartments = async (page: number = 1): Promise<ResponseWithMeta> => {
  const { meta, data } = await axios.$get(baseUrl, { page }) as ResponseWithMeta
  return { meta, data }
}

export const findDepartmentById = async (id: number): Promise<Response> => {
  const { department } = await axios.$get(`${baseUrl}/${id}`) as unknown as Response
  return { department }
}

export const createDepartment = async (payload: TimeCategory) => {
  await axios.$post(baseUrl, payload)
}

export const updateDepartment = async (payload: TimeCategory) => {
  await axios.$put(`${baseUrl}/${payload.id}`, payload)
}
