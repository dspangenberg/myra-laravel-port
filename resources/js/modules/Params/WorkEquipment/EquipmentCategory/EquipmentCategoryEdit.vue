<script setup lang="ts">
import { computed, onMounted, ref, reactive, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { type EquipmentCategory } from '@/api/params/EquipmentCategory'
import { useEquipmentCategoryStore } from '@/stores/params/EquipmentCategoryStore'
import { storeToRefs } from 'pinia'

const equipmentCategoryStore = useEquipmentCategoryStore()
const { categoryEdit, parentCategories, groups } = storeToRefs(equipmentCategoryStore)

const form = reactive(categoryEdit)
const router = useRouter()
const route = useRoute()
const formRef = ref(null)

const id = computed(() => route.params.id)

const onClose = () => {
  router.push({ name: 'params-work-equipment-categories' })
}

const onSubmit = async (values: EquipmentCategory) => {
  console.log(values)
  await equipmentCategoryStore.save(values)
  onClose()
}

watch(id, (id) => {
  if (id) {
    equipmentCategoryStore.findById(parseInt(id as string))
  } else {
    equipmentCategoryStore.add()
  }
}, { immediate: true })

</script>

<template>
  <div>
    <twice-ui-dialog
      :show="true"
      title="Arbeitsmittelkategorie hinzufügen"
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
            <div class="col-span-12">
              <twice-ui-select
                label="Übergeordnete Kategorie"
                :options="parentCategories"
                name="parent_id"
              />
            </div>
            <div class="col-span-12">
              <twice-ui-check-box-list
                v-for="group in groups"
                :key="group.id"
                :label="group.name + ' (' + group.segment?.name + ')'"
                :true-value="group.id"
                name="inventory_groups"
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
