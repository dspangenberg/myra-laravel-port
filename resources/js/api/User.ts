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

export interface UsersWithMeta {
  data: User[],
  meta: Meta
}

export interface UsersResponse {
  user: User
}

export const getAllUsers = async (page: number = 1): Promise<UsersWithMeta> => {
  const { meta, data } = await axios.$get(baseUrl, { page }) as UsersWithMeta
  return { meta, data }
}

export const findUserById = async (id: number): Promise<UsersResponse> => {
  const { user } = await axios.$get(`${baseUrl}/${id}`) as unknown as UsersResponse
  return { user }
}
export const createUser = async (payload: User) => {
  await axios.$post(baseUrl, payload)
}

export const updateUser = async (payload: User) => {
  await axios.$put(`${baseUrl}/${payload.id}`, payload)
}
