import { defineStore, acceptHMRUpdate } from 'pinia'
import { signIn as apiSignIn, signOut as apiSignOut } from '@/api/Auth'
import { ref, computed } from 'vue'
import { type Setting } from '@/types/'
import { useEmitter } from '@nguyenshort/vue3-mitt'

import type { User } from '@/api/User'

export const useGlobalStore = defineStore('global-store', () => {
  const token = ref<string>('')
  const user = ref<User | null>(null)
  const settings = ref<Setting[] | null>([])

  const emitter = useEmitter()

  const isAuthenticated = computed(() => {
    const authToken = token.value || localStorage.getItem('token') || null
    if (authToken) {
      return true
    }
    return false
  })

  const getToken = computed(() => {
    return localStorage.getItem('token') || ''
  })

  const getSetting = (key: string): string | number | null => {
    const gSettings = getSettings.value || []
    if (gSettings) {
      const fSettings = gSettings as Setting[]
      const setting: Setting | undefined = fSettings.find(s => s.key === key)
      if (setting) {
        switch (setting.type) {
          case 'number':
            return parseInt(setting.value)
          default:
            return setting.value
        }
      }
    }
    return null
  }

  const getSettings = computed(() => {
    const json = localStorage.getItem('settings')
    if (json) {
      return JSON.parse(json)
    }
    return null
  })

  const getUser = computed(() => {
    const json = localStorage.getItem('user')
    if (json) {
      return JSON.parse(json)
    }
    return null
  })

  const unauthorized = () => {
    emitter.emit('unauthorized')
  }

  const signIn = async (email: string, password: string) => {
    const { user: apiUser, token: apiToken } = await apiSignIn(email, password)

    token.value = apiToken
    user.value = apiUser
    localStorage.setItem('token', token.value)
    localStorage.setItem('user', JSON.stringify(user.value))
  }

  const signOut = async () => {
    try {
      await apiSignOut()
    } catch (error) {
    }

    localStorage.removeItem('token')
    localStorage.removeItem('user')
  }

  return {
    isAuthenticated,
    token,
    getSetting,
    getSettings,
    user,
    getToken,
    getUser,
    settings,
    unauthorized,
    signIn,
    signOut
  }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useGlobalStore, import.meta.hot))
}
