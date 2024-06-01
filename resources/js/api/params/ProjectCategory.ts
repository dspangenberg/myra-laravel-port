import { useAxios } from '@/composables/useAxios'
import { type Meta } from '@/types/'

const { axios } = useAxios(true)
const baseUrl: string = '/api/params/business-segments'

export interface ProjectCategory {
  id?: number | null
  name: string
  color: string
  icon: string
}

export interface ResponseWithMeta {
  data: ProjectCategory[],
  meta: Meta
}

export interface Response {
  segment: ProjectCategory
}

export const getAllBusinessSegments = async (page: number = 1): Promise<ResponseWithMeta> => {
  const { meta, data } = await axios.$get(baseUrl, { page }) as ResponseWithMeta
  return { meta, data }
}

export const findBusinessSegmentById = async (id: number): Promise<Response> => {
  const { segment } = await axios.$get(`${baseUrl}/${id}`) as unknown as Response
  return { segment }
}

export const createBusinessSegment = async (payload: ProjectCategory) => {
  await axios.$post(baseUrl, payload)
}

export const updateBusinessSegment = async (payload: ProjectCategory) => {
  await axios.$put(`${baseUrl}/${payload.id}`, payload)
}
