import { defineStore, acceptHMRUpdate } from 'pinia'
import { getAllBusinessSegments, findBusinessSegmentById, createBusinessSegment, updateBusinessSegment } from '@/api/params/ProjectCategory'
import { reactive, ref, type Ref } from 'vue'
import type { ProjectCategory } from '@/api/params/ProjectCategory'
import { type Meta } from '@/types/'

export const useBusinessSegmentStore = defineStore('params-business-segment-store', () => {
  const segments: Ref<ProjectCategory[] | null> = ref([])
  const segment: Ref<ProjectCategory | null> = ref(null)
  const segmentEdit: Ref<ProjectCategory | null> = ref(null)
  const meta: Ref<Meta | null> = ref(null)
  const isLoading: Ref<boolean> = ref(false)

  const store = useBusinessSegmentStore()

  const newRecordTemplate = reactive({
    name: ''
  })

  const getAll = async (page: number = 1) => {
    isLoading.value = true
    const { data, meta } = await getAllBusinessSegments(page)
    store.$patch(state => {
      state.segments = data
      state.meta = meta
    })
    isLoading.value = false
  }

  const add = () => {
    store.$patch(state => {
      state.segment = newRecordTemplate
      state.segmentEdit = newRecordTemplate
    })
  }

  const findById = async (id: number) => {
    const { segment: record } = await findBusinessSegmentById(id)

    store.$patch(state => {
      state.segment = record
      state.segmentEdit = record
    })
  }

  const save = async (value: ProjectCategory) => {
    if (!value.id) {
      await createBusinessSegment(value)
    } else {
      await updateBusinessSegment(value)
    }
    segmentEdit.value = null
    await getAll()
  }

  return {
    isLoading,
    segment,
    segmentEdit,
    segments,
    meta,
    newRecordTemplate,
    add,
    getAll,
    findById,
    save
  }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useBusinessSegmentStore, import.meta.hot))
}
