<!-- @format -->

<template>
  <div class="dashboard-container">
    <div class="main-section">
      <div class="content-area">
        <div class="title-section">
          <h2 class="section-title">Toolbox Talks I Created / Sent</h2>
          <div class="btns-wrapper">
            <button
              type=""
              class="send-btn delete-talk-btn"
              @click="deleteSelectedTalks()"
              aria-label="Send Talk"
            >
              Delete Selected Talks
            </button>
            <router-link class="btn-wrapper" to="/create-talk">
              <button class="create-btn">Create a new Talk</button>
            </router-link>

            <button class="send-btn" aria-label="Send Talk" @click="openModal">
              Send
            </button>
          </div>
        </div>
        <div class="card">
          <!-- Filter Row -->
          <div class="search-container">
            <div>Show 1 entries</div>
            <div class="filter-row">
              <input type="text" placeholder="Search" class="search-input" />
            </div>
          </div>

          <table class="data-table" id="talksTable">
            <thead>
              <tr>
                <th>
                  <input
                    type="checkbox"
                    aria-label="Select All"
                    v-model="isAllSelected"
                    @change="toggleSelectAll"
                  />
                </th>
                <th>Title</th>
                <th>Date</th>
                <!-- <th>Assignee</th> -->
                <th>Status</th>
                <th>Completed status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <template v-if="withPaginatedTalks.length > 0">
                <tr v-for="(talk, index) in withPaginatedTalks" :key="index">
                  <td>
                    <input
                      :checked="talk.selected"
                      :value="talk.id"
                      name="toolboxtalks_ids[]"
                      type="checkbox"
                      aria-label="Select Talk"
                      @change="updateSelected(talk)"
                    />
                  </td>
                  <td>{{ talk.title }}</td>
                  <td>{{ formatDate(talk.created_at) }}</td>
                  <!-- <td>
										<template
											v-if="
												talk.get_assign_role.length > 0 &&
												talk.get_assign_role[0].get_role
											">
											{{ talk.get_assign_role[0].get_role.name }}
										</template>
										<template v-else> N/A </template>
									</td> -->
                  <td>
                    <template
                      v-if="
                        talk.get_assign_role.length > 0 &&
                        talk.get_assign_role[0].status === '1'
                      "
                    >
                      <button class="status-button-cls assined-talk-class">
                        Assigned
                      </button>
                    </template>
                    <template
                      v-else-if="
                        talk.get_assign_role.length > 0 &&
                        talk.get_assign_role[0].status === '2'
                      "
                    >
                      <button class="status-button-cls completed-talk-class">
                        Completed
                      </button>
                    </template>
                    <template v-else>
                      <button class="status-button-cls unassigned-talk-class">
                        Unassigned
                      </button>
                    </template>
                  </td>
                  <td>
                    {{ talk.completed_users }} out of {{ talk.total_users }}
                  </td>
                  <td>
                    <router-link
                      :to="{ name: 'detail-page', params: { id: talk.id } }"
                    >
                      <i class="fa fa-eye" title="view details"></i>
                    </router-link>
                    <a href="#"> </a>
                    <template v-if="talk.get_assign_role.length <= 0">
                      <router-link
                        :to="{ name: 'edit-toolbox', params: { id: talk.id } }"
                      >
                        <i class="fa fa-edit" title="edit"></i>
                      </router-link>
                    </template>
                    <a @click="deleteTalk(talk.id)" href="#">
                      <i class="fa fa-trash" title="delete"></i>
                    </a>
                    <a href="#">
                      <i class="fa fa-user" title="users"></i>
                    </a>
                  </td>
                </tr>
              </template>
              <template v-else>
                <tr>
                  <td colspan="7" style="text-align: center">
                    No talks available.
                  </td>
                </tr>
              </template>
            </tbody>
          </table>

          <div class="pagination">
            <button
              @click="changePage(currentPage - 1)"
              :disabled="currentPage === 1"
            >
              Previous
            </button>
            <span>Page {{ currentPage }} of {{ totalPages }}</span>
            <button
              @click="changePage(currentPage + 1)"
              :disabled="currentPage === totalPages"
            >
              Next
            </button>
          </div>
        </div>
      </div>
    </div>
    <SendModel :visible="showModal">
      <div class="modal-content">
        <h2>Assign to Users</h2>
        <div class="form-section recipients-section options-grid">
          <div class="form-group">
            <label for="department">Select Departments </label>
            <select
              class="form-control select2 roles-select"
              v-model="selectedRoles"
              data-model="selectedRoles"
              multiple
            >
              <option value="" disabled>Select Department</option>
              <option v-for="role in roles" :key="role.id" :value="role.id">
                {{ role.name }}
              </option>
            </select>
          </div>
          <div class="form-group">
            <label for="role">Select Roles </label>
            <select
              class="form-control select2 permissions-select"
              v-model="selectedPermissions"
              data-model="selectedPermissions"
              multiple
            >
              <option
                v-for="permission in permissions"
                :key="permission.id"
                :value="permission.id"
              >
                {{ permission.name }}
              </option>
            </select>
          </div>
          <div class="form-group">
            <label for="role">Select Users </label>
            <select
              class="form-control select2 users-select"
              v-model="selectedUsers"
              data-model="selectedUsers"
              multiple
            >
              <option v-for="user in users" :key="user.id" :value="user.id">
                {{ user.name }}
              </option>
            </select>
          </div>
          <div class="form-group">
            <label for="role">Due Date *</label>
            <input
              class="form-control"
              type="date"
              id="due_date"
              placeholder="Due Date"
              v-model="dueDate"
              :min="minDate"
              required
            />
          </div>
        </div>
        <div class="modal-footer">
          <button
            @click="submit"
            class="btn btn-primary assign-talk-btn"
            :disabled="isSubmitDisabled"
          >
            Submit
          </button>
          <button class="btn btn-secondary" @click="closeModal">Close</button>
        </div>
      </div>
    </SendModel>
  </div>
</template>

<script setup>
import { ref, onMounted, computed, nextTick } from "vue";
import SendModel from "../components/SendModel.vue";
import apiClient from "../router/axios";
import "jquery";
import $ from "jquery";
import Swal from "sweetalert2";
import "select2";
import "select2/dist/css/select2.min.css";
const toolboxtalks = ref([]);
const showModal = ref(false);
const currentPage = ref(1);
const itemsPerPage = 10;
const selected = ref([]);
const isAllSelected = ref(false);
const selectedRoles = ref([]);
const selectedPermissions = ref([]);
const selectedUsers = ref([]);
const roles = ref([]);
const permissions = ref([]);
const users = ref([]);
const dueDate = ref("");
const minDate = new Date().toISOString().split("T")[0];

const fetchRolesAndPermissions = async () => {
  try {
    const response = await apiClient.get("/roles-permissions-users");
    roles.value = response.data.roles;
    permissions.value = response.data.permissions;
    users.value = response.data.users;
  } catch (error) {
    console.error("Error fetching roles and permissions:", error);
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "Could not fetch roles and permissions",
    });
  }
};
// fetch toolbox talks list
const fetchToolboxTalks = async () => {
  try {
    const response = await apiClient.get("/createdByMe-talks");
    toolboxtalks.value = response.data.toolboxTalks.map((talk) => ({
      ...talk,
      selected: false,
    }));
  } catch (error) {
    console.error("Error fetching toolbox talks:", error);
  }
};

const initializeSelect2 = () => {
  nextTick(() => {
    $(".select2")
      .select2({
        placeholder: "",
        allowClear: true,
        width: "100%",
      })
      .on("change", function () {
        const selectedValues = $(this).val();
        if ($(this).hasClass("roles-select")) {
          selectedRoles.value = selectedValues || [];
        } else if ($(this).hasClass("permissions-select")) {
          selectedPermissions.value = selectedValues || [];
        } else if ($(this).hasClass("users-select")) {
          selectedUsers.value = selectedValues || [];
        }
      });
  });
};

const destroySelect2 = () => {
  $(".select2").select2("destroy");
};

onMounted(async () => {
  await fetchRolesAndPermissions();
  await fetchToolboxTalks();
});

// delete Talk
const deleteTalk = async (talkId) => {
  const confirmDelete = await Swal.fire({
    title: "Are you sure?",
    text: "This action cannot be undone!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!",
    cancelButtonText: "No, cancel!",
  });

  if (confirmDelete.isConfirmed) {
    try {
      const response = await apiClient.delete(`/delete-talk/${talkId}`);
      toolboxtalks.value = toolboxtalks.value.filter(
        (talk) => talk.id !== talkId
      );
      Swal.fire({
        icon: "success",
        title: "Deleted!",
        text: "The toolbox talk has been deleted.",
      });
    } catch (error) {
      console.error("Error deleting toolbox talk:", error);
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "Could not delete the toolbox talk. Please try again.",
      });
    }
  }
};

const formatDate = (dateString) => {
  const date = new Date(dateString);
  const options = { year: "numeric", month: "long", day: "numeric" };
  return date.toLocaleDateString("en-US", options);
};
const withPaginatedTalks = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  return toolboxtalks.value.slice(start, end);
});
const totalPages = computed(() => {
  return Math.ceil(toolboxtalks.value.length / itemsPerPage);
});
const changePage = (page) => {
  if (page < 1 || page > totalPages.value) return; // Prevent invalid pages
  currentPage.value = page;
};
const toggleSelectAll = () => {
  withPaginatedTalks.value.forEach((talk) => {
    talk.selected = isAllSelected.value;
  });
  selected.value = isAllSelected.value
    ? withPaginatedTalks.value.map((talk) => talk.id)
    : [];
};
const updateSelected = (talk) => {
  talk.selected = !talk.selected;
  if (talk.selected) {
    selected.value.push(talk.id);
  } else {
    selected.value = selected.value.filter((id) => id !== talk.id);
  }
  isAllSelected.value =
    selected.value.length === withPaginatedTalks.value.length;
};

// Delete Selected Talks
const deleteSelectedTalks = async () => {
  const selectedTalks = toolboxtalks.value
    .filter((talk) => talk.selected)
    .map((talk) => talk.id);

  if (selectedTalks.length === 0) {
    Swal.fire({
      icon: "warning",
      title: "No Selection",
      text: "Please select at least one toolbox talk.",
    });
    return;
  }
  const confirmDelete = await Swal.fire({
    title: "Are you sure?",
    text: "You want to delete Selected Talks.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!",
    cancelButtonText: "No, cancel!",
  });

  const payload = {
    toolboxtalks_ids: JSON.stringify(selectedTalks),
  };

  if (confirmDelete.isConfirmed) {
    try {
      const response = await apiClient.post("/delete-selected-talks", payload);
      Swal.fire({
        icon: "success",
        title: "Deleted!",
        text: "The selected toolbox talks have been deleted.",
      }).then((result) => {
        if (result.isConfirmed) {
          location.reload();
        }
      });
    } catch (error) {
      console.error("Error deleting toolbox talk:", error);
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "Could not delete the Selected toolbox talks. Please try again.",
      });
    }
  }
};

// assign toolbox api
const submit = async () => {
  const selectedTalks = toolboxtalks.value
    .filter((talk) => talk.selected)
    .map((talk) => talk.id);

  if (selectedTalks.length === 0) {
    Swal.fire({
      icon: "warning",
      title: "No Selection",
      text: "Please select at least one toolbox talk.",
    });
    return;
  }
  if (
    selectedRoles.value.length <= 0 &&
    selectedPermissions.value.length <= 0 &&
    selectedUsers.value.length <= 0
  ) {
    Swal.fire({
      icon: "warning",
      title: "No Selection",
      text: "Please select at least one option(Dept, Roles and Users) !",
    });
    return;
  }

  if (!dueDate.value) {
    Swal.fire({
      icon: "warning",
      title: "Missing Due Date",
      text: "Please provide a due date.",
    });
    return;
  }
  const payload = {
    toolboxtalks_ids: JSON.stringify(selectedTalks),
    due_date: dueDate.value,
  };
  if (selectedRoles.value.length > 0) {
    payload.roles = JSON.stringify(selectedRoles.value.map(Number));
  }
  if (selectedPermissions.value.length > 0) {
    payload.permissions = JSON.stringify(selectedPermissions.value.map(Number));
  }
  if (selectedUsers.value.length > 0) {
    payload.users = JSON.stringify(selectedUsers.value.map(Number));
  }
  try {
    const response = await apiClient.post("/assign-toolboxtalk", payload);
    Swal.fire({
      icon: "success",
      title: "Success",
      text: "Toolbox talks assigned successfully.",
    });
    setTimeout(() => {
      location.reload();
    }, 1500);
    // closeModal();
  } catch (error) {
    console.error("Error assigning toolbox talks:", error);
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "Could not assign toolbox talks. Please try again.",
    });
  }
};

// validation of assign toolbox using popup
const isSubmitDisabled = computed(() => {
  return (
    selectedRoles.value.length === 0 &&
    selectedPermissions.value.length === 0 &&
    selectedUsers.value.length === 0 &&
    !dueDate.value
  );
});

const openModal = () => {
  showModal.value = true;
  nextTick(() => {
    initializeSelect2();
  });
};

const closeModal = () => {
  showModal.value = false;
  selectedRoles.value = [];
  selectedPermissions.value = [];
  selectedUsers.value = [];
  $(".select2").val(null).trigger("change");
  destroySelect2();
};
</script>

<style scoped>
/* Layout */
.main-container {
  display: flex;
  flex-direction: column;
}
.title-container {
  display: flex;
  width: 100%;
  p {
    color: white;
  }
}
.list-container {
  display: flex;
  width: 100%;
}
.column-title,
.column-content {
  flex: 1;
  padding: 10px;
  text-align: left;
}

.no-data {
  flex: 1;
}

.title-container {
  background-color: #723ef5;
  font-weight: bold;
}
.title-section {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.dashboard-container {
  display: flex;
  height: 100vh;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  gap: 16px;
}

.btns-wrapper {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 10px;
}
.send-btn {
  border: 1px, solid, #723ef5;
  border-radius: 5px;
  color: #723ef5;
  text-decoration: none;
  background-color: transparent;
  height: 35px;
  width: 70px;
  cursor: pointer;
}

.btn-wrapper {
  background-color: transparent;
}
.create-btn {
  border: 1px, solid, #723ef5;
  border-radius: 5px;
  color: #723ef5;
  text-decoration: none;
  background-color: transparent;
  height: 35px;
  /* width: 70px; */
  cursor: pointer;
}

.search-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}
/* Topbar */
.topbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  height: 60px;
  background-color: white;
  padding: 0 24px;
  box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
}
.title {
  font-size: 20px;
}
.title-bold {
  color: #6b21a8;
  font-weight: 600;
}
.topbar-icons {
  display: flex;
  gap: 12px;
}
.circle-icon {
  width: 32px;
  height: 32px;
  background-color: #e0e0e0;
  border-radius: 50%;
}
.checkbox-input {
}

/* .title-container {
		display: flex;
		width: 100%;
		justify-content: space-around;
		align-items: center;
		background-color: #723ef5;
		p{
			color:white;
		}
	} */

/* .list-container{
		display: flex;
		justify-content:space-around;

	} */
/* Main Section */
.main-section {
  flex: 1;
  background-color: #f4f4f5;
  display: flex;
  flex-direction: row;
  flex-direction: column;
}
/* Content */
.content-area {
  padding: 50px 6px 0 60px;
}
.section-title {
  font-size: 18px;
  font-weight: 500;
  margin-bottom: 16px;
}
/* Card */
.card {
  background-color: white;
  padding: 20px;
  margin-top: 6px;
  border-radius: 6px;
  box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
}
/* Filter */

.search-input {
  padding: 8px;
  width: 90%;
  border: 1px solid grey;
  outline: none;
  border-radius: 4px;
}
.btn {
  padding: 8px 16px;
  margin-left: 8px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
/* a {
		background-color: #2563eb;
		color: white;
	} */
.btn-invite {
  background-color: #6b21a8;
  color: white;
  height: 40px;
}
/* Table */
.data-table {
  width: 100%;
  border-collapse: collapse;
}
.data-table th,
.data-table td {
  text-align: left;
  padding: 10px;
}
.data-table th {
  background-color: #723ef5;
  font-weight: bold;
  color: white;
  font-size: 14px;
  font-weight: 600;
}
.data-table tbody tr {
  border-bottom: 1px solid #e9ecef;
}
.no-data {
  text-align: center;
  color: #888;
  padding: 20px 0;
}
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}
.modal-actions {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
}

.modal-content {
  padding: 40px;
  border-radius: 8px;
  background-color: white;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  width: 500px;
  margin: auto;
}
.modal-content h2 {
  text-align: center;
}
h2 {
  margin-bottom: 20px;
  font-size: 24px;
}
.form-section {
  display: flex;
  flex-direction: column;
}
.form-group {
  margin-bottom: 15px;
}
label {
  margin-bottom: 5px;
  font-weight: bold;
}
.form-control {
  padding: 7px;
  border: 1px solid #ada4a4;
  border-radius: 4px;
}
.form-control:focus {
  border-color: #007bff;
  outline: none;
}
.modal-footer {
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
}
.btn {
  padding: 10px 15px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
.btn-primary {
  background-color: #007bff;
  color: white;
}
.btn-secondary {
  background-color: #6c757d;
  color: white;
}
.btn:hover {
  opacity: 0.9;
}
/* Add media queries for smaller screens */
@media (max-width: 768px) {
  .dashboard-container {
    flex-direction: column;
  }
  .filter-row {
    flex-direction: column;
    align-items: stretch;
  }
}
/* PagiNation css */
.pagination {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}
.pagination button {
  margin: 0 5px;
  padding: 5px 10px;
  border: none;
  background-color: #007bff;
  color: white;
  cursor: pointer;
}
.pagination button:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

.status-button-cls {
  padding: 5px 10px 5px 10px;
  background: #0950162e;
  border: none;
  border-radius: 50px;
  cursor: pointer;
  font-family: sans-serif;
  color: #4b4b4bf2;
}
.fa-edit,
.fa-trash,
.fa-eye,
.fa-user {
  border-radius: 100px;
  background-color: #5643b342;
  padding: 5px;
  margin-right: 2px;
}

.select2-container .select2-search--inline {
  float: left !important;
}

.status-button-cls.assined-talk-class {
  background-color: #0d6efd;
  color: white;
}

.status-button-cls.unassigned-talk-class {
  background-color: #ffc107;
  color: black;
}

.status-button-cls.completed-talk-class {
  background-color: #198754;
  color: white;
}
.delete-talk-btn {
  background-color: red;
  color: white;
  width: 161px;
  border: none;
}
</style>
