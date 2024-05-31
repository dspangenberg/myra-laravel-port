<script setup lang="ts">
import { computed, onMounted, ref, reactive, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { type OperatingInstruction } from '@/api/params/OperatingInstruction'
import { useOperatingInstructionStore } from '@/stores/params/OperatingInstructionStore'
import { storeToRefs } from 'pinia'

const operatingInstructionStore = useOperatingInstructionStore()
const { instructionEdit } = storeToRefs(operatingInstructionStore)

const form = reactive(instructionEdit)
const router = useRouter()
const route = useRoute()
const formRef = ref(null)

const id = computed(() => route.params.id)

const onClose = () => {
  router.push({ name: 'params-instructions-operating-instructions' })
}

const onSubmit = async (values: OperatingInstruction) => {
  await operatingInstructionStore.save(values)
  onClose()
}

watch(id, (id) => {
  if (id) {
    operatingInstructionStore.findById(parseInt(id as string))
  } else {
    operatingInstructionStore.add()
  }
}, { immediate: true })

</script>

<template>
  <div>
    <twice-ui-dialog
      :show="true"
      title="Betriebsanweisung hinzufügen"
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
            <div class="col-span-4">
              <twice-ui-input
                label="Lfd. Nr."
                rules="required"
                name="number"
              />
            </div>
            <div class="col-span-20">
              <twice-ui-input
                label="Bezeichnung"
                rules="required"
                name="name"
              />
            </div>
            <div class="col-span-24">
              <twice-ui-input
                type="textarea"
                label="Beschreibung"
                name="description"
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
