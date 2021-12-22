import { createRouter } from "vue2-helpers/vue-router";
import PageSections from "./views/PageSections.vue";

const router = createRouter({
  base: "/admin/arcade/themes/editor/",
  mode: "history",
  routes: [
    {
      path: "/:theme",
      name: "sections",
      component: PageSections as any,
    },
  ],
});

export default router;
