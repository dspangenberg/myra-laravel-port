<script lang="ts" setup>
import { type Manufacturer } from '@/api/params/Manufacturer'
import {
  TableCell,
  TableRow
} from '@/components/shdn/ui/table'

export interface Props {
  item: Manufacturer
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
