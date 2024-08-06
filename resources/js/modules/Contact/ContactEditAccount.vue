<script lang="ts" setup>
import { useContactStore } from '@/stores/ContactStore'
import { storeToRefs } from 'pinia'
import { type Option } from '@/types'

const contactStore = useContactStore()
const { paymentDeadlines, taxes, bookkeepingAccounts, contactEdit } = storeToRefs(contactStore)

</script>

<template>
  <div v-if="contactEdit">
    <twice-ui-form-group>
      <div class="col-span-12 flex space-x-3 items-center">
        <twice-ui-form-check-box
          v-model="contactEdit.is_debtor"
          label="Debitor"
        />
        <twice-ui-form-check-box
          v-model="contactEdit.is_creditor"
          label="Kreditor"
        />
      </div>
    </twice-ui-form-group>

    <twice-ui-form-group
      v-if="contactEdit.is_debtor"
      title="Debitorendaten"
    >
      <div class="col-span-12">
        <twice-ui-form-input
          v-model="contactEdit.debtor_number"
          label="Debitorennummer"
        />
      </div>
      <div class="col-span-12">
        <twice-ui-form-select
          v-model="contactEdit.tax_id"
          :options="taxes as unknown as Option[]"
          label="Steuersatz"
        />
      </div>
      <div class="col-span-12">
        <twice-ui-form-select
          v-model="contactEdit.payment_deadline_id"
          :options="paymentDeadlines as unknown as Option[]"
          label="Zahlungsziel"
        />
        <div class="pt-1">
          <twice-ui-form-check-box
            v-model="contactEdit.has_dunning_block"
            label="Mahnsperre"
          />
        </div>
      </div>
    </twice-ui-form-group>
    <twice-ui-form-group
      v-if="contactEdit.is_creditor"
      title="Kreditordaten"
    >
      <div class="col-span-12">
        <twice-ui-form-input
          v-model="contactEdit.creditor_number"
          label="Kreditorennummer"
        />
      </div>
    </twice-ui-form-group>
    <twice-ui-form-group
      title="Registerdaten"
    >
      <div class="col-span-12">
        <twice-ui-form-input
          v-model="contactEdit.register_court"
          label="Registergericht"
        />
      </div>
      <div class="col-span-12">
        <twice-ui-form-input
          v-model="contactEdit.register_number"
          label="Registernummer"
        />
      </div>
    </twice-ui-form-group>
    <twice-ui-form-group
      title="Steuerdaten"
    >
      <div class="col-span-12">
        <twice-ui-form-input
          v-model="contactEdit.vat_id"
          label="Umsatzsteuer-ID"
        />
      </div>
      <div class="col-span-12">
        <twice-ui-form-input
          v-model="contactEdit.tax_number"
          label="Steuernummer"
        />
      </div>

      <div class="col-span-12">
        <twice-ui-form-input
          v-model="contactEdit.iban"
          label="IBAN"
        />
      </div>
      <div class="col-span-12">
        <twice-ui-form-input
          v-model="contactEdit.cc_name"
          label="Name auf Kreditkartenabrechnung"
        />
      </div>
      <div class="col-span-24">
        <twice-ui-form-select
          v-model="contactEdit.outturn_account_id"
          :options="bookkeepingAccounts as unknown as Option[]"
          label="Erfolgskonto"
          option-name="label"
          options-value="account_number"
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
