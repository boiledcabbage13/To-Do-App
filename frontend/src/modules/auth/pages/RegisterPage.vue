<template>
  <auth-layout>
    <v-card max-width="500" rounded="xl">
      <v-card-text class="pa-4">
      <register-form @after:submit="afterFormSubmit($event)"></register-form>
      </v-card-text>
    </v-card>
    <div class="mt-4">
      <router-link to="/login">Sign-in</router-link>
    </div>
    <snackbar
      v-model="snackbar.show"
      :color="snackbar.color"
      :message="snackbar.message"
    ></snackbar>
  </auth-layout>
</template>

<script>
export default {
  components: {
    RegisterForm: () => import('../forms/RegisterForm'),
    AuthLayout: () => import('../partials/AuthLayout'),
    Snackbar: () => import('@/components/partials/Snackbar')
  },
  data: () => ({
    snackbar: {
      show: false,
      message: null,
      color: 'error'
    },
  }),
  methods: {
    afterFormSubmit(event) {
       this.snackbar = {
        show: true,
        message: event.message,
        color: event.success ? 'success' : 'error'
      }
    }
  }
};
</script>