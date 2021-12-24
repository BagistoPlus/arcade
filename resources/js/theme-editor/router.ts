import { createRouter } from "vue2-helpers/vue-router";
import PageSections from "./views/PageSections.vue";
import EditSection from "./views/EditSection.vue";
import EditBlock from "./views/EditBlock.vue";

const router = createRouter({
  base: "/admin/arcade/themes/editor/",
  mode: "history",
  routes: [
    {
      path: "/:theme",
      name: "sections",
      component: PageSections as any,
    },
    {
      path: "/:theme/sections/:sectionId",
      name: "edit_section",
      component: EditSection,
    },
    {
      path: "/:theme/sections/:sectionId/blocks/:blockId",
      name: "edit_block",
      component: EditBlock,
    },
  ],
});

export default router;
