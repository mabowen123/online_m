import { constantRoutes, asyncRouterMap } from '@/router'

const permission = {
  state: {
    routers: constantRoutes,
    addRouters: []
  },
  mutations: {
    SET_ROUTERS: (state, routers) => {
      state.addRouters = routers
      state.routers = constantRoutes.concat(routers)
    }
  },
  actions: {
    generateRoutes({ commit }) {
      return new Promise(resolve => {
        const routes = asyncRouterMap()
        commit('SET_ROUTERS', routes)
        resolve()
      })
    }
  }
}

export default permission
