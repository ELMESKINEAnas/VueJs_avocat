import { createRouter, createWebHistory } from 'vue-router'

import SignupForm from '../views/createClient.vue'
import DashClient from '../views/DashClient.vue'

const routes = [
  {
    path: '/DashClient',
    name: 'Dash',
    component: DashClient
  },
  {
    path :"/Create",
    name :"create",
    component :SignupForm
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
