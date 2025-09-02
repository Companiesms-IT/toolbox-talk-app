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
              <button class="cstmTabBtn activeTab">Created by Me</button>
            </router-link>
            <router-link :to="{ name: 'assign-to-me-talks' }">
              <button class="cstmTabBtn">Assigned to Me</button>
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
              class="form-control shadow-none! bg-[#cccccd]! text-[12px]! text-[#8F8F8F]! h-[38px] border-none! rounded-[0.375rem]!"
              placeholder="Status"
            >
              <option value="">Status</option>
              <option value="0">Unassigned</option>
              <option value="1">Assigned</option>
              <option value="2">Ended</option>
            </select>
          </div>
          <div class="flex gap-1 items-center">
            <div class="cstmFilterInputbox">
              <DatePicker
                fieldClass="h-[38px] bg-[#cccccd]"
                v-model="startDate"
                :disableAfter="endDate"
              />
            </div>
            <i class="pi pi-minus text-[8px]"></i>
            <div class="cstmFilterInputbox">
              <DatePicker
                fieldClass="h-[38px] bg-[#cccccd]"
                v-model="endDate"
                :disableBefore="startDate"
              />
            </div>
          </div>

          <button class="cstmprimaybtn cstmblueBtn" type="submit">
            Apply Filter
          </button>
          <div class="ms-auto">
            <button
              :disabled="!selectedTalks.length"
              @click="deletePopup = true"
              class="delete-selected-talks"
              :class="!selectedTalks.length && 'opacity-40'"
            >
              <i
                class="fa fa-trash"
                :class="
                  !selectedTalks.length && 'opacity-60 cursor-not-allowed!'
                "
              ></i>
            </button>
            <div class="delete-popup" v-if="deletePopup">
              <div class="main-pop-msg">
                <div class="heading-wrap">
                  <span class="action-msg-span">Action Required</span>
                  <span class="msgspan"
                    >Are you sure you want to delete these toolbox Talks from
                    the ‘created by me’ page?</span
                  >
                </div>
                <div class="line-break"></div>
                <div class="go-back-btn-wrapper">
                  <button class="cancel-btn" @click="deletePopup = false">
                    Cancel
                  </button>
                  <button class="yes-btn" @click="deleteSelectedTalks">
                    Yes
                  </button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>

      <div class="tableWrapperBox">
        <div class="table-responsive cstmScrollabeTableBox">
          <table class="table mb-0">
            <thead class="position-sticky top-0">
              <tr class="con-style">
                <th class="inp-style" width="30">
                  <input
                    type="checkbox"
                    aria-label="Select All"
                    @change="toggleSelectAll"
                    :checked="areAllSelected"
                  />
                </th>
                <th class="title-style">Title</th>
                <th class="due-date-style text-center" width="180">Due Date</th>
                <th class="status-style" width="150">Status</th>
                <th class="complete-style" width="150">Completed Status</th>
              </tr>
            </thead>

            <tbody>
              <tr v-if="loading">
                <td colspan="5" class="text-center text-muted bg-light">
                  Loading...
                </td>
              </tr>
              <template v-else-if="toolboxTalks.length > 0">
                <tr
                  v-for="talk in toolboxTalks"
                  :key="talk.id"
                  class="cursor-pointer con-style-bdy"
                >
                  <td class="inp-style">
                    <input
                      type="checkbox"
                      :value="talk.id"
                      @change="toggleTalkSelection(talk.id, $event)"
                      :checked="selectedTalks.includes(talk.id)"
                    />
                  </td>
                  <td @click="showTalkDetails(talk)" class="title-style">
                    <p class="mb-0">{{ talk.title }}</p>
                    <span>Toolbox Talk</span>
                  </td>
                  <td
                    @click="showTalkDetails(talk)"
                    class="due-date-style text-center"
                  >
                    <span v-if="talk.due_date">{{
                      formatDate(talk.due_date)
                    }}</span>
                    <span v-else> N/A </span>
                  </td>
                  <td @click="showTalkDetails(talk)" class="status-style">
                    <span v-if="talk.status === '2'" class="StatusSuccess"
                      >Assigned</span
                    >
                    <span v-else-if="talk.status === '1'" class="StatusSuccess"
                      >Assigned</span
                    >
                    <span v-else-if="talk.status === '0'" class="StatusOngoing"
                      >Unassigned</span
                    >
                    <span v-else class="StatusOngoing">N/A</span>
                  </td>
                  <td @click="showTalkDetails(talk)" class="complete-style">
                    <span class="complete-span-style"
                      >{{ talk.get_count_completed_count }} out of
                      {{ talk.get_assigned_users_count }}</span
                    >
                  </td>
                </tr>
              </template>
              <tr v-else>
                <td colspan="5" class="text-center text-muted bg-light">
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
import DatePicker from "../components/DatePicker.vue";

export default {
  name: "ToolboxTalksDashboard",
  data() {
    return {
      loading: false, // loading state for get All talks API
      deletePopup: false,
      toolboxTalks: [], // Initialize as an empty array
      selectedTalks: [],

      searchQuery: "",
      statusFilter: "",
      startDate: "",
      endDate: "",

      currentPage: 1,
      totalPages: 1,
    };
  },
  computed: {
    areAllSelected() {
      return this.selectedTalks.length === this.toolboxTalks.length;
    },
  },
  methods: {
    async fetchToolboxTalks(page = 1) {
      try {
        this.loading = true;
        const response = await apiClient.get("/createdByMe-talks", {
          params: {
            search: this.searchQuery,
            status: this.statusFilter,
            start_date: this.startDate,
            end_date: this.endDate,
            page,
          },
        });
        // Ensure response.data.toolboxTalks is defined and is an array
        this.toolboxTalks = Array.isArray(response.data.toolboxTalks.data)
          ? response.data.toolboxTalks.data
          : [];

        const { last_page, current_page } = response.data.toolboxTalks.meta;
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

    async deleteSelectedTalks() {
      const selectedTalkIds = this.selectedTalks;
      try {
        const response = await apiClient.post("/delete-selected-talks", {
          toolboxTalk_ids: JSON.stringify(selectedTalkIds), // Convert array to JSON string if needed
        });
        this.toolboxTalks = this.toolboxTalks.filter(
          (talk) => !selectedTalkIds.includes(talk.id)
        );
        this.deletePopup = false;
        this.selectedTalks = [];
        this.fetchToolboxTalks();
      } catch (error) {
        Swal.fire("Error!", error.response.data.error, "error");
      }
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
    createToolbox() {
      this.$router.push({ name: "create-new-talk" });
    },
    showTalkDetails(talk) {
      this.selectedTalk = talk;
      this.$router.push({
        name: "cms-detail",
        params: { id: talk.id },
      });
    },
    formatDate(dateString) {
      if (!dateString) return "-";
      const date = new Date(dateString);
      const day = String(date.getDate()).padStart(2, "0");
      const month = String(date.getMonth() + 1).padStart(2, "0");
      const year = date.getFullYear();
      return `${day}/${month}/${year}`;
    },
    toggleSelectAll(event) {
      this.selectedTalks = event.target.checked
        ? this.toolboxTalks.map((talk) => talk.id)
        : [];
    },
    toggleTalkSelection(talkId, event) {
      if (event.target.checked) {
        if (!this.selectedTalks.includes(talkId)) {
          this.selectedTalks.push(talkId);
        }
      } else {
        this.selectedTalks = this.selectedTalks.filter((id) => id !== talkId);
      }
    },
  },
  created() {
    this.fetchToolboxTalks();
  },
};
</script>

<style scoped>
.fa-trash {
  cursor: pointer;
  color: black;
}
.delete-selected-talks {
  border: none;
  background-color: lightgray;
}
.cursor-pointer {
  cursor: pointer;
}

.delete-popup {
  position: fixed;
  width: 800px;
  height: 178px;
  border-radius: 15px;
  z-index: 9;
  align-self: anchor-center;
  justify-self: anchor-center;
  padding-left: 20px;
  padding-top: 20px;
  background-color: white;
  border: 0.5px solid grey;
}

.main-pop-msg {
  width: 760px;
  height: 158px;
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.heading-wrap {
  display: flex;
  flex-direction: column;
}

.action-msg-span {
  width: 760px;
  background-color: #f46c4d;
  height: 45px;
  align-content: space-evenly;
  padding-left: 20px;
  border-radius: 60px;
  font-weight: bold;
}

.msgspan {
  padding-left: 20px;
  padding-top: 10px;
  color: #969696;
}
.complete-span-style {
  color: #323232;
  font-size: 14px;
}
.line-break {
  height: 1px;
  background-color: #969696;
  width: 100%;
}

.go-back-btn-wrapper {
  display: flex;
  justify-content: end;
  gap: 10px;
}

.yes-btn {
  background: #f46c4d;
  border: none;
  width: 80px;
  height: 38px;
  border-radius: 5px;
  color: white;
}

.cancel-btn {
  background: #bdbdbd;
  border: none;
  width: 100px;
  height: 38px;
  border-radius: 5px;
  color: #666666;
}

@media (min-width: 2560px) {
  .con-style {
    width: 100%;
  }

  .con-style-bdy {
    width: 100%;
  }
}
</style>
