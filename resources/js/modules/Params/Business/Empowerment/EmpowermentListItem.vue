<script lang="ts" setup>
import { type Empowerment } from '@/api/params/Empowerment'
import {
  TableCell,
  TableRow
} from '@/components/shdn/ui/table'

export interface Props {
  item: Empowerment
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
      {{ item.abbreviation }}
    </TableCell>
    <TableCell class="w-auto" />
  </TableRow>
</template>
