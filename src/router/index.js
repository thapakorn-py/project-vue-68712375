import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },

  {
    path: '/about',
    name: 'about',
    component: () => import( '../views/AboutView.vue')
  },

  {
    path: '/contact',
    name: 'contact',
    component: () => import( '../views/contact.vue')
  },
  
  {
    path: '/Product_api',
    name: 'Product_api',
    component: () => import( '../views/Product_api.vue')
  },
  
  {
    path: '/Product_list',
    name: 'Product_list',
    component: () => import( '../views/Product_list.vue')
  },

  {
    path: '/gold',
    name: 'gold',
    
    component: () => import( '../views/Gold.vue')
  },

  {
    path: '/showcustomer',
    name: 'showcustomer',
    component: () => import( '../views//show_customer.vue')
  },

  {
    path: '/showemployees',
    name: 'showemployees',
    component: () => import( '../views//show_employees.vue')
  },

  {
    path: '/login',
    name: 'login',
    component: () => import( '../views/login.vue')
  },

  {
    path: '/register',
    name: 'register',
    component: () => import( '../views/register.vue')
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router

