<template>
  <page-layout>
    <router-view></router-view>
  </page-layout>
</template>

<script>
export default {
  components: {
    PageLayout: () => import('@/components/layouts/PageLayout')
  }
}
</script>