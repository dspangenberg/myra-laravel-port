import { useAxios } from '@/composables/useAxios'
import { type Meta } from '@/types/'

const { axios } = useAxios(true)

export interface OperatingInstruction {
  id: number | null
  number: string
  name: string
  description: string
}

export interface InstructionsWithMeta {
  data: OperatingInstruction[],
  meta: Meta
}

export interface ResponseWithMeta {
  instructions: InstructionsWithMeta
}

export interface Response {
  instruction: OperatingInstruction
}

export const getAll = async (page: number = 1): Promise<InstructionsWithMeta> => {
  const { instructions } = await axios.$get('/api/settings/operating-instructions', { page }) as ResponseWithMeta
  const { meta, data } = instructions
  return { meta, data }
}

export const findById = async (id: number): Promise<Response> => {
  const { instruction } = await axios.$get(`/api/settings/operating-instructions'/${id}`) as unknown as Response
  return { instruction }
}

export const save = async (payload: OperatingInstruction) => {
  await axios.$post('/api/settings/operating-instructions', { instruction: payload })
}
