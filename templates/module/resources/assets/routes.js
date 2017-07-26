export default [
  {path: '/user', component: () => System.import('./User/ListPage.vue')},
  {path: '/user/create', component: () => System.import('./User/EditorPage.vue')},
  {path: '/user/:id/edit', component: () => System.import('./User/EditorPage.vue')},

  {path: '/user/role', component: () => System.import('./Role/ListPage.vue')},
  {path: '/user/role/create', component: () => System.import('./Role/EditorPage.vue')},
  {path: '/user/role/:id/edit', component: () => System.import('./Role/EditorPage.vue')},

  // {path: '/user/permission', component: () => System.import('./Permission/ListPage.vue')},
  // {path: '/user/permission/create', component: () => System.import('./Permission/EditorPage.vue')},
  // {path: '/user/permission/:id/edit', component: () => System.import('./Permission/EditorPage.vue')},
];