import { type Meta } from '@/types/'
import { useAxios } from '@/composables/useAxios'

const { axios } = useAxios(true)
const baseUrl: string = '/api/users'

export interface User {
  id?: number
  email: string
  last_name: string
  first_name: string
  avatar_url: string
  created_at?: string
  full_name?: string
  initials?: string
  is_admin?: boolean
  reverse_full_name?: string
  password?: string,
  password_confirmation?: string
}

export interface ResponseWithMeta {
  data: User[],
  meta: Meta
}

export interface Response {
  data: User
}

export const getAllUsers = async (qs: string = ''): Promise<ResponseWithMeta> => {
  const { meta, data } = await axios.$get(`${baseUrl}/${qs}`) as ResponseWithMeta
  return { meta, data }
}

export const findUserById = async (id: number): Promise<Response> => {
  const { data } = await axios.$get(`${baseUrl}/${id}`) as unknown as Response
  return { data }
}
export const createUser = async (payload: User) => {
  await axios.$post(baseUrl, payload)
}

export const updateUser = async (payload: User) => {
  await axios.$put(`${baseUrl}/${payload.id}`, payload)
}
