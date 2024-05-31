<script setup lang="ts">
import { computed, onMounted, ref, reactive, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { type Manufacturer } from '@/api/params/Manufacturer'
import { useManufacturerStore } from '@/stores/params/ManufacturerStore'

import { storeToRefs } from 'pinia'

const manufacturerStore = useManufacturerStore()
const { manufacturerEdit } = storeToRefs(manufacturerStore)

const form = reactive(manufacturerEdit)
const router = useRouter()
const route = useRoute()
const formRef = ref(null)

const id = computed(() => route.params.id)

const onClose = () => {
  router.push({ name: 'params-work-equipment-manufacturers' })
}

const onSubmit = async (values: Manufacturer) => {
  await manufacturerStore.save(values)
  onClose()
}

watch(id, (id) => {
  if (id) {
    manufacturerStore.findById(parseInt(id as string))
  } else {
    manufacturerStore.add()
  }
}, { immediate: true })

</script>

<template>
  <div>
    <twice-ui-dialog
      :show="true"
      title="Hersteeller hinzufügen"
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
            <div class="col-span-24">
              <twice-ui-input
                label="Bezeichnung"
                rules="required"
                name="name"
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
