<script setup lang="ts">
import { computed, ref, reactive, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { type StorageLocation } from '@/api/params/StorageLocation'
import { useStorageLocationStore } from '@/stores/params/StorageLocationStore'
import { storeToRefs } from 'pinia'

const storageLocationStore = useStorageLocationStore()
const { locationEdit, segments } = storeToRefs(storageLocationStore)

const form = reactive(locationEdit)
const router = useRouter()
const route = useRoute()
const formRef = ref(null)

const id = computed(() => route.params.id)

const onClose = () => {
  router.push({ name: 'params-business-storage-locations' })
}

const onSubmit = async (values: StorageLocation) => {
  await storageLocationStore.save(values)
  onClose()
}

watch(id, (id) => {
  if (id) {
    storageLocationStore.findById(parseInt(id as string))
  } else {
    storageLocationStore.add()
  }
}, { immediate: true })

</script>

<template>
  <div>
    <twice-ui-dialog
      :show="true"
      title="Lagerorte + Räume hinzufügen"
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
            <div class="col-span-12">
              <twice-ui-select
                label="Geschäftsbereich"
                :options="segments"
                name="business_segment_id"
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
