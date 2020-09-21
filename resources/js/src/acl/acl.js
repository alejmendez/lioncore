import authService from '../auth/authService'
import router from '@/router'

router.beforeEach((to, from, next) => {
  const meta = to.meta
  const requiredPermission = meta.permission || false
  let requiredAuth = meta.Auth

  const userInfo = JSON.parse(localStorage.getItem('userInfo'))
  const permissions = userInfo ? userInfo.userPermissions : []
  const tokenExpireAt = parseInt(localStorage.getItem('tokenExpireAt'))
  const tokenExpired = (new Date().getTime()) > (isNaN(tokenExpireAt) ? 0 : tokenExpireAt)

  if (requiredAuth === undefined) {
    requiredAuth = true
  }

  if (!requiredAuth) {
    next()
    return
  }

  if (tokenExpired) {
    localStorage.removeItem('accessToken')
    localStorage.removeItem('userInfo')
    localStorage.removeItem('tokenExpireAt')
    next({ path: '/login' })
  } else if (requiredPermission !== false && !permissions.includes(requiredPermission)) {
    next({ path: '/not-authorized' })
  } else {
    next()
  }
})
