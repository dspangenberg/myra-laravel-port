<script lang="ts" setup>
import { ref } from 'vue'
import { useContactStore } from '@/stores/ContactStore'
import { storeToRefs } from 'pinia'
import { type Option } from '@/types'

const contactStore = useContactStore()
const { paymentDeadlines, taxes, contactEdit } = storeToRefs(contactStore)

const isDebtor = ref(contactEdit.value?.is_debtor)
const isCreditor = ref(contactEdit.value?.is_creditor)

const onDebtorChange = (value: boolean) => {
  isDebtor.value = value
}
const onCreditorChange = (value: boolean) => {
  isCreditor.value = value
}

</script>

<template>
  <div>
    <twice-ui-form-group>
      <div class="col-span-12 flex space-x-3 items-center">
        <twice-ui-check-box
          label="Debitor"
          name="is_debtor"
          @input="onDebtorChange"
        />
        <twice-ui-check-box
          label="Kreditor"
          name="is_creditor"
          @input="onCreditorChange"
        />
      </div>
    </twice-ui-form-group>

    <twice-ui-form-group
      v-if="isDebtor"
      title="Debitorendaten"
    >
      <div class="col-span-12">
        <twice-ui-input
          label="Debitorennummer"
          name="debtor_number"
        />
      </div>
      <div class="col-span-12">
        <twice-ui-select
          :options="taxes as unknown as Option[]"
          label="Steuersatz"
          name="tax_id"
        />
      </div>
      <div class="col-span-12">
        <twice-ui-select
          :options="paymentDeadlines as unknown as Option[]"
          label="Zahlungsziel"
          name="payment_deadline_id"
        />
        <div class="pt-1">
          <twice-ui-check-box
            label="Mahnsperre"
            name="has_dunning_block"
          />
        </div>
      </div>
    </twice-ui-form-group>
    <twice-ui-form-group
      v-if="isCreditor"
      title="Kreditordaten"
    >
      <div class="col-span-12">
        <twice-ui-input
          label="Kreditorennummer"
          name="creditor_number"
        />
      </div>
    </twice-ui-form-group>
    <twice-ui-form-group
      title="Registerdaten"
    >
      <div class="col-span-12">
        <twice-ui-input
          label="Registergericht"
          name="register_court"
        />
      </div>
      <div class="col-span-12">
        <twice-ui-input
          label="Registernummer"
          name="register_number"
        />
      </div>
    </twice-ui-form-group>
    <twice-ui-form-group
      title="Steuerdaten"
    >
      <div class="col-span-12">
        <twice-ui-input
          label="Umsatzsteuer-ID"
          name="vat_id"
        />
      </div>
      <div class="col-span-12">
        <twice-ui-input
          label="Steuernummer"
          name="tax_number"
        />
      </div>
      <div class="col-span-12">
        <twice-ui-input
          label="Erfolgskonto"
          name="outturn_account_id"
        />
        <div class="pt-1">
          <twice-ui-check-box
            label="primär verwenden"
            name="is_primary"
          />
        </div>
      </div>
    </twice-ui-form-group>
  </div>
</template>
