import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory('/'),
  routes: [
     {
      path: '/app',
      children: [
          {
              path: '/app/envio',
              name: 'home',
              component: () => import('../views/EnvioView.vue')
          },
          {
              path: '/app/status',
              name: 'lista',
              component: () => import('../views/ListagemEnvios.vue')
          }
      ]
    },
  ],
})

export default router
