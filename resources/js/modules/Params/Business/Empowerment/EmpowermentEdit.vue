<script setup lang="ts">
import { computed, ref, reactive, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { type Filing } from '@/api/params/Filing'
import { useEmpowermentStore } from '@/stores/params/EmpowermentStore'
import { storeToRefs } from 'pinia'

const empowermentStore = useEmpowermentStore()
const { empowermentEdit } = storeToRefs(empowermentStore)

const form = reactive(empowermentEdit)
const router = useRouter()
const route = useRoute()
const formRef = ref(null)

const id = computed(() => route.params.id)

const onClose = () => {
  router.push({ name: 'params-business-empowerments' })
}

const onSubmit = async (values: Filing) => {
  await empowermentStore.save(values)
  onClose()
}

watch(id, (id) => {
  if (id) {
    empowermentStore.findById(parseInt(id as string))
  } else {
    empowermentStore.add()
  }
}, { immediate: true })

</script>

<template>
  <div>
    <twice-ui-dialog
      :show="true"
      title="Befähigung hinzufügen"
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
            <div class="col-span-20">
              <twice-ui-input
                label="Bezeichnung"
                rules="required"
                name="name"
              />
            </div>
            <div class="col-span-4">
              <twice-ui-input
                label="Kürzel"
                name="abbreviation"
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
