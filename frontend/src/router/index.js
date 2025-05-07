import { createRouter, createWebHistory } from "vue-router";

const routes = [
  {
    path: "/",
    redirect: "/form",
  },
  {
    path: "/form",
    name: "form",
    component: () => import("../FormPage.vue"),
  },
  {
    path: "/users",
    name: "list",
    component: () => import("../UsersList.vue"),
  },
  {
    path: "/user/:id",
    name: "user",
    component: () => import("../components/shared/UserData.vue"),
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
