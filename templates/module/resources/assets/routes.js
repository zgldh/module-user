export default [
  {path: '/user', component: () => System.import('./User/AppPage.vue')},
  {path: '/user/create', component: () => System.import('./User/EditorPage.vue')},
  {path: '/user/:id/edit', component: () => System.import('./User/EditorPage.vue')},

  {path: '/user/role', component: () => System.import('./Role/AppPage.vue')},
  {path: '/user/role/create', component: () => System.import('./Role/EditorPage.vue')},
  {path: '/user/role/:id/edit', component: () => System.import('./Role/EditorPage.vue')},

  {path: '/user/permission', component: () => System.import('./Permission/AppPage.vue')},
  {path: '/user/permission/create', component: () => System.import('./Permission/EditorPage.vue')},
  {path: '/user/permission/:id/edit', component: () => System.import('./Permission/EditorPage.vue')},
];