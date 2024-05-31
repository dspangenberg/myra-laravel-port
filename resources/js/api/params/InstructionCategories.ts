import { useAxios } from '@/composables/useAxios'
import { type Meta } from '@/types/'

const { axios } = useAxios(true)

export interface InstructionCategory {
  id: number | null
  name: string
  color: string
  description: string
  interval: number
  numberOfIntervals: number
  useParentInterval: number
}

export interface InstructionCategoryWithMeta {
  data: InstructionCategory[],
  meta: Meta
}

export interface ResponseWithMeta {
  categories: InstructionCategoryWithMeta
}

export interface Response {
  category: InstructionCategory
}

export const getAllInstructionCategories = async (page: number = 1): Promise<InstructionCategoryWithMeta> => {
  const { categories } = await axios.$get('/api/settings/instruction-categories', { page }) as ResponseWithMeta
  const { meta, data } = categories
  return { meta, data }
}

export const findInstractionCategoryById = async (id: number): Promise<Response> => {
  const { category } = await axios.$get(`/api/settings/instruction-categories/${id}`) as unknown as Response
  return { category }
}

export const saveInstractionCategory = async (payload: InstructionCategory) => {
  await axios.$post('/api/settings/instruction-categories', { category: payload })
}
