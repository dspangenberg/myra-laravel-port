import { camelCase } from 'moderndash'
import { type IKeyValueStore } from '@/types/'

export function Env (key: string | null = null) {
  if (key) {
    return import.meta.env[`VITE_APP_${key}`]
  }

  const get = (key: string) => {
    return import.meta.env[`VITE_APP_${key}`]
  }

  const isDev = () => {
    return import.meta.env.DEV === true
  }

  const assetUrl = (file: string) => {
    return new URL(file, import.meta.env.VITE_APP_ASSETS)
  }

  const mediaUrl = (file: string) => {
    return new URL(file, import.meta.env.VITE_APP_MEDIA_URL)
  }

  const keys = (keys: string[]) => {
    const params: IKeyValueStore = {}
    for (const key of keys) {
      const envKey: string = camelCase(key)
      params[envKey] = get(envKey)
    }
    return params
  }

  return { isDev, assetUrl, mediaUrl, get, keys }
}
