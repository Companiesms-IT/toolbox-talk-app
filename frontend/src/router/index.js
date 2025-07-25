import { createRouter, createWebHistory } from "vue-router";
import DefaultLayout from "../layouts/DefaultLayout.vue";
import CmsDashboard from "../pages/CmsDashboard.vue";
import CreateNewTalk from "../pages/CreateNewTalk.vue";
import CreatedByMeTalks from "../pages/CreatedByMeTalks.vue";
import ListOfToolboxTalks from "../pages/ListOfToolboxTalks.vue";
import EditToolboxTalk from "../pages/EditToolboxTalk.vue";
import ToolboxDetailsPage from "../pages/ToolboxDetailsPage.vue";
import AssignToMeTalks from "../pages/AssignToMeTalks.vue";
import UpdatesAndAttachments from "../pages/UpdatesAndAttachments.vue";
import CMSPage from "../pages/CMSPage.vue";
import CMSLibraryPage from "../pages/CMSLibraryPage.vue";
import AssignedToolbox from "../pages/AssignedToolbox.vue";
import CompanyLibraryToolbox from "../pages/CompanyLibraryToolbox.vue";

const routes = [
  {
    path: "/",
    component: DefaultLayout,
    children: [
      {
        path: "",
        name: "cms-dashboard",
        redirect: { name: "assign-to-me-talks" },
      },
      {
        path: "create-new-talk",
        name: "create-new-talk",
        component: CreateNewTalk,
      },
      {
        path: "my-toolbox-talks",
        name: "my-toolbox-talks",
        redirect: { name: "created-by-me-talks" },
        children: [
          {
            path: "created-by-me",
            name: "created-by-me-talks",
            component: CreatedByMeTalks,
          },
          {
            path: "assigned-to-me",
            name: "assign-to-me-talks",
            component: AssignToMeTalks,
          },
          {
            path: "created-by-me/:id",
            name: "cms-detail",
            component: CMSPage,
          },
          {
            path: "assigned-to-me/:id",
            name: "update-attachments",
            component: UpdatesAndAttachments,
          },
        ],
      },

      {
        path: "toolbox-talks",
        name: "toolbox-talks",
        component: ListOfToolboxTalks,
      },
      {
        path: "edit-toolbox-talk/:id",
        name: "edit-toolbox",
        component: EditToolboxTalk,
      },
      {
        path: "details-toolbox-talk/:id",
        name: "detail-page",
        component: ToolboxDetailsPage,
      },
      {
        path: "toolbox-library",
        name: "toolbox-talks-library",
        component: CompanyLibraryToolbox,
      },
      {
        path: "cms-library",
        name: "cms-library",
        component: CMSLibraryPage,
      },
      {
        path: "assigned-cms",
        name: "assigned-cms",
        component: AssignedToolbox,
      },
    ],
  },
];
const router = createRouter({
  history: createWebHistory(),
  routes,
});
export default router;
