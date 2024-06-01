<script lang="ts" setup>
import type { Project } from '@/api/Project'
import {
  TableCell,
  TableRow
} from '@/components/shdn/ui/table'

export interface Props {
  item: Project
}

defineProps<Props>()
defineEmits(['select'])

</script>
<template>
  <TableRow @click="$emit('select', item.id)">
    <TableCell class="w-[36rem] max-w-[36rem]">
      <p class="truncate font-medium">
        {{ item.name }}
      </p>
      <p class="truncate pt-1 text-gray-600">
        {{ item?.owner?.full_name }}
      </p>
    </TableCell>
    <TableCell class="text-sm">
      {{ item?.category?.name }}
    </TableCell>
  </TableRow>
</template>
