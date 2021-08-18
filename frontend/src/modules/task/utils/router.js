const BASE_PATH = '/tasks';

export const TaskModuleRoutes = [
  {
    path: BASE_PATH,
    name: 'TaskModule',
    component: () => import(/* webpackChunkName: 'taskModule' */ '../TaskModule'),
    redirect: '/',
    children: [
      {
        path: '/',
        name: 'Task',
        component: () => import(/* webpackChunkName: 'taskPage' */ '../pages/TaskPage'),
        meta: {
          requiredAuth: true
        }
      }
    ],
    meta: {
      requiredAuth: true
    }
  }
]
