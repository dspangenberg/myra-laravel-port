import { defineStore, acceptHMRUpdate } from 'pinia'
import {
  createOrEditTime,
  createProofOfActivityPdf,
  getAllTimes,
  findTimeById,
  storeTime,
  updateTime
} from '@/api/Time'
import { ref, type Ref } from 'vue'
import type { Time, GroupedByProject, GroupedByDate, TimeStats } from '@/api/Time'
import type { Project } from '@/api/Project'
import type { User } from '@/api/User'
import type { TimeCategory } from '@/api/params/TimeCategory'
import type { Meta } from '@/types'

export const useTimeStore = defineStore('time-store', () => {
  const store = useTimeStore()

  const times: Ref<Time[] | null> = ref([])
  const timesByDate: Ref<GroupedByDate | null> = ref(null)
  const timesByProject: Ref<GroupedByProject | null> = ref(null)
  const time: Ref<Time | null> = ref(null)
  const timeEdit: Ref<Time | null> = ref(null)
  const meta: Ref<Meta | null> = ref(null)
  const isLoading: Ref<boolean> = ref(false)
  const timeStats: Ref<TimeStats | null> = ref(null)
  const projects: Ref<Project[] | null> = ref([])
  const categories: Ref<TimeCategory[] | null> = ref([])
  const users: Ref<User[] | null> = ref([])

  const getAll = async (params?: string) => {
    isLoading.value = true
    const data = await getAllTimes(params)

    store.$patch(state => {
      state.times = data.data
      state.timesByDate = data.groupedByDate
      state.timesByProject = data.groupedByProject
      state.meta = data.meta
      state.timeStats = data.stats
    })
    isLoading.value = false
  }

  const createPdf = async (qs: string) => {
    return await createProofOfActivityPdf(qs)
  }
  const createOrEdit = async (id?: number) => {
    const data = await createOrEditTime(id)
    store.$patch(state => {
      state.categories = data.categories
      state.projects = data.projects
      state.users = data.users
      state.timeEdit = data.data
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
    timesByDate,
    timesByProject,
    timeStats,
    times,
    isLoading,
    time,
    timeEdit,
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
