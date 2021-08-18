<template>
  <v-data-table
    :headers="headers"
    :items="items"
    class="elevation-2"
    :footer-props="footerProps"
    :loading="loading"
  >
    <template v-slot:top>
      <div class="d-flex align-center my-2 pa-4">
        <v-text-field
          v-model="search"
          label="Search..."
          class="mx-4"
          hide-details
          clearable
        ></v-text-field>
        <v-btn @click="$emit('search', search)">Search</v-btn>
      </div>
    </template>
    <template v-slot:[`item.is_done`]="{ item }">
      <v-switch
        v-model="item.status"
        :value="item.status !== 'completed' ? true : false"
        @change="changeStatus(item)"
      ></v-switch>
    </template>
    <template v-slot:[`item.actions`]="{ item }">
      <v-btn class="mx-2" color="warning" small @click="editItem(item)">
        <v-icon>mdi-pencil</v-icon>
      </v-btn>
      <v-btn class="mx-2" color="error" small @click="deleteItem(item)">
        <v-icon>mdi-trash-can</v-icon>
      </v-btn>
    </template>
  </v-data-table>
</template>

<script>
import { taskRepositoryApi } from '@/services/repositories'

export default {
  props: {
    items: {
      type: Array,
      default: () => []
    },
    loading: {
      type: Boolean,
      default: false
    }
  },
  data: () => ({
    footerProps: {
      itemsPerPageOptions: [5, 10, 15, 25]
    },
    search: '',
    headers: [
      {
        text: 'Done',
        value: 'is_done',
        sortable: false
      },
      {
        text: 'Name',
        value: 'name',
        sortable: false
      },
      {
        text: 'Description',
        value: 'description',
        sortable: false
      },
      {
        text: 'Status',
        value: 'status',
        sortable: false
      },
      {
        text: 'Start at',
        value: 'start_at',
        sortable: false
      },
      {
        text: 'End at',
        value: 'end_at',
        sortable: false
      },
      {
        text: 'Actions',
        value: 'actions',
        sortable: false
      },
    ],
    // items: []
  }),
  methods: {
    editItem(item) {
      this.$emit('edit:item', item)
    },
    deleteItem(item) {
      this.$emit('delete:item', item)
    },
    async changeStatus(item) {
      if (item.status !== 'completed') {
        item.status = 'completed'
      } else {
        item.status = 'pending'
      }

      await taskRepositoryApi.update(item.id, item)
        .finally(() => {
          return item
        })
    }
  }
}
</script>