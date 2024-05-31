/* eslint-disable camelcase */
import { useAxios } from '@/composables/useAxios'
import { type Meta } from '@/types/'
import type { InventoryGroup } from '@/api/params/InventoryGroup'

const { axios } = useAxios(true)
const baseUrl: string = '/api/params/equipment-categories'

export interface EquipmentCategory {
  id?: number | null
  name: string
  inventory_groups: number[] | InventoryGroup[]
  parent?: EquipmentCategory
}

export interface ResponseWithMeta {
  data: EquipmentCategory[],
  parent_categories: EquipmentCategory[]
  groups: InventoryGroup[]
  meta: Meta
}

export interface Response {
  data: EquipmentCategory
}

export const getAllEquipmentCategories = async (page: number = 1): Promise<ResponseWithMeta> => {
  const { data, meta, parent_categories, groups } = await axios.$get(baseUrl, { page }) as ResponseWithMeta
  return { meta, data, parent_categories, groups }
}

export const findEquipmentCategoryById = async (id: number): Promise<Response> => {
  const { data } = await axios.$get(`${baseUrl}/${id}`) as unknown as Response
  return { data }
}

export const createEquipmentCategory = async (payload: EquipmentCategory) => {
  await axios.$post(baseUrl, payload)
}

export const updateEquipmentCategory = async (payload: EquipmentCategory) => {
  await axios.$put(`${baseUrl}/${payload.id}`, payload)
}
