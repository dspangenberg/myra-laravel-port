import { useAxios } from '@/composables/useAxios'
import type { User } from '@/api/User'
import { type Setting } from '@/types/'

const { axios } = useAxios(false)

interface Credentials {
  token: string,
  user: User,
  settings: Setting[]
}

export interface AdonisError {
  message: string
}

export interface ErrorResponse {
  errors: AdonisError[]
}

export const signIn = async (email: string, password: string): Promise<Credentials> => {
  try {
    const response = await axios.$post('/api/auth/login', { email, password })
    console.log(response)
    return response as unknown as Credentials
  } catch (error) {
    const errors = error as ErrorResponse
    return Promise.reject(errors)
  }
}

export const signOut = async () => {
  await axios.$post('/api/auth/login')
}
