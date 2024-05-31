<script lang="ts" setup>
import { type InventoryGroup } from '@/api/params/InventoryGroup'
import {
  TableCell,
  TableRow
} from '@/components/shdn/ui/table'

export interface Props {
  item: InventoryGroup
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
    <TableCell>
      {{ item.inventory_number_prefix }}
    </TableCell>
    <TableCell class="text-right">
      {{ item.inventory_current_number }}
    </TableCell>
    <TableCell class="w-auto" />
  </TableRow>
</template>
