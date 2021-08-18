<template>
  <v-form ref="form" v-model="valid" lazy-validation>
    <v-text-field
      v-model="form.email"
      :rules="[...requiredRules, ...emailRules]"
      label="E-mail"
      type="text"
      required
    ></v-text-field>

    <v-text-field
      v-model="form.password"
      :rules="requiredRules"
      label="Password"
      type="password"
      required
    ></v-text-field>

    <div class="text-right">
      <v-btn :loading="loading" :disabled="!valid" color="primary" class="mt-4" @click="submit">
        Submit
      </v-btn>
    </div>
   
  </v-form>
</template>

<script>
import { authRepositoryApi } from '@/services/repositories'

export default {
  data: () => ({
    form: {},
    valid: true,
    requiredRules: [(v) => !!v || "This field is required"],
    emailRules: [(v) => /.+@.+\..+/.test(v) || 'E-mail must be valid'],
    loading: false
  }),

  methods: {
    validate() {
      return this.$refs.form.validate()
    },
    async submit() {
      if(this.validate()) {
        this.loading = true

        await authRepositoryApi.login(this.form)
          .then(response => {
            let {
              data: {
                data: user
              }
            } = response

            this.$emit('after:submit', {
              data: user,
              message: response.data.message,
              success: true
            })

            localStorage.setItem('token', user.access_token)
            localStorage.setItem('authenticated', true)

            setTimeout(() => {
              this.$router.push('/')
            }, 2000);
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
      }
    }
  }
};
</script>