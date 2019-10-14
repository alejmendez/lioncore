const routes = [
    {
        path: '/login',
        name: 'login',
        meta: { layout: 'userpages' },
        component: () => import('../views/Login.vue'),
    },
    {
        path: '/pages/login-boxed',
        name: 'login-boxed',
        meta: { layout: 'userpages' },
        component: () => import('../views/LoginBoxed.vue'),
    },
    {
        path: '/pages/register',
        name: 'register',
        meta: { layout: 'userpages' },
        component: () => import('../views/Register.vue'),
    },
    {
        path: '/pages/register-boxed',
        name: 'register-boxed',
        meta: { layout: 'userpages' },
        component: () => import('../views/RegisterBoxed.vue'),
    },
    {
        path: '/pages/forgot-password',
        name: 'forgot-password',
        meta: { layout: 'userpages' },
        component: () => import('../views/ForgotPassword.vue'),
    },
    {
        path: '/pages/forgot-password-boxed',
        name: 'forgot-password-boxed',
        meta: { layout: 'userpages' },
        component: () => import('../views/ForgotPasswordBoxed.vue'),
    },
]

export default routes;