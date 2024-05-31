import { useAxios } from '@/composables/useAxios'
import { type Meta } from '@/types/'
import { type BusinessSegment } from '@/api/params/BusinessSegment'

const { axios } = useAxios(true)
const baseUrl: string = '/api/params/inventory-groups'

export interface InventoryGroup {
  id?: number | null
  name: string
  inventory_number_prefix?: string
  inventory_current_number?: number
  business_segment_id?: number
  segment?: BusinessSegment
}

export interface ResponseWithMeta {
  data: InventoryGroup[],
  meta: Meta
  segments: BusinessSegment[]
}

export interface Response {
  group: InventoryGroup
}

export const getAllInventoryGroups = async (page: number = 1): Promise<ResponseWithMeta> => {
  const { meta, data, segments } = await axios.$get(baseUrl, { page }) as ResponseWithMeta
  return { meta, data, segments }
}

export const findInventoryGroupById = async (id: number): Promise<Response> => {
  const { group } = await axios.$get(`${baseUrl}/${id}`) as unknown as Response
  return { group }
}

export const createInventoryGroup = async (payload: InventoryGroup) => {
  await axios.$post(baseUrl, payload)
}

export const updateInventoryGroup = async (payload: InventoryGroup) => {
  await axios.$put(`${baseUrl}/${payload.id}`, payload)
}
