import { query } from '@vortechron/query-builder-ts'
import { useRoute } from 'vue-router'
import { computed } from 'vue'
import { IKeyValueStore } from '@/types'

export function useLaravelQuery (keysToIgnore: string[], otherParams: IKeyValueStore | null = null) {
  const route = useRoute()
  keysToIgnore.push('page')

  const queryString = computed<string>(() => {
    const qs = route.query
    if (qs === null || qs.keys?.length === 0) {
      return ''
    }

    const page: number = parseInt(qs?.page as string) || 1

    const theQuery = query()
      .param('type', route.params?.type as string || 'list')
      .page(page)

    if (otherParams !== null) {
      Object.entries(otherParams).forEach(([key, value]) => {
        if (qs[key] !== undefined) {
          theQuery.param(key, value.toString() || value)
        }
      })
    }

    if (qs.entries !== null) {
      Object.entries(qs).forEach(([key, value]) => {
        if (key && value && !keysToIgnore.includes(key)) {
          theQuery.filter(key, value.toString())
        }
      })
    }
    return theQuery.build() || ''
  })

  return {
    queryString
  }
}
