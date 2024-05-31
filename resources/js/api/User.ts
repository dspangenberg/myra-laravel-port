import { type Meta } from '@/types/'
import { useAxios } from '@/composables/useAxios'

const { axios } = useAxios(true)
const baseUrl: string = '/api/users'

export interface IAaul {
  token: string
}

export interface Country {
  name: string
}

export interface Profile {
  country: Country
  street: string
  zip: string,
  city: string
  phone: string
}

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

export interface UserWithDetails {
  user: User
}

export interface UsersWithMeta {
  data: User[],
  meta: Meta
}

export interface UsersResponse {
  users: UsersWithMeta
}

export const getAllUsers = async (page: number = 1): Promise<UsersWithMeta> => {
  const { users } = await axios.$get(baseUrl, { page }) as UsersResponse
  const { meta, data } = users
  return { meta, data }
}

export const findUserById = async (id: number): Promise<UserWithDetails> => {
  const { user } = await axios.$get(`${baseUrl}/${id}`) as unknown as UserWithDetails
  return { user }
}
export const createUser = async (payload: User) => {
  await axios.$post(baseUrl, payload)
}

export const updateUser = async (payload: User) => {
  await axios.$put(`${baseUrl}/${payload.id}`, payload)
}
