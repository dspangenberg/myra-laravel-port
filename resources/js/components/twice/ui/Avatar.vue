<script setup lang="ts">
import { Avatar, AvatarFallback, AvatarImage } from '@/components/shdn/ui/avatar'

export interface Props {
  avatar?: string
  initials?: string,
  fullname?: string
  size?: 'sm' | 'md' | 'lg' | 'xs'
}

withDefaults(defineProps<Props>(), {
  avatar: 'null',
  size: 'md',
  initials: '',
  fullname: ''
})

</script>

<template>
  <Avatar
    :size="size"
  >
    <AvatarImage
      :src="avatar"
    />
    <AvatarFallback
      :fullname="fullname"
      :size="size"
    >
      {{ initials }}
    </AvatarFallback>
  </Avatar>
</template>
