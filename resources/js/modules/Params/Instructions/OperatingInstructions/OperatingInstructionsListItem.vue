<script lang="ts" setup>
import { type OperatingInstruction } from '@/api/params/OperatingInstruction'
import {
  TableCell,
  TableRow
} from '@/components/shdn/ui/table'

export interface Props {
  item: OperatingInstruction
}
defineEmits(['select'])
defineProps<Props>()

</script>
<template>
  <TableRow
    class="w-full cursor-pointer"
    @click="$emit('select', item.id)"
  >
    <TableCell class="text-right">
      {{ item.number }}
    </TableCell>
    <TableCell class="font-medium">
      {{ item.name }}
    </TableCell>
    <TableCell class="w-auto" />
  </TableRow>
</template>
