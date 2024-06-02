import { type Meta } from '@/types/'
import { useAxios } from '@/composables/useAxios'
import { type ProjectCategory } from '@/api/params/ProjectCategory'
import { type Contact } from '@/api/Contact'
import { type User } from '@/api/User'

const { axios } = useAxios(true)
const baseUrl: string = '/api/projects'

export interface Project {
  id?: number
  name: string
  lead_user_id: number
  lead?: User
  owner?: Contact
  manager_contact_id: number
  owner_contact_id: number
  invoice_contact_id: number
  category?: ProjectCategory
  parent_project_id: number
  project_category_id: number
  is_archived: boolean
  begin_on: string
  end_on: string
  website: string
  note: string
  hourly: number
  budget_hours: number
  budget_costs: number
  budget_period: string
}

export interface ResponseWithMeta {
  data: Project[],
  meta: Meta
}

export interface Response {
  data: Project
}

export const getAllProjects = async (page: number = 1): Promise<ResponseWithMeta> => {
  const { meta, data } = await axios.$get(baseUrl, { page }) as ResponseWithMeta
  return { meta, data }
}

export const findProjectById = async (id: number): Promise<Response> => {
  const { data } = await axios.$get(`${baseUrl}/${id}`) as unknown as Response
  return { data }
}
export const createProject = async (payload: Project) => {
  await axios.$post(baseUrl, payload)
}

export const updateProject = async (payload: Project) => {
  await axios.$put(`${baseUrl}/${payload.id}`, payload)
}
