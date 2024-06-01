<script lang="ts" setup>
import { type ProjectCategory } from '@/api/params/ProjectCategory'
import {
  TableCell,
  TableRow
} from '@/components/shdn/ui/table'

export interface Props {
  item: ProjectCategory
}
defineEmits(['select'])
defineProps<Props>()

</script>
<template>
  <TableRow
    class="w-full cursor-pointer"
    @click="$emit('select', item.id)"
  >
    <TableCell class="font-medium">
      {{ item.name }}
    </TableCell>
    <TableCell class="w-auto" />
  </TableRow>
</template>
