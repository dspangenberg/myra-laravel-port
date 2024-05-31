import { computed, ref } from 'vue'

export default function useSafePassword () {
  const password = ref('')

  const updatePassword = (givenPassword: string) => {
    password.value = givenPassword
  }

  const specialCharacters = ref(['!', '@', '#', '$', '%', '^', '&', '*', '+', '=', '.', '-', ','])
  const hasNumber = computed(() => /\d/.test(password.value))
  const hasLowercase = computed(() => /[a-z]/.test(password.value))
  const hasUppercase = computed(() => /[A-Z]/.test(password.value))
  const hasSpecialCharacter = computed(() => /[!@#$%^&*,)(+=._-]/.test(password.value))
  const hasEnoughCharacters = computed(() => password.value.length >= 12)

  const score = computed(() => {
    let score = 0
    if (hasNumber.value === true) score = score + 10
    if (hasLowercase.value === true) score++
    if (hasUppercase.value === true) score++
    if (hasSpecialCharacter.value === true) score++
    if (hasEnoughCharacters.value === true) score++

    return score
  })

  return {
    score,
    specialCharacters,
    hasNumber,
    hasLowercase,
    hasUppercase,
    hasSpecialCharacter,
    hasEnoughCharacters,
    updatePassword
  }
}
