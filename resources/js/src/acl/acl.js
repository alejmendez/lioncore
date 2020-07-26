import Vue from 'vue'
import router from '@/router'

router.beforeEach((to, from, next) => {
  const meta = to.meta
  const requiredPermission = meta.permission
  const requiredAuth = meta.Auth || true

  const userInfo = JSON.parse(localStorage.getItem('userInfo'))
  const permissions = userInfo.userPermissions
  
  if (!window.localStorage.getItem('accessToken')) {
    next({ path: '/login' });
  } else if (requiredAuth) {
    if (requiredPermission == undefined) {
      next();
    } else if (!permissions.includes(requiredPermission)) {
      next({ path: '/not-authorized' });
    }
  } else {
    next();
  }
});
