<template>
  <v-container fluid>
    <v-row>
      <v-col cols="3">
        <v-card>
          <v-card-text>
            <create-task-form
              :form="form"
              @after:submit="afterFormSubmit($event)"
            ></create-task-form>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col>
        <tasks-table
          :items="items"
          :loading="tableLoading"
          @edit:item="editItem($event)"
          @delete:item="deleteItem($event)"
          @search="getTasks({ search: $event })"
        ></tasks-table>
      </v-col>
    </v-row>
    <delete-task-dialog
      :dialog="dialog"
      @close:dialog="dialog = false"
      @delete:item="deleteTask()"
    ></delete-task-dialog>
    <snackbar
      v-model="snackbar.show"
      :color="snackbar.color"
      :message="snackbar.message"
    ></snackbar>
  </v-container>
</template>

<script>
import { taskRepositoryApi } from '@/services/repositories'

export default {
  components: {
    CreateTaskForm: () => import(/* webpackChunkName: "CreateTaskForm.vue" */ '../forms/CreateTaskForm'),
    TasksTable: () => import(/* webpackChunkName: "TasksTable.vue" */ '../partials/TasksTable'),
    DeleteTaskDialog: () => import(/* webpackChunkName: "DeleteTaskDialog.vue" */ '../partials/DeleteTaskDialog'),
    Snackbar: () => import(/* webpackChunkName: "Snackbar.vue" */ '@/components/partials/Snackbar')
  },
  data: () => ({
    items: [],
    form: {},
    dialog: false,
    deleteId: null,
    snackbar: {
      show: false,
      message: null,
      color: 'error'
    },
    tableLoading: false
  }),
  methods: {
    async getTasks({ search = null }) {
      this.tableLoading = true

      let params = {
        limit: 15,
        q: search
      }
      await taskRepositoryApi.get({ params })
        .then(response => {
          let {
            data: {
              data: items
            }
          } = response

          this.items = items
        })
        .catch(() => {
          this.items = []
        })
        .finally(() => {
          this.tableLoading = false
        })
    },
    editItem(event) {
      this.form = { ...event }
      this.form.dateStartAt = event.start_at.substr(0, 10)
      this.form.timeStartAt = event.start_at.substr(11, 5)
      this.form.dateEndAt = event.end_at ? event.end_at.substr(0, 10) : null
      this.form.timeEndAt = event.end_at ? event.end_at.substr(11, 5) : null
    },
    deleteItem(event) {
      this.deleteId = event.id
      this.dialog = true
    },
    async deleteTask() {
      await taskRepositoryApi.delete(this.deleteId)
        .then(response => {
          this.snackbar = {
            show: true,
            message: response.data.message,
            color: 'success'
          }
        })
        .catch(error => {
          this.snackbar = {
            show: true,
            message: error.response.data.message,
            color: 'error'
          }
        })
        .finally(() => {
          this.dialog = false
          this.getTasks({})
        })
    },
    afterFormSubmit(event) {
      this.snackbar = {
        show: true,
        message: event.message,
        color: event.success ? 'success' : 'error'
      }

      this.form = {
        // dateStartAt: new Date().toISOString().substr(0, 10)
      }

      this.getTasks({})
    }
  },
  mounted() {
    this.getTasks({})
  }
}
</script>