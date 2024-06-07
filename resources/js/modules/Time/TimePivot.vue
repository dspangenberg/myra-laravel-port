<template>
  <twice-ui-pivot>
    <twice-ui-pivot-item
      label="Meine Woche"
      route-name="times-week"
      active-route-path="/app/times/week"
    />
    <twice-ui-pivot-item
      label="Liste"
      route-name="times-list"
      :route-query="{view: 'all'}"
      active-route-path="/app/times/list"
      :active-route-query="{view: 'all'}"
    />
    <twice-ui-pivot-item
      label="Abrechenbare Zeiten"
      route-name="times-list"
      :route-query="{view: 'billable'}"
      active-route-path="/app/times/list"
      :active-route-query="{view: 'billable'}"
    />
  </twice-ui-pivot>
</template>
<script setup lang="ts">
</script>
