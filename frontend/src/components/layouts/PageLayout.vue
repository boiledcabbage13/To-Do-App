<template>
  <div class="blue-grey lighten-5">
    <v-app-bar dense color="primary" dark>
      <v-toolbar-title>To do</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn icon dense @click="logout">
        <v-icon>mdi-logout</v-icon>
      </v-btn>
    </v-app-bar>
    <div class="pa-10">
      <slot></slot>
    </div>
  </div>
</template>

<script>
import { authRepositoryApi } from '@/services/repositories'

export default {
  methods: {
    async logout() {
      await authRepositoryApi.logout()
      localStorage.removeItem('token')
      localStorage.removeItem('authenticated')
      this.$router.push('/login')
    }
  }
}
</script>