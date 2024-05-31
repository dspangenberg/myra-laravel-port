<script lang="ts" setup>
import { type StorageLocation } from '@/api/params/StorageLocation'
import {
  TableCell,
  TableRow
} from '@/components/shdn/ui/table'

export interface Props {
  item: StorageLocation
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
    <TableCell>
      {{ item.segment?.name }}
    </TableCell>
    <TableCell class="w-auto" />
  </TableRow>
</template>
