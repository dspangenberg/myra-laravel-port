<script lang="ts" setup>
import { computed, onMounted, reactive, ref } from 'vue'
import { type InstructionCategory } from '@/api/params/InstructionCategories'
import { useInstructionCategoryStore } from '@/stores/params/InstructionCategoryStore'
import { storeToRefs } from 'pinia'
import { useRouter } from 'vue-router'

const router = useRouter()

const instructionCategoryStore = useInstructionCategoryStore()
const { categoryEdit, newRecordTemplate, parentInterval } = storeToRefs(instructionCategoryStore)

const form = reactive(newRecordTemplate)
const formRef = ref()
const errors = computed(() => formRef.value?.errors || null)

console.log(parentInterval.value?.interval)
console.log(parentInterval.value?.numberOfIntervals)
const parentIntervalLabel = computed(() => 'Übergeordneten Intervall verwenden')

const onCancel = () => {
  router.push({
    name: 'settings-instructions-safety-categories'
  })
}

const onSubmit = (values: InstructionCategory) => {
  instructionCategoryStore.save(values)
  onCancel()
}

onMounted(() => {
  formRef.value.setValues(categoryEdit.value)
})

</script>

<template>
  <twice-ui-form-section
    headline="Unterweisungskategorie bearbeiten"
    :errors="errors"
    @submitted="onSubmit"
  >
    <template #form>
      <twice-ui-form
        id="form"
        ref="formRef"
        :initial-values="form"
        @submitted="onSubmit"
      >
        <twice-ui-form-group>
          <div class="col-span-12">
            <twice-ui-input
              name="name"
              label="Bezeichnung"
              rules="required"
            />
            <div>
              <twice-ui-check-box
                name="useParentInterval"
                :label="parentIntervalLabel"
              />
            </div>
          </div>
          <div class="col-span-3">
            <twice-ui-color-picker
              name="color"
              label="Farbe"
            />
          </div>
        </twice-ui-form-group>
        <twice-ui-form-group>
          <div class="col-span-15">
            <twice-ui-input
              type="textarea"
              name="description"
              label="Beschreibung"
            />
          </div>
        </twice-ui-form-group>
      </twice-ui-form>
    </template>
    <template #actions>
      <twice-ui-button
        variant="link"
        @click="onCancel"
      >
        Abbrechen
      </twice-ui-button>
      <twice-ui-button
        variant="primary"
        form="form"
        type="submit"
      >
        Speichern
      </twice-ui-button>
    </template>
  </twice-ui-form-section>
</template>
