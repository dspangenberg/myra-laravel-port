<script setup lang="ts">
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import { useGlobalStore } from '@/stores/GlobalStore'
import { type ErrorResponse } from '@/api/Auth'
import pjson from '../../../package.json'

const version = pjson.version
const globalStore = useGlobalStore()

const router = useRouter()
const formRef = ref()
const error = ref('')
const isSaving = ref(false)

const form = reactive({
  email: '',
  password: ''
})

const onSubmit = async (values: { email: string; password: string }) => {
  try {
    isSaving.value = false
    await globalStore.signIn(values.email, values.password)
    isSaving.value = false
    router.push({ name: 'dashboard' })
  } catch (err) {
    const typedErr: ErrorResponse = err as ErrorResponse
    error.value = typedErr.errors[0].message
  }
  isSaving.value = false
}
</script>

<template>
  <div>
    <div>
      <div class="flex items-center flex-none my-6 mx-4">
        <div class="flex-none">
          <img
            class="w-12  animate-bounce-in"
            src="@/assets/tw.png"

            alt="Workflow"
          >
        </div>
        <div
          class="flex-auto text-black ml-3 text-lg font-medium pt-4"
        >
          twiceware_myra
          <div class="text-xs font-light pt-1">
            {{ version }}
          </div>
        </div>
      </div>
    </div>
    <div class="my-6 w-full flex items-stretch flex-col">
      <div
        v-if="error"
        class="mb-6"
      >
        <twice-ui-alert title="Ups, das hat nicht funktioniert">
          {{ error }}
        </twice-ui-alert>
      </div>
      <twice-ui-form
        ref="formRef"
        autofocus
        class="gap-x-3"
        :initial-values="form"
        @request="isSaving = true"
        @submitted="onSubmit"
      >
        <twice-ui-form-group>
          <div class="col-span-24">
            <twice-ui-input
              autofocus
              name="email"
              rules="required|email"
              required
              label="E-Mal-Adresse"
              placeholder="E-Mal-Adresse"
            />
          </div>

          <div class="col-span-24">
            <twice-ui-input
              name="password"
              required
              type="password"
              rules="required"
              label="Kennwort"
              placeholder="Kennwort"
            />
          </div>

          <div class="col-span-24">
            <twice-ui-button
              variant="primary"
              type="submit"
              full
              label="Anmelden"
            />
          </div>
        </twice-ui-form-group>
      </twice-ui-form>
    </div>
  </div>
</template>
