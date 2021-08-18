<template>
  <v-form ref="form" v-model="valid" lazy-validation>
    <v-text-field
      v-model="form.name"
      :rules="requiredRules"
      label="Name"
      type="text"
      required
    ></v-text-field>

    <v-textarea
      v-model="form.description"
      label="Description"
    ></v-textarea>

    <div class="pa-4">
      <div class="font-weight-bold">Start at:</div>
      <div>
        <v-menu
          v-model="startAtDatePickerMenu"
          :close-on-content-click="false"
          :nudge-right="40"
          transition="scale-transition"
          offset-y
          min-width="auto"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-text-field
              v-model="form.dateStartAt"
              label="Date"
              prepend-icon="mdi-calendar"
              readonly
              v-bind="attrs"
              v-on="on"
              :rules="requiredRules"
            ></v-text-field>
          </template>
          <v-date-picker
            v-model="form.dateStartAt"
            @input="startAtDatePickerMenu = false"
          ></v-date-picker>
        </v-menu>

        <v-menu
          ref="menuTimeStartAt"
          v-model="startAtTimePickerMenu"
          :close-on-content-click="false"
          :nudge-right="40"
          :return-value.sync="form.timeStartAt"
          transition="scale-transition"
          offset-y
          max-width="290px"
          min-width="290px"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-text-field
              v-model="form.timeStartAt"
              label="Time"
              prepend-icon="mdi-clock-time-four-outline"
              readonly
              v-bind="attrs"
              v-on="on"
            ></v-text-field>
          </template>
          <v-time-picker
            v-if="startAtTimePickerMenu"
            v-model="form.timeStartAt"
            full-width
            @click:minute="$refs.menuTimeStartAt.save(form.timeStartAt)"
          ></v-time-picker>
        </v-menu>
      </div>
    </div>
   
    <div class="pa-4">
      <div class="font-weight-bold">End at:</div>
      <div>
        <v-menu
          v-model="endAtDatePickerMenu"
          :close-on-content-click="false"
          :nudge-right="40"
          transition="scale-transition"
          offset-y
          min-width="auto"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-text-field
              v-model="form.dateEndAt"
              label="Date"
              prepend-icon="mdi-calendar"
              readonly
              v-bind="attrs"
              v-on="on"
            ></v-text-field>
          </template>
          <v-date-picker
            v-model="form.dateEndAt"
            @input="endAtDatePickerMenu = false"
          ></v-date-picker>
        </v-menu>

        <v-menu
          ref="menuTimeEndAt"
          v-model="endAtTimePickerMenu"
          :close-on-content-click="false"
          :nudge-right="40"
          :return-value.sync="form.timeEndAt"
          transition="scale-transition"
          offset-y
          max-width="290px"
          min-width="290px"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-text-field
              v-model="form.timeEndAt"
              label="Time"
              prepend-icon="mdi-clock-time-four-outline"
              readonly
              v-bind="attrs"
              v-on="on"
            ></v-text-field>
          </template>
          <v-time-picker
            v-if="endAtTimePickerMenu"
            v-model="form.timeEndAt"
            full-width
            @click:minute="$refs.menuTimeEndAt.save(form.timeEndAt)"
          ></v-time-picker>
        </v-menu>
      </div>
    </div>

    <div>
      <status-select-box v-model="form.status" label="Status"></status-select-box>
    </div>

    <div class="text-right">
      <v-btn :loading="loading" :disabled="!valid" color="primary" class="mt-4" @click="submit">
        Submit
      </v-btn>
    </div>
   
  </v-form>
</template>

<script>
import { taskRepositoryApi } from '@/services/repositories'

export default {
  components: {
    StatusSelectBox: () => import('../partials/StatusSelectBox')
  },
  props: {
    form: {
      type: Object,
      default: () => {
        return {
          // dateStartAt: new Date().toISOString().substr(0, 10)
        }
      }
    }
  },
  data: () => ({
    valid: true,
    requiredRules: [(v) => !!v || "This field is required"],
    emailRules: [(v) => /.+@.+\..+/.test(v) || 'E-mail must be valid'],
    loading: false,
    startAtTimePickerMenu: false,
    startAtDatePickerMenu: false,
    endAtTimePickerMenu: false,
    endAtDatePickerMenu: false
  }),

  methods: {
    validate() {
      return this.$refs.form.validate()
    },
    async create() {
      await taskRepositoryApi.create(this.form)
        .then(response => {
          let {
            data
          } = response

          this.$emit('after:submit', {
            data: data.data,
            message: data.message,
            success: true
          })
        })
        .catch(error => {
          this.$emit('after:submit', {
            data: null,
            message: error.response.data.message,
            success: false
          })
        })
        .finally(() => {
          this.loading = false
        })
    },
    async update() {
      await taskRepositoryApi.update(this.form.id, this.form)
        .then(response => {
          let {
            data
          } = response

          this.$emit('after:submit', {
            data: data.data,
            message: data.message,
            success: true
          })
        })
        .catch(error => {
          this.$emit('after:submit', {
            data: null,
            message: error.response.data.message,
            success: false
          })
        })
        .finally(() => {
          this.loading = false
        })
    },
    async submit() {
      if(this.validate()) {
        this.loading = true

        if (this.form.timeStartAt) {
          this.form.start_at = `${this.form.dateStartAt} ${this.form.timeStartAt}:00`
        } else {
          this.form.start_at = `${this.form.dateStartAt} 00:00:00`
        }

        if (this.form.dateEndAt && this.form.timeEndAt) {
          this.form.end_at = `${this.form.dateEndAt} ${this.form.timeEndAt}:00`
        } else {
          this.form.end_at = null
        }

        if (this.form.id) {
          this.update()
          return
        }

        this.create()
        return
      }
    }
  }
};
</script>