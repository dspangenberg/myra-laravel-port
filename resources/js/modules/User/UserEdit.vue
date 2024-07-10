<script lang="ts" setup>
import { ref, reactive } from 'vue'
import { useRouter } from 'vue-router'
import { type User } from '@/api/User'
import { useUserStore } from '@/stores/UserStore'
import { storeToRefs } from 'pinia'

const userStore = useUserStore()
const { userEdit } = storeToRefs(userStore)

const form = reactive(userEdit)
const router = useRouter()
const formRef = ref(null)

const onClose = () => {
  router.push({ name: 'users-list' })
}

const onSubmit = async (values: User) => {
  await userStore.save(values)
  onClose()
}

</script>

<template>
  <div>
    <TwiceUiDialog
      :show="true"
      title="Benutzer*in hinzufügen"
      width="xs"
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
                label="Vorname"
                name="first_name"
                rules="required"
              />
            </div>
            <div class="col-span-12">
              <twice-ui-input
                label="Name"
                name="last_name"
                rules="required"
              />
            </div>
            <div class="col-span-24">
              <twice-ui-input
                label="E-Mail-Adresse"
                name="email"
                rules="required|email"
              />
            </div>
            <div class="col-span-12">
              <twice-ui-input
                label="Kennwort"
                name="password"
                rules="safe-password:14:score|confirmed:@password_confirmation"
              />
              <twice-ui-check-box
                :true-value="true"
                label="Administrator"
                name="is_admin"
              />
            </div>
            <div class="col-span-12">
              <twice-ui-input
                label="Wiederholung"
                name="password_confirmation"
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
    </TwiceUiDialog>
  </div>
</template>
