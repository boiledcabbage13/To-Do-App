<template>
  <v-snackbar
    v-on="$listeners"
    v-bind="$attrs"
    :timeout="2000"
    :color="color"
  >
    {{ message }}
  </v-snackbar>
</template>

<script>
export default {
  props: {
    message: {
      type: String,
      default: null
    },
    color: {
      type: String,
      default: 'error'
    }
  }
}
</script>