<script setup lang="ts">
import { type Meta } from '@/types/'
import { Button } from '@/components/shdn/ui/button'

import {
  Pagination,
  PaginationEllipsis,
  PaginationFirst,
  PaginationLast,
  PaginationList,
  PaginationListItem,
  PaginationNext,
  PaginationPrev
} from '@/components/shdn/ui/pagination'

export interface Props {
  meta: Meta
  currentPage: number
}

defineProps<Props>()

const emit = defineEmits(['updatePage'])
</script>

<template>
  <div
    v-if="meta && meta.total > 10"
    class="mx-auto mt-3"
  >
    <Pagination
      v-if="meta"
      v-slot="{ page }"
      :items-per-page="meta.per_page"
      :page="currentPage"
      :total="meta.total"
      :default-page="1"
      :sibling-count="1"
      show-edges
      @update:page="emit('updatePage', $event)"
    >
      <PaginationList
        v-slot="{ items }"
        class="flex items-center gap-0.5"
      >
        <PaginationFirst />
        <PaginationPrev />

        <template v-for="(item, index) in items">
          <PaginationListItem
            v-if="item.type === 'page'"
            :key="index"
            :value="item.value"
            as-child
          >
            <Button
              class="p-0 size-10 text-sm"
              :variant="item.value === page ? 'default' : 'outline'"
            >
              {{ item.value }}
            </Button>
          </PaginationListItem>
          <PaginationEllipsis
            v-else
            :key="item.type"
            :index="index"
          />
        </template>

        <PaginationNext />
        <PaginationLast />
      </PaginationList>
    </Pagination>
  </div>
</template>
