import { defineStore, acceptHMRUpdate } from 'pinia'
import { getAllInstructionCategories, findInstractionCategoryById, saveInstractionCategory } from '@/api/params/InstructionCategories'
import { reactive, ref, type Ref } from 'vue'
import type { InstructionCategory } from '@/api/params/InstructionCategories'
import { type Meta, type parentInterval } from '@/types/'
import { useGlobalStore } from '../GlobalStore'

export const useInstructionCategoryStore = defineStore('settings-instruction-category', () => {
  const categories: Ref<InstructionCategory[] | null> = ref([])
  const category: Ref<InstructionCategory | null> = ref(null)
  const categoryEdit: Ref<InstructionCategory | null> = ref(null)
  const meta: Ref<Meta | null> = ref(null)
  const isLoading: Ref<boolean> = ref(false)
  const parentInterval: Ref<parentInterval | null> = ref({ interval: 0, numberOfIntervals: 0 })

  const store = useInstructionCategoryStore()
  const globalStore = useGlobalStore()

  const newRecordTemplate = reactive({
    id: null,
    color: '',
    interval: 365,
    numberOfIntervals: 0,
    name: '',
    useParentInterval: 1,
    description: ''
  })

  parentInterval.value = {
    interval: globalStore.getSetting('safety_instructions_default_interval') as number || 0,
    numberOfIntervals: globalStore.getSetting('safety_instructions_default_number_of_intervals') as number || 0
  }

  console.log(parentInterval.value)

  const getAll = async (page: number = 1) => {
    isLoading.value = true
    const { data, meta } = await getAllInstructionCategories(page)
    store.$patch(state => {
      state.categories = data
      state.meta = meta
    })
    isLoading.value = false
  }

  const add = () => {
    categoryEdit.value = newRecordTemplate
  }

  const findById = async (id: number) => {
    const { category: apiCategory } = await findInstractionCategoryById(id)

    store.$patch(state => {
      state.category = apiCategory
      state.categoryEdit = apiCategory
    })
  }

  const save = async (value: InstructionCategory) => {
    await saveInstractionCategory(value)
  }

  return {
    isLoading,
    category,
    categoryEdit,
    categories,
    meta,
    newRecordTemplate,
    parentInterval,
    add,
    getAll,
    findById,
    save
  }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useInstructionCategoryStore, import.meta.hot))
}
