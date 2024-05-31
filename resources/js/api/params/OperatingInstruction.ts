import { useAxios } from '@/composables/useAxios'
import { type Meta } from '@/types/'

const { axios } = useAxios(true)
const baseUrl: string = '/api/params/operating-instructions'

export interface OperatingInstruction {
  id: number | null
  number: string
  name: string
  description: string
}

export interface ResponseWithMeta {
  data: OperatingInstruction[],
  meta: Meta
}

export interface Response {
  instruction: OperatingInstruction
}

export const getAllOperatingInstruction = async (page: number = 1): Promise<ResponseWithMeta> => {
  const { meta, data } = await axios.$get(baseUrl, { page }) as ResponseWithMeta
  return { meta, data }
}

export const findOperatingInstructionById = async (id: number): Promise<Response> => {
  const { instruction } = await axios.$get(`${baseUrl}/${id}`) as unknown as Response
  return { instruction }
}

export const createOperationInstruction = async (payload: OperatingInstruction) => {
  await axios.$post(baseUrl, payload)
}

export const updateOperationInstruction = async (payload: OperatingInstruction) => {
  await axios.$put(`${baseUrl}/${payload.id}`, payload)
}
