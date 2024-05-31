import { localize, setLocale } from '@vee-validate/i18n'
import { configure, defineRule } from 'vee-validate'
import de from '@vee-validate/i18n/dist/locale/de.json'
import { required, email, min, confirmed } from '@vee-validate/rules'
import useSafePassword from '@/composables/useSafePassword'

defineRule('required', required)
defineRule('email', email)
defineRule('min', min)
defineRule('confirmed', confirmed)

defineRule('safe-password', async (value: string, params: string): Promise<string | boolean> => {
  const { score, updatePassword } = useSafePassword()
  updatePassword(value)

  if (!value?.length) return true

  const [s] = params[0].split(':')
  if (parseInt(s) === score.value) return true

  return 'Das neue Kennwort ist nicht sicher genug.'
})

configure({
  generateMessage: localize({
    de
  })
})

setLocale('de')
