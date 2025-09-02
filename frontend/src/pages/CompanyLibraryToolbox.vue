<template>
  <div class="dashboardbody">
    <div class="row">
      <div class="col-md-7">
        <div class="filterBox">
          <div class="tabSection gap-3 justify-content-start">
            <div class="tabgroupBox">
              <button
                class="cstmTabBtn"
                :class="{ activeTab: currentTab === 'createdByMe' }"
                @click="changeTab('createdByMe')"
              >
                Company Library
              </button>
              <button
                class="cstmTabBtn"
                :class="{ activeTab: currentTab === 'assignedToMe' }"
                @click="changeTab('assignedToMe')"
              >
                CMS Library
              </button>
            </div>
            <!-- TODO: fix this when CMS library is implemented -->
            <div class="template-count">
              {{ currentTab === "assignedToMe" ? 0 : templates.length }}
              Templates
            </div>
          </div>

          <div class="filterFormBox justify-content-between">
            <div class="l-side">
              <div
                class="toolTempInputbox cstmFilterSearchbox position-relative"
              >
                <i class="fa-solid fa-magnifying-glass"></i>
                <input
                  type="search"
                  class="form-control"
                  v-model="searchQuery"
                  placeholder="Search"
                />
              </div>
              <div class="sortby-filter">
                <span>Sort by</span>
                <select class="form-select" v-model="sortOption">
                  <option value="1">Date Created</option>
                  <option value="2">Date Updated</option>
                </select>
              </div>
            </div>
            <div class="r-side">
              <i class="fa fa-trash"></i>
              <button
                :class="
                  tickedTemplates.length === 0 &&
                  'opacity-60 cursor-not-allowed'
                "
                :disabled="!tickedTemplates.length"
                class="del-all-btn"
                @click="handleDeleteTemplatesClick"
              >
                Delete
              </button>
            </div>
          </div>
        </div>

        <div v-if="currentTab === 'createdByMe'" class="cstmtabContent">
          <div class="tableWrapperBox">
            <div class="toolbox-template-sec">
              <div class="row">
                <div
                  class="template-card"
                  v-for="template in templates"
                  :key="template.id"
                  @click="selectTemplate(template)"
                  @dblclick="goToDetailPage(template.id)"
                >
                  <div
                    class="template-item flex flex-col items-center p-2! rounded transition-all"
                    :class="
                      selectedTemplate?.id === template.id ? 'bg-[#cdcdcd]' : ''
                    "
                  >
                    <input
                      :checked="tickedTemplates.includes(template.id)"
                      @change="toggleTickTemplate(template.id)"
                      type="checkbox"
                      class="template-checkbox m-2"
                    />
                    <svg
                      width="80"
                      height="80"
                      viewBox="0 0 80 80"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M68 40H80V72C80 74.1217 79.1571 76.1566 77.6568 77.6568C76.1566 79.1571 74.1217 80 72 80H68V40ZM60 8V80H8C5.87827 80 3.84344 79.1571 2.34315 77.6568C0.842854 76.1566 0 74.1217 0 72V8C0 5.87827 0.842854 3.84344 2.34315 2.34315C3.84344 0.842854 5.87827 0 8 0H52C54.1217 0 56.1566 0.842854 57.6568 2.34315C59.1571 3.84344 60 5.87827 60 8ZM32 56H12V64H32V56ZM48 36H12V44H48V36ZM48 16H12V24H48V16Z"
                        fill="black"
                        fill-opacity="0.5"
                      ></path>
                    </svg>
                    <div class="template-name w-full">
                      <h5 style="color: black">{{ template.title }}</h5>
                      <span>Last Updated: {{ template.lastUpdated }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- New Pagination -->
            <div class="cstmTablePagination">
              <button
                class="previoustableBtn"
                @click="changePage(currentPage - 1)"
                :disabled="currentPage === 1"
              >
                <i class="fa-solid fa-angle-left"></i>Previous
              </button>
              <ul class="tablePaginationlist">
                <li v-for="page in totalPages" :key="page">
                  <a
                    href="javascript:void(0)"
                    @click="changePage(page)"
                    :class="{ activepagination: currentPage === page }"
                    >{{ page }}</a
                  >
                </li>
              </ul>
              <button
                class="nexttableBtn"
                @click="changePage(currentPage + 1)"
                :disabled="currentPage === totalPages"
              >
                Next<i class="fa-solid fa-angle-right"></i>
              </button>
            </div>
          </div>
        </div>

        <div v-if="currentTab === 'assignedToMe'" class="cstmtabContent">
          <div class="tableWrapperBox">
            <div class="toolbox-template-sec">
              <div class="row">
                <div
                  class="template-card"
                  v-for="template in assignedTemplates"
                  :key="template.id"
                  @click="selectTemplate(template)"
                >
                  <div class="template-item">
                    <input type="checkbox" class="template-checkbox" />
                    <svg
                      width="80"
                      height="80"
                      viewBox="0 0 80 80"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M68 40H80V72C80 74.1217 79.1571 76.1566 77.6568 77.6568C76.1566 79.1571 74.1217 80 72 80H68V40ZM60 8V80H8C5.87827 80 3.84344 79.1571 2.34315 77.6568C0.842854 76.1566 0 74.1217 0 72V8C0 5.87827 0.842854 3.84344 2.34315 2.34315C3.84344 0.842854 5.87827 0 8 0H52C54.1217 0 56.1566 0.842854 57.6568 2.34315C59.1571 3.84344 60 5.87827 60 8ZM32 56H12V64H32V56ZM48 36H12V44H48V36ZM48 16H12V24H48V16Z"
                        fill="black"
                        fill-opacity="0.5"
                      ></path>
                    </svg>
                    <div class="template-name">
                      <h5>{{ template.title }}</h5>
                      <span>Last Updated: {{ template.lastUpdated }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="cstmTablePagination">
              <button
                class="previoustableBtn"
                @click="changeAssignedPage(currentAssignedPage - 1)"
                :disabled="currentAssignedPage === 1"
              >
                <i class="fa-solid fa-angle-left"></i>Previous
              </button>
              <ul class="tablePaginationlist">
                <li>
                  <span class="activepagination">{{
                    currentAssignedPage
                  }}</span>
                </li>
                <li v-if="totalAssignedPages > 1">
                  <a
                    href="javascript:void(0)"
                    @click="changeAssignedPage(currentAssignedPage + 1)"
                    v-if="currentAssignedPage < totalAssignedPages"
                    >Next</a
                  >
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-5">
        <div class="description-head">
          <h5>Preview</h5>
        </div>
        <div class="preview-sec">
          <div v-if="selectedTemplate">
            <div class="flex flex-col text-center">
              <h2
                class="text-ellipsis max-w-full overflow-hidden"
                style="color: black"
              >
                {{ selectedTemplate.title }}
              </h2>
              <span>Created by {{ selectedTemplate.createdBy }}</span>
              <span>{{ selectedTemplate.creationDate }}</span>
            </div>
            <div class="description-box">
              <span style="min-width: 110px">Description</span>
              <span>{{ selectedTemplate.description }}</span>
            </div>

            <div class="divider-line"></div>
            <div class="supporting-file">
              <span>Supporting files</span>
              <span>{{ selectedTemplate.supportingFiles }} files</span>
            </div>
            <div class="divider-line"></div>
            <div class="question-sheet">
              <span>Question Sheet</span>
              <span>{{
                selectedTemplate.hasQuestionSheet ? "Yes" : "No"
              }}</span>
            </div>
            <div class="divider-line"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { inject } from "vue";
import apiClient from "../router/axios";
export default {
  setup() {
    const showAlert = inject("showAlert");
    return { showAlert };
  },
  data() {
    return {
      templates: [],
      selectedTemplate: null,
      tickedTemplates: [],

      currentTab: "createdByMe",
      searchQuery: "",
      sortOption: "",
      currentPage: 1,
      totalPages: 1,
      lastTimeout: null,
    };
  },
  watch: {
    searchQuery: {
      handler(val) {
        clearTimeout(this.lastTimeout);
        this.lastTimeout = setTimeout(() => {
          this.fetchToolboxTalks();
        }, 500);
      },
    },
    sortOption: {
      handler(val) {
        this.fetchToolboxTalks();
      },
    },
  },
  methods: {
    formatDate(dateString) {
      const date = new Date(dateString);
      const day = String(date.getDate()).padStart(2, "0");
      const month = String(date.getMonth() + 1).padStart(2, "0");
      const year = date.getFullYear();
      return `${day}/${month}/${year}`;
    },
    changeTab(tab) {
      this.currentTab = tab;
      this.selectedTemplate = null;
      this.currentPage = 1;
    },
    handleDeleteTemplatesClick() {
      this.showAlert({
        title: "Confirm Delete Templates",
        description: "Are you sure you want to delete selected templates?",
        actions: [
          {
            label: "Cancel",
          },
          {
            label: "Yes",
            handler: () => this.deleteTemplates(),
          },
        ],
      });
    },
    async deleteTemplates() {
      try {
        await apiClient.post("/delete-selected-cms-library", {
          toolbox_talk_id: this.tickedTemplates,
        });
        await this.fetchToolboxTalks();
        this.tickedTemplates = [];
        this.selectedTemplate = null;
      } catch (err) {
        console.error(err);
      }
    },
    deleteAll() {
      this.templates = [];
      this.selectedTemplate = null;
    },
    selectTemplate(template) {
      this.selectedTemplate = template;
    },
    changePage(page) {
      this.fetchToolboxTalks(page);
    },
    goToDetailPage(templateId) {
      this.$router.push({
        name: "toolbox-talks-library-preview",
        params: { id: templateId },
      });
    },
    async fetchToolboxTalks(page = 1) {
      const params = new URLSearchParams();
      params.append("search", this.searchQuery);
      params.append("page", page);
      params.append("sort_by", this.sortOption);

      const response = await apiClient
        .get("/company-library-toolbox-talks", {
          params,
        })
        .then((response) => {
          this.templates = response.data.toolboxTalks.data.map((talk) => ({
            id: talk.id,
            title: talk.title,
            video_url: talk.video_url,
            number_of_questions_to_ask: talk.number_of_questions_to_ask,
            number_of_correct_answer_to_pass:
              talk.number_of_correct_answer_to_pass,
            file: talk.file,
            description: talk.description || "No description available",
            createdBy: talk.get_created_by_user?.name || "",
            creationDate: this.formatDate(talk.created_at),
            lastUpdated: this.formatDate(talk.updated_at),
            supportingFiles:
              talk.attachments_pdf_data_count ||
              talk.attachments_videos_data_count,
            hasQuestionSheet: talk.number_of_questions_to_ask > 0,
          }));
          const { current_page, last_page } = response.data.toolboxTalks.meta;
          this.currentPage = current_page;
          this.totalPages = last_page;
        })
        .catch((error) => {
          console.error(
            "There was an error fetching the toolbox talks:",
            error
          );
        });
    },
    toggleTickTemplate(id) {
      if (this.tickedTemplates.includes(id))
        this.tickedTemplates.splice(this.tickedTemplates.indexOf(id), 1);
      else this.tickedTemplates.push(id);
    },
  },
  created() {
    this.fetchToolboxTalks();
  },
};
</script>

<style scoped>
.dashboardbody {
  padding: 0px 15px;
}
</style>
