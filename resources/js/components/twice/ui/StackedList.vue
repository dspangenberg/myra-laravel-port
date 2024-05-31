<script setup lang="ts">
const emit = defineEmits(['select'])

const select = (id: string) => {
  emit('select', id)
}

interface IKeyValueStore {
  [key: string]: string
}

export interface Props {
  itemsCount?: number
  items: any
  itemName?: string
  blankStateText?: string
  template: any
  loading?: boolean
  skeleton?: boolean,
  spinner?: boolean,
  page?: number,
  selectedItems?: string[],
  rounded?: string
  params?: IKeyValueStore | undefined
}

withDefaults(defineProps<Props>(), {
  itemName: 'Datensätze',
  blankStateText: 'Keine Datensätze gefunden',
  loading: false,
  skeleton: false,
  spinner: false,
  itemsCount: 0,
  page: 1,
  rounded: 'md',
  selectedItems: () => [],
  params: undefined
})

</script>

<template>
  <div class="flex items-center flex-1 select-none">
    <div
      class="flex flex-col flex-1 mb-6"
    >
      <div>
        Pagination
      </div>
      <twice-ui-shadow-box
        class="flex-1 max-h-fit "
        :rounded="rounded"
      >
        <slot>
          <ul
            role="list"
            class="divide-y divide-gray-200 bg-white "
          >
            <template v-if="!items || !items.length">
              <div class="flex items-center px-4 py-4 sm:px-6 text-base text-medium text-gray-500 text-center">
                <div class="mx-auto">
                  <slot name="blank">
                    {{ blankStateText }}
                  </slot>
                </div>
              </div>
            </template>
            <template v-else>
              <component
                :is="template"
                v-for="item in items"
                :key="item.id"
                :item="item"
                :skeleton="loading && skeleton"
                :params="params"
                @select="select"
              />
            </template>
            <slot />
          </ul>
        </slot>
      </twice-ui-shadow-box>
      <div>
        paginatiob
      </div>
    </div>
  </div>
</template>
