<script setup lang="ts">
import { IconDatabaseSmile } from '@tabler/icons-vue'
import { useParamsLayoutStore } from '@/stores/ParamsLayoutStore'
import { computed, ref, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { type Meta } from '@/types/'

const route = useRoute()
const router = useRouter()
const paramsItem = ref()
const paramsSubItem = ref()
const paramsLayoutStore = useParamsLayoutStore()

export interface Props {
  recordCount?: number
  recordName?: string
  useLayout?: boolean
  loading?: boolean
  meta?: Meta | null
}

const props = withDefaults(defineProps<Props>(), {
  loading: false,
  recordCount: 0,
  recordName: 'Datensätze',
  meta: null,
  useLayout: false
})

const emit = defineEmits(['updatePage'])

const updatePage = (page: number) => {
  emit('updatePage', page)
}

const metaRecordCount = computed(() => {
  return props.meta?.total || props.recordCount || 0
})

const dynamicRecordName = computed(() => {
  const recordName = props.useLayout ? paramsSubItem.value.recordName : props.recordName
  if (recordName.includes('|')) {
    const recordNames = recordName.split('|')
    const [plural, singular] = recordNames
    return metaRecordCount.value === 1 ? singular : plural
  }
  return recordName
})

watch(route, (route) => {
  if (props.useLayout) {
    const { item, subItem } = paramsLayoutStore.getActiveItem(route.path)
    paramsItem.value = item
    paramsSubItem.value = subItem
  }
}, { immediate: true })

const onAddFirstClicked = () => {
  router.push({ name: paramsSubItem.value.addButtonRoute })
}

</script>
<template>
  <div>
    <div>
      <template v-if="loading">
        <div
          class="py-24 text-center"
        >
          <twice-ui-spinner />
        </div>
      </template>
      <template v-else>
        <div>
          <slot />
        </div>
        <div
          v-if="meta?.total"
          class="pt-3 px-2.5 text-sm flex items-stretch text-stone-700"
        >
          <div class="flex-1">
            <span class="font-medium">{{ meta?.from }}</span> bis <span class="font-medium">{{ meta?.to }}</span> von <span class="font-medium">{{ metaRecordCount }}</span> {{ dynamicRecordName }}
          </div>
        </div>
        <div class="mx-auto items-center flex mt-6">
          <twice-ui-pagination
            v-if="meta"
            :meta="meta"
            :current-page="meta?.current_page || 1"
            @update-page="updatePage"
          />
        </div>
      </template>
    </div>
    <div v-if="!metaRecordCount">
      <div>
        <slot name="empty-state">
          <div class="py-12 text-center text-gray-500">
            <IconDatabaseSmile
              :size="36"
              :stroke-width="1.5"
              class="mx-auto my-6 text-stone-500"
            />
            <template v-if="useLayout">
              Sie haben noch keine {{ dynamicRecordName }} hinzufügt.
              <div class="p-6">
                <ShdnUiButton @click="onAddFirstClicked">
                  {{ paramsSubItem.firstButtonTitle }} hinzufügen
                </ShdnUiButton>
              </div>
            </template>
            <template v-else>
              Keine {{ dynamicRecordName }} gefunden.
            </template>
          </div>
        </slot>
      </div>
    </div>
  </div>
</template>
