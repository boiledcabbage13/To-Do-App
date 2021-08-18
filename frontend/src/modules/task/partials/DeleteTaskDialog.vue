<template>
  <v-dialog v-model="dialog" max-width="290" persistent>
    <v-card>
      <v-card-title class="text-h5">
        Delete Task
      </v-card-title>

      <v-card-text>
        Are you sure you want to delete this task?
      </v-card-text>

      <v-card-actions>
        <v-spacer></v-spacer>

        <v-btn color="error" @click="closeDialog()">
          Cancel
        </v-btn>

        <v-btn color="primary" @click="deleteItem()">
          Submit
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  props: {
    dialog: {
      type: Boolean,
      default: false
    }
  },
  methods: {
    closeDialog() {
      this.$emit('close:dialog')
    },
    deleteItem() {
      this.$emit('delete:item')
    }
  }
}
</script>