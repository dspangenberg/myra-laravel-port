import { useAxios } from '@/composables/useAxios'
import { type Meta } from '@/types/'

const { axios } = useAxios(true)
const baseUrl: string = '/api/params/departments'

export interface Department {
  id?: number | null
  name: string
}

export interface ResponseWithMeta {
  data: Department[],
  meta: Meta
}

export interface Response {
  department: Department
}

export const getAllDepartments = async (page: number = 1): Promise<ResponseWithMeta> => {
  const { meta, data } = await axios.$get(baseUrl, { page }) as ResponseWithMeta
  return { meta, data }
}

export const findDepartmentById = async (id: number): Promise<Response> => {
  const { department } = await axios.$get(`${baseUrl}/${id}`) as unknown as Response
  return { department }
}

export const createDepartment = async (payload: Department) => {
  await axios.$post(baseUrl, payload)
}

export const updateDepartment = async (payload: Department) => {
  await axios.$put(`${baseUrl}/${payload.id}`, payload)
}
