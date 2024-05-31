<script setup lang="ts">
import { computed, ref, reactive, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { type Filing } from '@/api/params/Filing'
import { useDepartmentStore } from '@/stores/params/DepartmentStore'
import { storeToRefs } from 'pinia'

const departmentStore = useDepartmentStore()
const { departmentEdit } = storeToRefs(departmentStore)

const form = reactive(departmentEdit)
const router = useRouter()
const route = useRoute()
const formRef = ref(null)

const id = computed(() => route.params.id)

const onClose = () => {
  router.push({ name: 'params-business-departments' })
}

const onSubmit = async (values: Filing) => {
  await departmentStore.save(values)
  onClose()
}

watch(id, (id) => {
  if (id) {
    departmentStore.findById(parseInt(id as string))
  } else {
    departmentStore.add()
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
