import request from '@/utils/request'

export function login(data) {
  return request.post('admin/system/v1/login', data)
}

export function getInfo() {
  return request.get('admin/system/v1/info')
}

export function logout() {
  return request.post('admin/system/v1/logout')
}

export function fetchList(query) {
  return request.get('admin/system/v1/admin', { params: query })
}

export function fetchDetail(id) {
  return request.get('admin/system/v1/admin/' + id)
}

export function deleteModel(id) {
  return request.delete('admin/system/v1/admin/' + id)
}

export function modtify(params) {
  let url = 'admin/system/v1/admin'
  if (params.id) {
    url = url + '/' + params.id
  }
  return request.post(url, params)
}

export function recover(id) {
  return request.post('admin/system/v1/admin/' + id + '/recover')
}
