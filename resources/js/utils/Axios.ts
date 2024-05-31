import axios from 'axios'
import { axiosHelpers } from './AxiosHelper'
import { useRouter } from 'vue-router'
import { useGlobalStore } from '@/stores/GlobalStore'

const isNetworkError = (error: Error) => {
  if (!axios.isAxiosError(error)) {
    return false
  }
  return error.code === 'ERR_NETWORK'
}

const $axios = axiosHelpers(axios)

$axios.interceptors.response.use(
  res => res,
  error => {
    const status = error.response?.status
    if (isNetworkError(error)) {
      return error
    } else {
      if (status === 401) {
        const globalStore = useGlobalStore()
        globalStore.unauthorized()
      }
      if (status === 403) {
        const router = useRouter()
        router.push({ name: 'forbidden' })
      }
      throw error
    }
  }
)

export default $axios
