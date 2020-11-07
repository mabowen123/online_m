import Layout from '@/layout'

const systemRouter = {
  name: '系统配置',
  type: 'danger',
  slug: 'system',
  routes: [
    {
      path: '/system/settings',
      component: Layout,
      alwaysShow: true,
      meta: {
        title: '系统配置',
        icon: 'system',
        slug: 'system:setting'
      },
      children: [
        {
          path: 'admin',
          component: () => import('@/views/system/setting/user'),
          name: 'Admin',
          meta: {
            title: '用户管理',
            icon: 'user',
            slug: 'system:setting:user'
          }
        }
      ]
    }
  ]
}
export default systemRouter
