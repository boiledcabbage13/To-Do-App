export const AuthModuleRoutes = [
  {
    path: '/login',
    name: 'LoginPage',
    component: () => import(/* webpackChunkName: 'taskModule' */ '../pages/LoginPage'),
    meta: {
      requiredAuth: false
    }
  },
  {
    path: '/register',
    name: 'RegisterPage',
    component: () => import(/* webpackChunkName: 'taskModule' */ '../pages/RegisterPage'),
    meta: {
      requiredAuth: false
    }
  }
]
