import { defineStore, acceptHMRUpdate } from 'pinia'
import { getAllTimes, findTimeById, createTime, updateTime } from '@/api/Time'
import { reactive, ref, type Ref } from 'vue'
import type { Time, GroupedTimeEntries, TimeStats } from '@/api/Time'
import { type Meta } from '@/types/'

export const useTimeStore = defineStore('time-store', () => {
  const times: Ref<Time[] | null> = ref([])
  const groupedTimeEntries: Ref<GroupedTimeEntries | null> = ref(null)
  const time: Ref<Time | null> = ref(null)
  const timeEdit: Ref<Time | null> = ref(null)
  const meta: Ref<Meta | null> = ref(null)
  const isLoading: Ref<boolean> = ref(false)
  const timeStats: Ref<TimeStats | null> = ref(null)

  const store = useTimeStore()

  const newRecordTemplate = reactive({
    id: 0,
    project_id: 0,
    user_id: 0,
    time_category_id: 0,
    begin_at: '',
    minutes: 0,
    end_at: '',
    note: '',
    is_locked: false,
    mins: 0,
    is_billable: true,
    is_timer: false
  })

  const getAll = async (page: number = 1) => {
    isLoading.value = true
    const { data, meta, stats, groupedByDay } = await getAllTimes(page)

    store.$patch(state => {
      state.times = data
      state.groupedTimeEntries = groupedByDay
      state.meta = meta
      state.timeStats = stats
    })
    isLoading.value = false
  }

  const add = () => {
    store.$patch(state => {
      state.time = newRecordTemplate
      state.timeEdit = newRecordTemplate
    })
  }

  const findById = async (id: number) => {
    const { time: record } = await findTimeById(id)

    store.$patch(state => {
      state.time = record
      state.timeEdit = record
    })
  }

  const save = async (value: Time) => {
    if (!value.id) {
      await createTime(value)
    } else {
      await updateTime(value)
    }
    timeEdit.value = null
    await getAll()
  }

  return {
    groupedTimeEntries,
    isLoading,
    time,
    timeEdit,
    timeStats,
    times,
    meta,
    newRecordTemplate,
    add,
    getAll,
    findById,
    save
  }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useTimeStore, import.meta.hot))
}
