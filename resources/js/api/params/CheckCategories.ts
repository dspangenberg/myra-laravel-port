import { useAxios } from '@/composables/useAxios'
import { type Meta } from '@/types/'

const { axios } = useAxios(true)

export interface CheckRootCategory {
  id: number | null
  name: string
  icon: string
  textColor: string
  interval: number
  bgColor: string
  description: string
}

export interface CheckCategory extends CheckRootCategory {
  parent_id: number
  parent?: CheckRootCategory
}

export interface CheckCategoryWithMeta {
  categories: CheckCategory[],
  meta: Meta
}

export interface CategoryDetails {
  category: CheckCategory
}

export const getAll = async (): Promise<CheckCategoryWithMeta> => {
  const { categories, meta } = await axios.$get('') as unknown as CheckCategoryWithMeta
  return { categories, meta }
}

export const findById = async (id: number): Promise<CategoryDetails> => {
  const { category } = await axios.$get(`/${id}`) as unknown as CategoryDetails
  return { category }
}

export const save = async (payload: CheckCategory) => {
  await axios.$post('', { payload })
}
