import { defineStore, acceptHMRUpdate } from 'pinia'
import { createOperationInstruction, getAllOperatingInstruction, updateOperationInstruction, findOperatingInstructionById } from '@/api/params/OperatingInstruction'
import { reactive, ref, type Ref } from 'vue'
import type { OperatingInstruction } from '@/api/params/OperatingInstruction'
import { type Meta } from '@/types/'

export const useOperatingInstructionStore = defineStore('settings-operating-instruction', () => {
  const instructions: Ref<OperatingInstruction[] | null> = ref([])
  const instruction: Ref<OperatingInstruction | null> = ref(null)
  const instructionEdit: Ref<OperatingInstruction | null> = ref(null)
  const meta: Ref<Meta | null> = ref(null)
  const isLoading: Ref<boolean> = ref(false)

  const store = useOperatingInstructionStore()

  const newRecordTemplate = reactive({
    id: null,
    number: '',
    name: '',
    description: ''
  })

  const getAll = async (page: number = 1) => {
    isLoading.value = true
    const { data, meta } = await getAllOperatingInstruction(page)
    store.$patch(state => {
      state.instructions = data
      state.meta = meta
    })
    isLoading.value = false
  }

  const add = () => {
    store.$patch(state => {
      state.instruction = newRecordTemplate
      state.instructionEdit = newRecordTemplate
    })
  }

  const findById = async (id: number) => {
    const { instruction: apiInstruction } = await findOperatingInstructionById(id)

    store.$patch(state => {
      console.log(apiInstruction)
      state.instruction = apiInstruction
      state.instructionEdit = apiInstruction
    })
  }

  const save = async (value: OperatingInstruction) => {
    if (!value.id) {
      await createOperationInstruction(value)
    } else {
      await updateOperationInstruction(value)
    }
    instructionEdit.value = null
    await getAll()
  }

  return {
    isLoading,
    instruction,
    instructionEdit,
    instructions,
    meta,
    newRecordTemplate,
    add,
    getAll,
    findById,
    save
  }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useOperatingInstructionStore, import.meta.hot))
}
