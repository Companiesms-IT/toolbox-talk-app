<template>
  <div class="dashboardbody">
    <div class="sectionHeading">
      <h3>
        My Toolbox Talks <span>{{ toolboxTalks.length }} Talks</span>
      </h3>
    </div>

    <div>
      <div class="filterBox">
        <div class="tabSection">
          <div class="tabgroupBox">
            <router-link :to="{ name: 'created-by-me-talks' }">
              <button class="cstmTabBtn">Created by Me</button>
            </router-link>
            <router-link :to="{ name: 'assign-to-me-talks' }">
              <button class="cstmTabBtn activeTab">Assigned to Me</button>
            </router-link>
          </div>

          <div class="flex gap-2">
            <router-link :to="{ name: 'toolbox-talks-library' }">
              <button class="bg-white text-black cstmprimaybtn">Library</button>
            </router-link>

            <router-link :to="{ name: 'create-new-talk' }">
              <button class="cstmprimaybtn">
                Create Toolbox<i class="fa-solid fa-plus ms-1"></i>
              </button>
            </router-link>
          </div>
        </div>

        <form @submit.prevent="applyFilter" class="filterFormBox">
          <div class="cstmFilterInputbox cstmFilterSearchbox position-relative">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input
              type="search"
              v-model="searchQuery"
              class="form-control"
              placeholder="Search"
            />
          </div>

          <div class="cstmFilterInputbox">
            <select
              type="text"
              v-model="statusFilter"
              class="form-control shadow-none! bg-[#cccccd]! text-[12px]! text-[#8F8F8F]! h-[38px] border-none! rounded-[0.375rem]! sh"
              placeholder="Status"
            >
              <option value="">Status</option>
              <option value="3">Ongoing</option>
              <option value="2">Completed</option>
              <option value="1">Ended</option>
            </select>
          </div>
          <div class="flex gap-1 items-center">
            <div class="cstmFilterInputbox">
              <DatePicker
                fieldClass="h-[38px] bg-[#cccccd]"
                v-model="startDate"
              />
            </div>
            <i class="pi pi-minus text-[8px]"></i>

            <div class="cstmFilterInputbox">
              <DatePicker
                fieldClass="h-[38px] bg-[#cccccd]"
                v-model="endDate"
              />
            </div>
          </div>

          <button class="cstmprimaybtn cstmblueBtn" type="submit">
            Apply Filter
          </button>
        </form>
      </div>

      <div class="tableWrapperBox">
        <div class="table-responsive cstmScrollabeTableBox">
          <table class="table mb-0">
            <thead class="position-sticky top-0">
              <tr>
                <th>Title</th>
                <th class="text-center" width="300">Due Date</th>
                <th width="150">Status</th>
              </tr>
            </thead>

            <tbody>
              <tr v-if="loading">
                <td colspan="3" class="text-center text-muted bg-light">
                  Loading...
                </td>
              </tr>
              <template v-else-if="toolboxTalks.length > 0">
                <tr
                  v-for="talk in toolboxTalks"
                  :key="talk.id"
                  @click="showTalkDetails(talk)"
                  class="cursor-pointer"
                >
                  <td>
                    <p class="mb-0">{{ talk.get_toolbox_talk.title }}</p>
                    <span>Toolbox Talk</span>
                  </td>
                  <td class="text-center">
                    <span v-if="talk.due_date">{{
                      formatDate(talk.due_date)
                    }}</span>
                    <span v-else>N/A</span>
                  </td>
                  <td v-if="talk.status === '1'">
                    <span class="StatusSuccess">Ended</span>
                  </td>
                  <td v-if="talk.status === '2'">
                    <span class="StatusSuccess">Completed</span>
                  </td>
                  <td v-if="talk.status === '3'">
                    <span class="StatusOngoing">Ongoing</span>
                  </td>
                </tr>
              </template>
              <tr v-else>
                <td colspan="3" class="text-center text-muted bg-light">
                  No Data Available!
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="cstmTablePagination">
          <button
            class="previoustableBtn"
            @click="previousPage"
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
            @click="nextPage"
            :disabled="currentPage === totalPages"
          >
            Next<i class="fa-solid fa-angle-right"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import apiClient from "../router/axios";
import Swal from "sweetalert2";

export default {
  name: "ToolboxTalksDashboard",
  data() {
    return {
      loading: false, // loading state for get all API
      toolboxTalks: [],

      searchQuery: "",
      statusFilter: "",
      startDate: "",
      endDate: "",
      currentPage: 1,
      totalPages: 1,
    };
  },
  methods: {
    async fetchToolboxTalks(page = 1) {
      try {
        this.loading = true;
        const response = await apiClient.get("/assignToMe-talks", {
          params: {
            search: this.searchQuery,
            status: this.statusFilter,
            start_date: this.startDate,
            end_date: this.endDate,
            page,
          },
        });
        this.toolboxTalks = response.data.assignToMeToolboxTalks.data || [];

        const { last_page, current_page } =
          response.data.assignToMeToolboxTalks.meta;
        this.currentPage = current_page;
        this.totalPages = last_page;
      } catch (error) {
        console.error("Error fetching toolbox talks:", error);
        Swal.fire({
          icon: "error",
          title: "Error!",
          text: "Failed to fetch toolbox talks. Please try again.",
        });
      } finally {
        this.loading = false;
      }
    },
    showTalkDetails(talk) {
      this.selectedTalk = talk;
      this.$router.push({
        name: "update-attachments",
        params: { id: talk.get_toolbox_talk.id },
      });
    },
    getStatusClass(status) {
      return {
        StatusSuccess: status === "1",
        StatusOngoing: status !== "1",
      };
    },
    changePage(page) {
      this.fetchToolboxTalks(page);
    },
    previousPage() {
      this.fetchToolboxTalks(this.currentPage - 1);
    },
    nextPage() {
      this.fetchToolboxTalks(this.currentPage + 1);
    },
    applyFilter() {
      this.fetchToolboxTalks();
    },
    formatDate(dateString) {
      const date = new Date(dateString);
      const day = String(date.getDate()).padStart(2, "0");
      const month = String(date.getMonth() + 1).padStart(2, "0");
      const year = date.getFullYear();
      return `${day}/${month}/${year}`;
    },
  },
  created() {
    this.fetchToolboxTalks();
  },
};
</script>
<style scoped>
.cursor-pointer {
  cursor: pointer;
  color: #666666;
}
</style>
