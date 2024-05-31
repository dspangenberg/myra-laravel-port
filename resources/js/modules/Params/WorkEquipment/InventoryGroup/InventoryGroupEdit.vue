<script setup lang="ts">
import { computed, onMounted, ref, reactive, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { type InventoryGroup } from '@/api/params/InventoryGroup'
import { useInventoryGroupStore } from '@/stores/params/InventoryGroupStore'

import { storeToRefs } from 'pinia'

const inventoryGroupStore = useInventoryGroupStore()
const { groupEdit, segments } = storeToRefs(inventoryGroupStore)

const form = reactive(groupEdit)
const router = useRouter()
const route = useRoute()
const formRef = ref(null)

const id = computed(() => route.params.id)

const onClose = () => {
  router.push({ name: 'params-work-equipment-inventory-groups' })
}

const onSubmit = async (values: InventoryGroup) => {
  await inventoryGroupStore.save(values)
  onClose()
}

watch(id, (id) => {
  if (id) {
    inventoryGroupStore.findById(parseInt(id as string))
  } else {
    inventoryGroupStore.add()
  }
}, { immediate: true })

</script>

<template>
  <div>
    <twice-ui-dialog
      :show="true"
      title="Arbeitsmittelgruppe hinzufügen"
      @hide="onClose"
    >
      <template #content>
        <twice-ui-form
          id="form"
          ref="formRef"
          :initial-values="form"
          @submitted="onSubmit"
        >
          <twice-ui-form-group>
            <div class="col-span-12">
              <twice-ui-input
                label="Bezeichnung"
                rules="required"
                name="name"
              />
            </div>
            <div class="col-span-8">
              <twice-ui-select
                label="Geschäftsbereich"
                :options="segments"
                name="business_segment_id"
              />
            </div>
            <div class="col-span-4">
              <twice-ui-input
                label="Prefix"
                rules="required"
                name="inventory_number_prefix"
              />
            </div>
          </twice-ui-form-group>
        </twice-ui-form>
      </template>
      <template #footer>
        <ShdnUiButton
          variant="secondary"
          @click="onClose"
        >
          Abbrechen
        </ShdnUiButton>
        <ShdnUiButton
          form="form"
          type="submit"
        >
          Speichern
        </ShdnUiButton>
      </template>
    </twice-ui-dialog>
  </div>
</template>
