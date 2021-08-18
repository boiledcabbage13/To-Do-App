<template>
  <v-select
    :items="items"
    v-on="$listeners"
    v-bind="$attrs"
    item-text="text"
    item-value="value"
  ></v-select>
</template>

<script>
export default {
  data: () => ({
    items: [
      {
        text: 'Pending',
        value: 'pending'
      },
      {
        text: 'Completed',
        value: 'completed'
      }
    ]
  })
}
</script>