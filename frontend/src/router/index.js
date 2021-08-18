import Vue from 'vue'
import VueRouter from 'vue-router'
import { TaskModuleRoutes } from '@/modules/task/utils/router'
import { AuthModuleRoutes } from '@/modules/auth/utils/router'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    redirect: '/tasks'
  },
  ...TaskModuleRoutes,
  ...AuthModuleRoutes,
  {
    path: "*",
    component: () => import(/* webpackChunkName: 'pageNotFound' */ '../views/404')
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

router.beforeEach((to, from, next) => {
  let authenticated = localStorage.getItem("authenticated");

  if (to.matched.some(record => record.meta.requiredAuth)) {
    //Redirect if not authenticated
    if (!authenticated) {
      next("/login");

      return;
    }
  }

  next();
});

export default router
