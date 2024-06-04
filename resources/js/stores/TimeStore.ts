import { defineStore, acceptHMRUpdate } from 'pinia'
import {
  createTime,
  createProofOfActivityPdf,
  editTime,
  getAllTimes,
  findTimeById,
  storeTime,
  updateTime
} from '@/api/Time'
import { ref, type Ref } from 'vue'
import type { Time, GroupedTimeEntries, TimeStats, QueryParams } from '@/api/Time'
import type { Project } from '@/api/Project'
import type { User } from '@/api/User'
import type { TimeCategory } from '@/api/params/TimeCategory'
import type { Meta } from '@/types'

export const useTimeStore = defineStore('time-store', () => {
  const store = useTimeStore()

  const times: Ref<Time[] | null> = ref([])
  const groupedTimeEntries: Ref<GroupedTimeEntries | null> = ref(null)
  const time: Ref<Time | null> = ref(null)
  const timeEdit: Ref<Time | null> = ref(null)
  const meta: Ref<Meta | null> = ref(null)
  const isLoading: Ref<boolean> = ref(false)
  const timeStats: Ref<TimeStats | null> = ref(null)
  const projects: Ref<Project[] | null> = ref([])
  const categories: Ref<TimeCategory[] | null> = ref([])
  const users: Ref<User[] | null> = ref([])

  const getAll = async (params?: QueryParams) => {
    isLoading.value = true
    const { data, meta, stats, groupedByDay } = await getAllTimes(params)

    store.$patch(state => {
      state.times = data
      state.groupedTimeEntries = groupedByDay
      state.meta = meta
      state.timeStats = stats
    })
    isLoading.value = false
  }

  const createPdf = async (params?: QueryParams) => {
    const content = await createProofOfActivityPdf(params)
    return content
  }
  const createOrEdit = async (id: number = 0) => {
    const { data, projects: apiProjects, categories: apiCategories, users: apiUsers } = id === 0 ? await createTime() : await editTime(id)

    store.$patch(state => {
      state.categories = apiCategories
      state.projects = apiProjects
      state.users = apiUsers

      state.timeEdit = data
    })
  }

  const findById = async (id: number) => {
    const { data } = await findTimeById(id)

    store.$patch(state => {
      state.time = data
      state.timeEdit = data
    })
  }

  const save = async (value: Time) => {
    if (!value.id) {
      await storeTime(value)
    } else {
      await updateTime(value)
    }
    timeEdit.value = null
    await getAll()
  }

  return {
    categories,
    projects,
    users,
    groupedTimeEntries,
    isLoading,
    time,
    timeEdit,
    timeStats,
    times,
    meta,
    createOrEdit,
    createPdf,
    getAll,
    findById,
    save
  }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useTimeStore, import.meta.hot))
}
