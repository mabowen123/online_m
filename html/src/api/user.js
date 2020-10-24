import request from '@/utils/request'

export function login(data) {
  return request.post('admin/system/v1/login', data)
}

export function getInfo() {
  return request.get('admin/system/v1/admin')
}

export function logout() {
  return request.post('admin/system/v1/logout')
}
