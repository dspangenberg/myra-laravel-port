import $axios from '@/utils/Axios'
import { useGlobalStore } from '@/stores/GlobalStore'

export function useAxios (useAuth: boolean = true) {
  $axios.setBaseURL(window.location.origin)

  if (useAuth) {
    const globalStore = useGlobalStore()
    const token = globalStore.getToken
    if (token) {
      $axios.setToken(token, 'Bearer')
    }
  }

  return { axios: $axios }
}
