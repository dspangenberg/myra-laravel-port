<script lang="ts" setup>
import { type EquipmentCategory } from '@/api/params/EquipmentCategory'
import { useTemplateFilter } from '@/composables/useTemplateFilter'
import {
  TableCell,
  TableRow
} from '@/components/shdn/ui/table'

const { collectField } = useTemplateFilter()

export interface Props {
  item: EquipmentCategory
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
      {{ item.parent?.name }}
    </TableCell>
    <TableCell>
      <template v-if="item.inventory_groups.length">
        {{ collectField(item.inventory_groups, 'inventory_number_prefix') }}
      </template>
    </TableCell>
    <TableCell class="w-auto" />
  </TableRow>
</template>
