const getters = {
  sidebar: state => state.app.sidebar,
  device: state => state.app.device,
  token: state => state.user.token,
  addRouters: state => state.permission.addRouters,
  permission_routers: state => state.permission.routers,
  name: state => state.user.name,
  username: state => state.user.username
}
export default getters
