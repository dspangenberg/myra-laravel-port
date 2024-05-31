<script setup lang="ts">
import { computed, ref, reactive, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { type Filing } from '@/api/params/Filing'
import { useBusinessSegmentStore } from '@/stores/params/BusinessSegmentStore'
import { storeToRefs } from 'pinia'

const businessSegmentStore = useBusinessSegmentStore()
const { segmentEdit } = storeToRefs(businessSegmentStore)

const form = reactive(segmentEdit)
const router = useRouter()
const route = useRoute()
const formRef = ref(null)

const id = computed(() => route.params.id)

const onClose = () => {
  router.push({ name: 'params-business-segments' })
}

const onSubmit = async (values: Filing) => {
  await businessSegmentStore.save(values)
  onClose()
}

watch(id, (id) => {
  if (id) {
    businessSegmentStore.findById(parseInt(id as string))
  } else {
    businessSegmentStore.add()
  }
}, { immediate: true })

</script>

<template>
  <div>
    <twice-ui-dialog
      :show="true"
      title="Abteilung hinzufügen"
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
