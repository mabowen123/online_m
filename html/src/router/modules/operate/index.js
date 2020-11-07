import Layout from '@/layout'

const operateRouter = {
  name: '运营管理',
  type: 'success',
  routes: [
    {
      path: '/operate/settings',
      component: Layout,
      alwaysShow: true,
      meta: {
        title: '运营管理',
        icon: 'system'
      },
      children: [
        {
          path: 'test',
          component: () => import('@/views/form'),
          name: 'test',
          meta: {
            title: '用户管理',
            icon: 'user'
          }
        }
      ]
    }
  ]
}
export default operateRouter
