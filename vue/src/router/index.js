import { createRouter, createWebHashHistory } from 'vue-router'
import { computed, ref, watchEffect } from 'vue'
import store from "../stores";

//Global
import LandingView from '@/views/LandingView.vue'
import ProfileView from '@/views/ProfileView.vue'
import DefaultLayout from '@/layouts/DefaultLayout.vue'
import GuestLayout from '@/layouts/LayoutGuest.vue'
import LandingLayout from '@/layouts/LandingLayout.vue'

// Admin Dashboard
import AdminHome from '@/views/admin/HomeView.vue'
import UserView from '@/views/admin/UserView.vue'
import UserForm from '@/views/admin/UserForm.vue'
import CategoryView from '@/views/admin/CategoryView.vue'
import CategoryFormView from '@/views/admin/CategoryFormView.vue'
import ProductView from '@/views/admin/ProductView.vue'
import ProductFormView from '@/views/admin/ProductFormView.vue'
import SupplyProductView from '@/views/admin/SupplyProductView.vue'
import SupplyProductFormView from '@/views/admin/SupplyProductFormView.vue'
import ReportsView from '@/views/admin/ReportsView.vue'

// Staff Dashboard
import StaffHome from '@/views/staff/HomeView.vue'

// Supplier Dashboard
import SupplierHome from '@/views/supplier/HomeView.vue'
import OrderProductView from '@/views/staff/OrderProductView.vue'
import TransactionView from '@/views/staff/TransactionView.vue'


const routes = [
  {
    path: "/admin",
    redirect: "/admin/dashboard",
    name: "admin",
    component: DefaultLayout,
    meta: { isAdmin: true, requiresAuth: true },
    children: [
      {
        meta: {
          title: 'Dashboard'
        },
        path: '/admin/dashboard',
        name: 'admin-dashboard',
        component: AdminHome
      },
      {
        meta: {
          title: 'Profile'
        },
        path: '/admin/profile',
        name: 'admin-profile',
        component: ProfileView
      },
      {
        meta: {
          title: 'User',
        },
        path: '/admin/user',
        name: 'admin-user',
        component: UserView
      },
      {
        meta: {
          title: 'Add User'
        },
        path: '/admin/add-user',
        name: 'admin-add-user',
        component: UserForm
      },
      { 
        meta: {
          title: 'Edit User'
        },
        path: "/admin/edit-user/:id", 
        name: "admin-edit-user", 
        component: UserForm 
      },
      // Category
      {
        meta: {
          title: 'Category',
        },
        path: '/admin/category',
        name: 'admin-category',
        component: CategoryView
      },
      {
        meta: {
          title: 'Add Category'
        },
        path: '/admin/add-category',
        name: 'admin-add-category',
        component: CategoryFormView
      },
      { 
        meta: {
          title: 'Edit Category'
        },
        path: "/admin/edit-category/:id", 
        name: "admin-edit-category", 
        component: CategoryFormView 
      },
      // Products
      {
        meta: {
          title: 'Product',
        },
        path: '/admin/product',
        name: 'admin-product',
        component: ProductView
      },
      {
        meta: {
          title: 'Add Product'
        },
        path: '/admin/add-product',
        name: 'admin-add-product',
        component: ProductFormView
      },
      { 
        meta: {
          title: 'Edit Product'
        },
        path: "/admin/edit-product/:id", 
        name: "admin-edit-product", 
        component: ProductFormView 
      },
      // Supply
      {
        meta: {
          title: 'Supply Product',
        },
        path: '/admin/supply',
        name: 'admin-supply',
        component: SupplyProductView
      },
      {
        meta: {
          title: 'Supply Product'
        },
        path: '/admin/supply-product',
        name: 'admin-supply-product',
        component: SupplyProductFormView
      },
      {
        meta: {
          title: 'Reports'
        },
        path: '/admin/reports',
        name: 'admin-reports',
        component: ReportsView
      },
    ],
  },
  {
    path: "/staff",
    redirect: "/staff/dashboard",
    name: "staff",
    component: DefaultLayout,
    meta: { isStaff: true, requiresAuth: true},
    children: [
      {
        meta: {
          title: 'Dashboard'
        },
        path: '/staff/dashboard',
        name: 'staff-dashboard',
        component: StaffHome
      },
      {
        meta: {
          title: 'Profile'
        },
        path: '/staff/profile',
        name: 'staff-profile',
        component: ProfileView
      },
      {
        meta: {
          title: 'Order Product'
        },
        path: '/staff/order-product',
        name: 'order-product',
        component: OrderProductView
      },
      {
        meta: {
          title: 'Transaction'
        },
        path: '/staff/transaction',
        name: 'transaction',
        component: TransactionView
      },
    ],
  },
  {
    path: "/supplier",
    redirect: "/dashboard",
    name: "supplier",
    component: DefaultLayout,
    meta: { isSupplier: true, requiresAuth: true },
    children: [
      {
        meta: {
          title: 'Supplier Dashboard'
        },
        path: '/dashboard',
        name: 'supplier-dashboard',
        component: SupplierHome
      },
      {
        meta: {
          title: 'Profile'
        },
        path: '/profile',
        name: 'profile',
        component: ProfileView
      },
    ],
  },
  {
    path: "/auth",
    redirect: "/login",
    name: "auth",
    component: GuestLayout,
    meta: {isGuest: true},
    children: [
      {
        meta: {
          title: 'Login'
        },
        path: '/login',
        name: 'login',
        component: () => import('@/views/LoginView.vue')
      },
    ],
  },
  {
    path: "/",
    redirect: "/home",
    name: "home",
    meta: {isGuest: true},
    // component: LandingLayout,
    children: [
      {
        meta: {
          title: 'Home Page'
        },
        path: '/home',
        name: 'home-page',
        component: LandingView
      },
    ],
  },
  {
    meta: {
      title: 'Not Found'
    },
    path: '/:catchAll(.*)',
    name: 'not-found',
    component: () => import('@/views/NotFoundView.vue')
  },
  {
    meta: {
      title: 'Error'
    },
    path: '/error',
    name: 'error',
    component: () => import('@/views/ErrorView.vue')
  },

]

const router = createRouter({
  history: createWebHashHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    return savedPosition || { top: 0 }
  }
});

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth && !store.state.user.token) {
    next({ name: "login" });
  } else if (store.state.user.token && to.meta.isGuest) {
    next({ name: `${store.state.user.role}-dashboard`})
  } else if ((store.state.user.role != 'admin') && to.meta.isAdmin) {
    // watchEffect(()=>{
    //   store.state.user.role
    // })

    next({ name: `${store.state.user.role}-dashboard`})
  } else if ((store.state.user.role != 'staff') && to.meta.isStaff) {
    
    next({ name: `${store.state.user.role}-dashboard`})
  } else if ((store.state.user.role != 'supplier') && to.meta.isSupplier) {
    next({ name: `${store.state.user.role}-dashboard`})
  } else {
    next();
  }
});


export default router
