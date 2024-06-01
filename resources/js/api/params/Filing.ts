import { useAxios } from '@/composables/useAxios'
import { type Meta } from '@/types/'
import { type ProjectCategory } from '@/api/params/ProjectCategory'

const { axios } = useAxios(true)
const baseUrl: string = '/api/params/filings'

export interface Filing {
  id?: number | null
  name: string
  business_segment_id?: number
  segment?: ProjectCategory
}

export interface ResponseWithMeta {
  data: Filing[]
  segments: ProjectCategory[]
  meta: Meta
}

export interface Response {
  filing: Filing
}

export const getAllFilings = async (page: number = 1): Promise<ResponseWithMeta> => {
  const { data, meta, segments } = await axios.$get(baseUrl, { page }) as ResponseWithMeta
  return { meta, data, segments }
}

export const findFilingById = async (id: number): Promise<Response> => {
  const { filing } = await axios.$get(`${baseUrl}/${id}`) as unknown as Response
  return { filing }
}

export const createFiling = async (payload: Filing) => {
  await axios.$post(baseUrl, payload)
}

export const updateFiling = async (payload: Filing) => {
  await axios.$put(`${baseUrl}/${payload.id}`, payload)
}
