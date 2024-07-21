import { defineStore, acceptHMRUpdate } from 'pinia'
import {
  getAllBookings
} from '@/api/Booking'
import { ref, type Ref } from 'vue'
import type { Booking } from '@/api/Booking'
import type { Meta } from '@/types'

export const useBookingStore = defineStore('time-store', () => {
  const store = useBookingStore()

  const bookings: Ref<Booking[] | null> = ref([])
  const booking: Ref<Booking | null> = ref(null)
  const bookingEdit: Ref<Booking | null> = ref(null)
  const meta: Ref<Meta | null> = ref(null)
  const isLoading: Ref<boolean> = ref(false)

  const getAll = async (params?: string) => {
    isLoading.value = true
    const data = await getAllBookings(params)

    store.$patch(state => {
      state.bookings = data.data
      state.meta = data.meta
    })
    isLoading.value = false
  }

  return {
    bookings,
    meta,
    getAll
  }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useBookingStore, import.meta.hot))
}
