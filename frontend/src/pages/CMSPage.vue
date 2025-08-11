<template>
  <div class="dashboardbody">
    <div class="left-side-main-container">
      <div class="icons-wrapper">
        <div
          @click="this.$router.back()"
          style="cursor: pointer"
          class="iconBTN"
        >
          <i class="fa-solid fa-chevron-left"></i>
        </div>
        <a href="javascript:void(0)" class="iconBTN">
          <i class="fa-solid fa-arrow-up-right-from-square"></i>
        </a>
      </div>
      <div class="details-wrapper">
        <div class="details-main-wrapper">
          <span class="mianHeading">{{ talkDetails.title }}</span>
          <span class="createdByHeading"
            >Created by {{ talkDetails.created_by_user?.name }}
          </span>
          <span class="dateHeading">{{
            formatDate(talkDetails.created_at)
          }}</span>
          <span class="assignSpan" v-if="status == 1">Assigned</span>
          <span class="unassignSpan" v-if="status == 0">Unassigned</span>
        </div>
        <div class="description-main-wrapper">
          <span class="bottom-des">Description</span>
          <span class="bottom-description overflow-auto">{{
            talkDetails.description
          }}</span>
        </div>
      </div>
    </div>
    <div class="right-side-main-container">
      <div class="updates-main-container">
        <div class="headingContainer">
          <span>Updates & Attachments</span>
          <button v-if="status == 1" class="copy-btn">Make a copy</button>

          <div v-if="status == 0" class="optionsContainer">
            <button class="submitButton" @click="handleSubmit">
              <i
                v-if="loadingAssignUsers"
                class="pi pi-spinner animate-spin"
              ></i>
              <!-- <span v-else> Submit </span> -->
              {{ !loadingAssignUsers ? "Submit" : "" }}
            </button>
            <div class="cstmInputBox sendButtonWrapper">
              <select
                class="form-select sendButtonWrapper"
                v-model="submitType"
              >
                <option value="3">Send</option>
                <option value="1">Save in Library</option>
                <option value="2">Send & Save</option>
              </select>
            </div>
          </div>
        </div>
        <div class="options-main-container">
          <div class="commonContainer">
            <div class="uploadWrapper">
              <span class="uplaodHead">Upload Attachments</span>
              <span class="attactmentSpan"
                >{{
                  file.length + (talkDetails?.video_url?.length || 0)
                }}
                Attachments</span
              >
            </div>
          </div>
          <button
            v-if="status == 1"
            class="editButton"
            @click="showDocumentsPopup"
          >
            Preview
          </button>
          <button
            v-if="status == 0"
            class="editButton"
            @click="showDocumentsEditPopup"
          >
            Edit
          </button>
          <div class="commonContainer">
            <span class="uplaodHead">Question Sheet</span>
            <span class="attactmentSpan"
              >{{ questionSheet.length }} Questions</span
            >
          </div>
          <PreviewQuestionSheet
            v-if="status == 1"
            :questionsToAskCount="totalQuestions"
            :correctAnswersRequiredCount="correctAnswers"
            :questions="questionSheet"
          />
          <EditQuestionSheet
            v-if="status == 0"
            :initialQuestionsToAskCount="totalQuestions"
            :initialCorrectAnswersRequiredCount="correctAnswers"
            :questions="questionSheet"
            :handleDeleteQuestion="deleteQuestion"
            :toolboxTalkId="this.$route.params.id"
            :getDetailsToolboxTalk="getDetailsToolboxTalk"
          />
        </div>
      </div>
      <div class="attendes-main-wrapper" v-if="status == 0">
        <!-- <div class="row py-2 cstmFormRow border-0"> -->
        <div class="row py-2 cstmFormRow border-0">
          <div class="cstmInputBox max-w-[200px]!">
            <label for="Text1" class="form-label font-semibold! text-black!"
              >Attendees</label
            >
          </div>

          <div class="flex-1">
            <div class="cstmformcheck">
              <label class="form-check-label" for="selectAll">
                Select All Users
              </label>
              <input
                class="form-check-input ms-2 rounded-full!"
                type="checkbox"
                id="selectAll"
                v-model="selectAll"
              />
            </div>
          </div>
        </div>
        <div class="line-break opacity-20"></div>

        <div class="row py-2 cstmFormRow border-0 flex-nowrap">
          <div class="cstmInputBox max-w-[200px]!">
            <label for="Text1" class="form-label">Select Department</label>
          </div>

          <div class="flex-1">
            <DropdownWithSearch
              anchorClass="bg-[#ededed]"
              :options="
                departments.sort((a, b) => a.name.localeCompare(b.name))
              "
              v-model="selectedDepartment"
              :disabled="selectAll"
              placeholder="Choose a responsible person or team"
            />
          </div>
        </div>
        <div class="flex gap-1" v-if="selectedDepartment.length > 0">
          <span
            class="selected-dept-span w-fit"
            v-for="department in selectedDepartment"
            :key="department.name"
          >
            {{ department.name }}
            <button
              type="button"
              aria-label="Remove"
              @click="removeDepartment(department)"
              class="dept-remove-btn"
            >
              X
            </button>
          </span>
        </div>

        <div class="line-break opacity-20"></div>

        <div class="row py-2 cstmFormRow border-0">
          <div class="cstmInputBox max-w-[200px]!">
            <label for="Text1" class="form-label">Select Role</label>
          </div>

          <div class="flex-1">
            <DropdownWithSearch
              anchorClass="bg-[#ededed]"
              :options="roles.sort((a, b) => a.name.localeCompare(b.name))"
              v-model="selectedRole"
              :disabled="selectAll"
              placeholder="Choose a responsible person or team"
            />
          </div>
        </div>

        <div class="flex gap-1" v-if="selectedRole.length > 0">
          <span
            class="selected-dept-span w-fit"
            v-for="role in selectedRole"
            :key="role.id"
          >
            {{ role.name }}
            <button
              type="button"
              aria-label="Remove"
              @click="removeRole(role)"
              class="dept-remove-btn"
            >
              X
            </button>
          </span>
        </div>

        <div class="line-break opacity-20"></div>

        <div class="row py-2 cstmFormRow border-0">
          <div class="cstmInputBox max-w-[200px]!">
            <label for="Text1" class="form-label">Users</label>
          </div>

          <div class="flex-1">
            <DropdownWithSearch
              anchorClass="bg-[#ededed]"
              :options="users.sort((a, b) => a.name.localeCompare(b.name))"
              v-model="selectedUsers"
              :disabled="selectAll"
              placeholder="Choose a responsible person or team"
            />
          </div>
        </div>
        <div class="flex gap-1" v-if="selectedUsers.length > 0">
          <span
            class="selected-dept-span w-fit"
            v-for="user in selectedUsers"
            :key="user.id"
          >
            {{ user.name }}
            <button
              type="button"
              aria-label="Remove"
              @click="removeUser(user)"
              class="dept-remove-btn"
            >
              X
            </button>
          </span>
        </div>

        <div class="line-break opacity-20"></div>
      </div>
      <div class="tableWrapperBox sign-off-wrapper mt-8" v-if="status == 1">
        <div class="sectionheadingbox p-2">
          <h3>Sign-Off Sheet</h3>
        </div>
        <div class="table-responsive cornerRadiusTablebox sign-off-inside">
          <table class="table mb-0">
            <thead class="position-sticky top-0 position-indexing">
              <tr>
                <th>Name</th>
                <th width="150">Date</th>
                <th width="150">Time</th>
                <th width="150">Result</th>
                <th width="150">Attempts</th>
                <th width="120">Completed</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="signOff in signOffSheet" :key="signOff.id">
                <td>
                  <span>{{ signOff.name }}</span>
                </td>
                <td>
                  <span>{{
                    signOff.date
                      ? new Date(signOff.date).toLocaleDateString("en-GB")
                      : "N/A"
                  }}</span>
                </td>
                <td>
                  <span>{{ signOff.time || "N/A" }}</span>
                </td>
                <td>
                  <span>{{ signOff.result.result }}</span>
                  <span
                    >&nbsp;<i class="fa fa-file-text cursor-pointer"></i
                  ></span>
                </td>
                <td>
                  <span>{{ signOff.attempt || "N/A" }}</span>
                </td>
                <td>
                  <input
                    class="form-check-input rounded-full!"
                    style="opacity: 1"
                    type="checkbox"
                    :checked="signOff.status === 'Completed'"
                    disabled
                  />
                </td>
              </tr>
              <tr v-if="!signOffSheet || signOffSheet.length === 0">
                <td colspan="6" style="text-align: center; padding: 20px">
                  No sign-off data available.
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- Edit Popup -->
    <div
      class="fixed inset-0 bg-black/75 z-30"
      v-if="documentEditPopup"
      @click.self="closeEditPopup"
    >
      <div class="upload-main-container-popup">
        <div class="popup-content">
          <div class="upload-first-container">
            <div class="main-heading-wrapper">
              <span class="main-heading-span">Video</span>
            </div>
            <div
              class="bg-[#e3e3e3] flex gap-[12px] mx-[12px] my-[12px] pr-[12px] rounded"
            >
              <!-- <span>Video Link</span> -->
              <input
                type="text"
                class="form-control custom_inputbox bg-transparent disabled:opacity-50!"
                placeholder="Video Link"
                v-model="videoLink"
                :disabled="file.length"
              />
              <!-- <span class="url-span">{{ videoLink }}</span> -->
              <div class="flex gap-2">
                <button
                  v-if="initialVideoLink !== videoLink"
                  @click="handleUpdateVideoLink"
                  class="trash-button"
                  type="button"
                >
                  <i
                    v-if="loadingUpdateVideo"
                    class="pi pi-spinner animate-spin"
                  ></i>
                  <i v-else class="pi pi-check"></i>
                </button>
                <button
                  v-if="videoLink.length"
                  class="trash-button"
                  @click="removeVideoLink()"
                  type="button"
                >
                  <i class="pi pi-times"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="flex items-center">
            <hr class="flex-1" />
            <span class="mx-2">OR</span>
            <hr class="flex-1" />
          </div>
          <div>
            <div class="main-heading-wrapper">
              <span class="main-heading-span">Files</span>
            </div>
            <div class="pdf_flex">
              <div class="pdf-wrapper">
                <div class="doc-span-wrapper check_flex">
                  <div
                    v-for="(doc, index) in file"
                    :key="index"
                    style="display: flex; align-items: flex-start; gap: 12px"
                  >
                    <input
                      type="checkbox"
                      class="check_box form-check"
                      v-model="doc.selected"
                    />
                    <div class="document_check">
                      <a
                        :href="doc.file_url"
                        target="_blank"
                        rel="noopener noreferrer"
                      >
                        <img src="/images/PDF.png" class="document-img" />
                      </a>
                      <span>{{ doc.file_name }}</span>
                    </div>
                  </div>
                </div>
              </div>
              <input
                type="file"
                @change="handleFileChange"
                ref="fileInput"
                class="hidden-input"
                multiple
              />
              <button
                v-if="status == 0"
                @click="triggerFileInput"
                :disabled="videoLink.length"
                class="bg-[#e3e3e3] py-1 px-2 rounded text-[12px]! w-[98px] disabled:opacity-50"
                type="button"
              >
                <i
                  v-if="loadingUploadAttachments"
                  class="pi pi-spinner animate-spin"
                ></i>
                <div v-else class="flex gap-2 items-center whitespace-nowrap">
                  <i class="pi pi-upload"></i>
                  Upload File
                </div>
              </button>
              <button
                v-if="status == 0 && file.length > 0"
                class="trash-button ml-2! mt-[2px]!"
                @click="removeAttachments()"
                type="button"
              >
                <i
                  v-if="loadingRemoveAttachments"
                  class="pi pi-spinner animate-spin"
                ></i>
                <i v-else class="pi pi-trash"></i>
              </button>
            </div>
          </div>
        </div>
        <div class="text-end end_btn">
          <button type="button" @click="closeEditPopup" class="cancel-btn">
            Cancel
          </button>
        </div>
      </div>
    </div>
    <!-- Preview Popup -->
    <div
      class="upload-main-container-popup"
      v-if="documentPopup"
      @click.self="closePopup"
    >
      <div class="popup-content">
        <div class="upload-first-container">
          <div class="main-heading-wrapper">
            <span class="main-heading-span">Video</span>
          </div>
          <div class="link-wrapper my-[12px] mx-[12px] mb-[24px]">
            <a
              v-if="videoLink"
              style="text-decoration: none"
              :href="videoLink"
              target="_blank"
            >
              {{ videoLink }}
            </a>
            <span v-else class="text-[#bdbdbd]">No video link...</span>
          </div>
        </div>
        <div>
          <div class="main-heading-wrapper">
            <span class="main-heading-span">Files</span>
          </div>
          <div class="pdf_flex">
            <div class="pdf-wrapper">
              <div class="doc-span-wrapper check_flex">
                <div v-for="doc in file" class="document_check">
                  <a
                    :href="doc.file_url"
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    <img src="/images/PDF.png" class="document-img" />
                  </a>
                  <span
                    style="
                      overflow: hidden;
                      width: 120px;
                      text-overflow: ellipsis;
                      font-size: 12px;
                    "
                    >{{ doc.file_name }}</span
                  >
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="text-end end_btn">
        <button type="button" @click="closePopup" class="backBtnEnd">
          Cancel
        </button>
      </div>
    </div>
  </div>
  <!-- </div> -->
  <DialogRoot>
    <DialogPortal>
      <DialogOverlay class="fixed inset-0 bg-black/50 z-40" />
      <DialogContent
        class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] p-[20px] bg-white outline-none z-50 rounded-2xl"
      >
        <div
          class="w-full bg-[#f46c4d] h-[45px] rounded-full flex items-center p-3 font-bold"
        >
          <span> Action Required </span>
        </div>
        Hello
      </DialogContent>
    </DialogPortal>
  </DialogRoot>
</template>

<script>
import {
  DialogContent,
  DialogOverlay,
  DialogPortal,
  DialogRoot,
} from "radix-vue";
import apiClient from "../router/axios";
import Swal from "sweetalert2";
import EditQuestionSheet from "../components/dialogs/EditQuestionSheet.vue";
import PreviewQuestionSheet from "../components/dialogs/PreviewQuestionSheet.vue";
import axios from "axios";
import DropdownWithSearch from "../components/DropdownWithSearch.vue";
import { inject } from "vue";

export default {
  setup() {
    const showAlert = inject("showAlert");
    return { showAlert };
  },
  data() {
    return {
      isAlertVisible: false,

      loadingUpdateVideo: false, // loading state for update video API
      loadingUploadAttachments: false, // loading state for upload attachments API
      loadingRemoveAttachments: false, // loading state for remove attachments API
      loadingDeleteQuestion: false, // loading state for delete question API
      loadingUpdateQuestions: false, // loading state for update questions API
      loadingAssignUsers: false, // loading state for (assign users / submit) API

      selectAll: false, // state for select all checkbox

      submitType: "3", // submit type, i.e., 1 for Save in Library, 2 for Send & Save, 3 for Send
      newQuestions: [], // state to store added questions
      questionSheet: [], // state to store initial questions data from API
      dropDownOpenDepartment: false,
      dropDownOpenRole: false,
      dropDownOpenUsers: false,
      selectedDepartment: [],
      selectedUsers: [],
      file: [],
      departments: [],
      roles: [],
      users: [],
      signOffSheet: [],
      initialVideoLink: "",
      videoLink: "",
      status: "",
      talkDetails: {},
      selectedRole: [],
      talkId: "",
      documentPopup: false,
      documentEditPopup: false,
      errorPop: false,
      totalQuestions: "",
      correctAnswers: "",
      meta: {
        totalQuestions: "",
        passMark: "",
      },
      attemptQuestions: "",
      questions: [
        {
          text: "",
          options: ["", "", "", ""],
          correctAnswer: null,
        },
      ],
    };
  },
  mounted() {
    this.getDetailsToolboxTalk();
    this.getDepartments();
    this.getRoles();
    this.getUsers();
  },
  watch: {
    selectAll: {
      handler(val) {
        if (!val) return;
        this.selectedDepartment = [];
        this.selectedRole = [];
        this.selectedUsers = [];
      },
    },
  },
  methods: {
    validationCheck() {
      if (
        this.talkDetails.video_url.length === 0 &&
        this.talkDetails.file_data.length === 0
      ) {
        this.showAlert({
          title: "Validation Error",
          description: "Please provide either video URL or PDF.",
          type: "error",
        });
        return false;
      }
      if (
        (this.submitType === "2" || this.submitType === "3") &&
        !this.selectAll &&
        !this.selectedDepartment.length &&
        !this.selectedRole.length &&
        !this.selectedUsers.length
      ) {
        this.showAlert({
          title: "Validation Error",
          description: "Please select at least one Department, Role, or User.",
          type: "error",
        });
        return false;
      }
      return true;
    },
    async handleSubmit() {
      try {
        if (!this.validationCheck()) return;
        const uniqueUsers = new Map();

        if (this.selectAll) {
          this.users.forEach((user) => {
            uniqueUsers.set(user.id, {
              select_user_id: user.id,
              user_name: user.name,
            });
          });
        } else {
          const users = await this.getUsersByDepartmentsAndRoles();
          this.selectedUsers.forEach((user) =>
            uniqueUsers.set(user.id, {
              select_user_id: user.id,
              user_name: user.name,
            })
          );
          users.forEach((user) =>
            uniqueUsers.set(user.id, {
              select_user_id: user.id,
              user_name: user.name,
            })
          );
        }

        this.loadingAssignUsers = true;
        await apiClient.post(`/update-new-assigned-toolbox`, {
          toolbox_talk_id: this.$route.params.id,
          select_user_detail: JSON.stringify(Array.from(uniqueUsers.values())),
          isLibrary: this.submitType,
        });
        this.getDetailsToolboxTalk();
        this.showAlert({
          title: "Success",
          description: "Toolbox Talk assigned successfully.",
          type: "success",
        });
      } catch (err) {
        console.log(err);
      }
      this.loadingAssignUsers = false;
    },
    toggleUsersSelection(user) {
      if (this.isSelectedUsers(user)) {
        this.selectedUsers = this.selectedUsers.filter(
          (curr) => curr.id !== user.id
        );
      } else {
        this.selectedUsers.push(user);
      }
    },

    isSelectedUsers(user) {
      return !!this.selectedUsers.find((curr) => curr.id === user.id);
    },

    removeUser(userToRemove) {
      this.selectedUsers.filter((curr) => curr.id !== userToRemove.id);
    },
    async removeAttachments() {
      const isAnySelected = this.file.some((doc) => doc.selected);
      if (!isAnySelected) {
        alert("Minimum one PDF or one checkbox is required to select");
        return;
      }

      try {
        this.loadingRemoveAttachments = true;
        const selectedFiles = this.file.filter((doc) => doc.selected);

        await apiClient.post(`/delete-url-pdf`, {
          toolbox_talk_id: this.$route.params.id,
          attachment_id: selectedFiles.map((doc) => doc.id),
        });
        this.getDetailsToolboxTalk();
      } catch (err) {
        console.log(err);
        Swal.fire({
          icon: "error",
          title: "Error",
          text: err.response.data.message,
        });
      } finally {
        this.loadingRemoveAttachments = false;
      }
    },
    removeVideoLink() {
      this.videoLink = "";
    },
    toggleDropdownRole() {
      this.dropDownOpenRole = !this.dropDownOpenRole;
    },

    closeDropdownRole() {
      this.dropDownOpenRole = false;
    },
    isSelectedDepartment(dept) {
      return !!this.selectedDepartment.find((curr) => curr.id === dept.id);
    },
    toggleRoleSelection(role) {
      if (this.isSelectedRole(role)) {
        this.selectedRole = this.selectedRole.filter(
          (curr) => curr.id !== role.id
        );
      } else {
        this.selectedRole.push(role);
      }
    },
    closeDropdownUsers() {
      this.dropDownOpenUsers = false;
    },
    isSelectedRole(role) {
      return !!this.selectedRole.find((curr) => curr.id === role.id);
    },
    removeRole(roleToRemove) {
      this.selectedRole.filter((curr) => curr.id !== roleToRemove.id);
    },
    toggleDepartmentSelection(dept) {
      if (this.isSelectedDepartment(dept)) {
        this.selectedDepartment = this.selectedDepartment.filter(
          (curr) => curr.id !== dept.id
        );
      } else {
        this.selectedDepartment.push(dept);
      }
    },
    toggleDropdownDepartment() {
      this.dropDownOpenDepartment = !this.dropDownOpenDepartment;
    },
    removeDepartment(departmentToRemove) {
      this.selectedDepartment = this.selectedDepartment.filter(
        (curr) => curr.id !== departmentToRemove.id
      );
    },

    closeDropdownDepartment() {
      this.dropDownOpenDepartment = false;
    },
    toggleDropdownUsers() {
      this.dropDownOpenUsers = !this.dropDownOpenUsers;
    },
    // Get Departments from CMS API
    async getDepartments() {
      try {
        const { data } = await axios.get(
          `${import.meta.env.VITE_APP_CMS_BASE_URL}/api/dev-hub/departments`,
          {
            headers: {
              Authorization: `Bearer ${
                import.meta.env.VITE_APP_CMS_ACCESS_TOKEN
              }`,
            },
          }
        );
        this.departments = data.entities.map((dept) => ({
          id: dept.properties.id,
          name: dept.properties.name,
        }));
      } catch (err) {}
    },
    // Get Roles from CMS API
    async getRoles() {
      try {
        const { data } = await axios.get(
          `${import.meta.env.VITE_APP_CMS_BASE_URL}/api/dev-hub/roles`,
          {
            headers: {
              Authorization: `Bearer ${
                import.meta.env.VITE_APP_CMS_ACCESS_TOKEN
              }`,
            },
          }
        );
        this.roles = data.entities.map((role) => ({
          id: role.properties.id,
          name: role.properties.name,
        }));
      } catch (err) {}
    },
    // Get Departments from CMS API
    async getUsers() {
      try {
        const { data } = await axios.get(
          `${import.meta.env.VITE_APP_CMS_BASE_URL}/api/dev-hub/users`,
          {
            headers: {
              Authorization: `Bearer ${
                import.meta.env.VITE_APP_CMS_ACCESS_TOKEN
              }`,
            },
          }
        );
        this.users = data.entities.map((user) => ({
          id: user.properties.id,
          name: user.properties.name,
        }));
      } catch (err) {}
    },
    // Get Users by department and Roles from CMS API
    async getUsersByDepartmentsAndRoles() {
      if (!this.selectedDepartment.length && !this.selectedRole.length)
        return [];
      const params = new URLSearchParams();
      params.append(
        "department_id",
        this.selectedDepartment.map((dept) => dept.id).join(",")
      );
      params.append(
        "role_id",
        this.selectedRole.map((role) => role.id).join(",")
      );

      const { data } = await axios.get(
        `${import.meta.env.VITE_APP_CMS_BASE_URL}/api/dev-hub/users`,
        {
          params,
          headers: {
            Authorization: `Bearer ${
              import.meta.env.VITE_APP_CMS_ACCESS_TOKEN
            }`,
          },
        }
      );
      return (
        data?.entities?.map((user) => ({
          id: user.properties.id,
          name: user.properties.name,
        })) || []
      );
    },

    async getDetailsToolboxTalk() {
      const id = this.$route.params.id;
      try {
        const response = await apiClient.get(`/toolbox-talk/${id}`);
        this.talkDetails = response.data.talkDetails;
        this.videoLink = this.talkDetails.video_url?.[0]?.video_url || "";
        this.initialVideoLink =
          this.talkDetails.video_url?.[0]?.video_url || "";
        this.status = response.data.talkDetails.status;
        this.file = this.talkDetails.file_data;
        this.correctAnswers = this.talkDetails.number_of_correct_answer_to_pass;
        this.totalQuestions = this.talkDetails.number_of_questions_to_ask;
        this.questionSheet = this.talkDetails.questions.map((ques) => ({
          id: ques.id,
          name: ques.name,
          options: ques.options.map((opt) => ({
            id: opt.id,
            name: opt.name,
            correct_answer: ques.correct_answer?.[0]?.id === opt.id ? "1" : "0",
          })),
        }));
        this.signOffSheet = this.talkDetails.assigned_users;
      } catch (error) {
        console.error("Error fetching toolbox talk:", error);
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "Could not fetch toolbox talk details",
        });
      }
    },

    goBackEdit() {
      this.documentEditPopup = false;
    },
    showDocumentsPopup() {
      this.documentPopup = true;
    },
    showDocumentsEditPopup() {
      this.documentEditPopup = true;
    },
    addNewQuestion() {
      if (this.questionSheet.length + this.newQuestions.length < 10) {
        this.newQuestions.push({
          name: "",
          options: ["", "", "", ""],
          correctAnswer: "",
        });
        this.$nextTick(() => {
          if (
            this.$refs.questionsContainer &&
            this.$refs.questionsContainer.length > 0
          ) {
            const lastQuestionElement =
              this.$refs.questionsContainer[
                this.$refs.questionsContainer.length - 1
              ];

            lastQuestionElement.scrollIntoView({
              behavior: "smooth",
              block: "end",
            });
          }
        });
      }
    },
    async handleUpdateQuestions() {
      try {
        this.loadingUpdateQuestions = true;
        await apiClient.post("/update-questions", {
          toolbox_talk_id: this.$route.params.id,
          questions: JSON.stringify(this.questionSheet),
          new_questions: JSON.stringify(this.newQuestions),
          attemptQuestions: this.totalQuestions,
          number_of_correct_answer_to_pass: this.correctAnswers,
        });
        this.getDetailsToolboxTalk();
      } catch (err) {
        console.log(err);
      } finally {
        this.loadingUpdateQuestions = false;
      }
    },
    async deleteQuestion(id) {
      try {
        this.loadingDeleteQuestion = true;
        await apiClient.get(`/delete-question/${id}`);
        this.getDetailsToolboxTalk();
      } catch (err) {
        console.error(err);
      } finally {
        this.loadingDeleteQuestion = false;
      }
    },
    handleCorrectAnswerUpdate(e, idx) {
      this.questionSheet[idx].options = this.questionSheet[idx].options.map(
        (ques) => ({
          ...ques,
          correct_answer: ques.id == e.target.value ? "1" : "0",
        })
      );
      console.log(this.questionSheet);
    },
    closePopup() {
      this.documentPopup = false;
    },
    closeEditPopup() {
      this.documentEditPopup = false;
    },
    addQuestion() {
      this.questions.push({
        questionText: "",
        options: [
          { label: "A", text: "" },
          { label: "B", text: "" },
          { label: "C", text: "" },
          { label: "D", text: "" },
        ],
        correctAnswer: "",
      });
    },
    removeQuestion(index) {
      if (this.newQuestions.length > 1) {
        this.newQuestions.splice(index, 1);
      }
    },
    validateSelection() {
      if (this.totalQuestions && this.correctAnswers) {
        if (parseInt(this.correctAnswers) > parseInt(this.totalQuestions)) {
          this.errorPop = true;
          this.correctAnswers = "";
        }
      }
    },
    scrollToLatestQuestion() {
      const container =
        this.$refs.questionsContainer[this.questions.length - 1];
      if (container) {
        container.scrollIntoView({ behavior: "smooth" });
      }
    },
    formatDate(dateString) {
      const date = new Date(dateString);
      const day = String(date.getDate()).padStart(2, "0");
      const month = String(date.getMonth() + 1).padStart(2, "0");
      const year = date.getFullYear();
      return `${day}/${month}/${year}`;
    },
    async handleFileChange(e) {
      try {
        this.loadingUploadAttachments = true;
        await apiClient.post(`/update-attachments`, {
          toolbox_talk_id: this.$route.params.id,
          pdf_file: e.target.files,
        });
        this.$refs.fileInput.value = "";
        this.getDetailsToolboxTalk();
      } catch (err) {
        console.log(err);
      } finally {
        this.loadingUploadAttachments = false;
      }
    },
    triggerFileInput() {
      this.$refs.fileInput.click();
    },

    async handleUpdateVideoLink() {
      try {
        this.loadingUpdateVideo = true;
        const formData = new FormData();
        formData.append("toolbox_talk_id", this.$route.params.id);
        formData.append("resource_url", this.videoLink);
        await apiClient.post(`/update-attachments`, formData);
        this.getDetailsToolboxTalk();
      } catch (err) {
        console.log(err);
        Swal.fire({
          icon: "error",
          title: "Error",
          text: err.response.data.message,
        });
        this.videoLink = this.initialVideoLink;
      } finally {
        this.loadingUpdateVideo = false;
      }
    },
  },
};
</script>

<style scoped>
.end_btn {
  display: flex;
  justify-content: flex-end;
  gap: 20px;
  padding: 20px;
}

.page-content .upload-main-container-popup {
  height: auto;
}

.pdf_flex {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-top: 20px;
}

.doc-span-wrapper.check_flex {
  margin-left: 20px;
  gap: 20px;
  max-width: 700px;
  overflow-x: auto;
}

.pdf_flex .pdf-wrapper {
  flex: 1;
  padding-top: unset;
  margin-right: 12px;
}

.tableWrapperBox {
  flex: 1;
  overflow: hidden;
}

.headingContainer span {
  font-size: 18px;
  font-weight: bold;
}

.dashboardbody {
  height: 1200px;
  background-color: #eeeeee;
  overflow: hidden;
  border-radius: 15px;
  display: flex;
  gap: 15px;
  flex-direction: row;
  padding-bottom: 20px;
}

.left-side-main-container {
  display: flex;
  flex-direction: column;
  width: 25%;
  height: 100%;
  border-radius: 25px;
  background-color: white;
}

.right-side-main-container {
  background-color: white;
  width: 75%;
  border-radius: 25px;
  /* height: 940px; */
  height: 100%;

  border-radius: 25px;
  padding-bottom: 10px;
  padding-top: 20px;
  padding-left: 20px;
  padding-right: 20px;

  display: flex;
  flex-direction: column;
}

.icons-wrapper {
  display: flex;
  height: 75px;
  justify-content: space-between;
  align-items: center;
  padding-left: 20px;
  padding-right: 20px;
}

.details-wrapper {
  /* height: 850px; */
  padding: 0 15px 15px;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.details-main-wrapper {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: space-between;
}

.description-main-wrapper {
  background-color: #f4f4f4;
  display: flex;
  width: 100%;
  flex-direction: column;
  height: 210px;
  border-radius: 10px;
  align-self: anchor-center;
  padding: 10px;
  gap: 30px;
}

.mianHeading {
  font-size: xx-large;
  font-weight: bold;
  color: #000000;
  max-width: 100%;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
  padding: 0 12px;
}

.createdByHeading {
  color: #323232;
}

.dateHeading {
  color: #828282;
}

.assignSpan {
  height: 22px;
  width: 80px;
  background-color: #e3f2ea;
  color: #14ae5c;
  font-size: smaller;
  padding-left: 15px;
  border-radius: 5px;
}

.unassignSpan {
  height: 22px;
  width: 20%;
  background-color: #fbf2e5;
  color: #ffa629;
  font-size: smaller;
  /* padding-left: 15px; */
  border-radius: 5px;
  display: flex;
  justify-content: center;
}

.bottom-des {
  color: #666666;
}

.bottom-description {
  color: #323232;
}

.headingContainer {
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: space-between;
  height: 58px;
}

.main-pop-msg {
  width: 760px;
  height: 158px;
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.optionsContainer {
  display: flex;
  flex-direction: row;
  width: 230px;
  height: 30px;
  gap: 10px;
}

.submitButton {
  height: 30px;
  width: 65px;
  color: white;
  border-radius: 5px;
  border: none;
  outline: none;
  background-color: #0d99ff;
  display: flex;
  justify-content: center;
  align-items: center;
}

.sendButtonWrapper {
  height: 30px;
  width: 136px;
  border: none;
  background-color: #e1e1e1;
  color: #9e9e9e;
  border-radius: 5px;
  cursor: pointer;
}

.options-main-container {
  gap: 32px;
  display: flex;
  flex-direction: column;
  justify-content: space-around;
}

.editButton {
  padding: 0 16px;
  width: fit-content;
  height: 30px;
  background-color: #3cacfe;
  color: white;
  border: none;
  outline: none;
  border-radius: 5px;
  display: flex;
  justify-content: center;
  align-items: center;
  margin-left: 10px;
}

.commonContainer {
  height: 58px;
  background-color: #f2f2f2;
  padding-left: 15px;
  padding-right: 15px;
  color: black;
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
  display: flex;
  gap: 12px;
  align-items: center;
}

.hidden-input {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
}

.uplaodHead {
  color: #323232;
}

.attactmentSpan {
  color: #808080;
  background-color: #e7e7e7;
  height: 22px;
  width: 100px;
  border-radius: 10px;
  font-size: small;
  align-items: center;
  display: flex;
  justify-content: center;
}

.uploadWrapper {
  display: flex;
  flex-direction: row;
  gap: 10px;
}

.backBtnEnd {
  /* position: absolute;  */
  bottom: 15px;
  right: 22px;
  display: flex;
  padding: 0 16px;
  justify-content: center;
  border: none;
  border-radius: 5px;
  font-size: 18px;
  font-weight: bold;
  color: #666;
  height: 38px;
  min-width: 161px;
  text-align: center;
  align-items: center;
  background-color: #af9a9a;
}

.url-span {
  width: 612px;
}

.doc-span-wrapper {
  display: flex;
  align-items: flex-start;
  gap: 10px;
}

.error-pop {
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

.attendes-main-wrapper {
  position: relative;
  margin-top: 2rem;
  display: flex;
  flex-direction: column;
  padding-top: 3%;
  gap: 13px;
  overflow-y: auto;
  overflow-x: hidden;
  height: calc(100vh - 413px);
}

.popup-overlay {
  position: fixed;
  width: 800px;
  height: 590px;
  border-radius: 15px;
  z-index: 9;
  align-self: anchor-center;
  justify-self: anchor-center;
  padding-left: 20px;
  padding-top: 20px;
  background-color: white;
  border: 0.5px solid grey;
}

.first-container {
  height: 164px;
  width: 760px;
  position: relative;
}

.copy-btn {
  color: white;
  background-color: #3cacfe;
  outline: none;
  border: none;
  border-radius: 5px;
  height: 40px;
  width: 90px;
  font-size: small;
}

.main-heading-wrapper {
  background-color: #afb0f5;
  border-radius: 25px;
  height: 45px;
  display: flex;
  align-items: center;
  padding-left: 10px;
  color: #323232;
  font-weight: bold;
}

.ques-main-wrapper {
  display: flex;
  flex-direction: column;
  padding-left: 10px;
  height: 104px;
}

.input-ques-wrapper {
  display: flex;
  height: 52px;
  align-items: center;
}

.ques-span {
  width: 60%;
  color: #a3a3a3;
}

.main-heading-span,
.main-heading-wrapper {
  font-weight: bold;
  font-size: 16px;
  padding-left: 10px;
}

.main-heading-wrapper span {
  padding-left: 10px;
}

.ques-input {
  width: 39%;
  border: none;
  border-radius: 5px;
  height: 26px;
  outline: none;
  background-color: #eeeeee;
  color: #a7a7a7;
}

.line-break {
  min-height: 1px;
  background-color: grey;
  width: 100%;
}

.second-container {
  width: 760px;
  height: 255px;
}

.ques-container {
  height: 210px;
  background-color: white;
  display: flex;
  flex-direction: column;
  padding-left: 10px;
}

.question-wrapper {
  display: flex;
  height: 35px;
  align-items: center;
}

.trash-button {
  border: none;
  background: none;
}

.question-span {
  width: 200px;
  color: #a3a3a3;
}

.question-input {
  border: none;
  outline: none;
  background-color: #eeeeee;
  border-radius: 5px;
  width: 500px;
  padding-left: 5px;
  color: #a3a3a3;
  height: 26px;
}

.add-ques {
  border: none;
  outline: none;
  width: 143px;
  height: 35px;
  cursor: pointer;
  margin-top: 10px;
  color: #a3a3a3;
  background: none;
}

.button-wrapper {
  width: 760px;
  height: 38px;
  display: flex;
  justify-content: end;
  padding-right: 15px;
  gap: 10px;
  margin-top: 30px;
}

.cancel-btn {
  height: 38px;
  width: 161px;
  border-radius: 10px;
  border: none;
  outline: none;
  background-color: #bdbdbd;
  color: #717171;
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
}

.go-back-btn-wrapper {
  display: flex;
  justify-content: end;
}

.ques-scroll-wrapper {
  height: 210px;
  overflow-y: scroll;
}

.sign-off-wrapper {
  height: 71%;
  /* height: 580px; */
}

input.check_box.form-check {
  width: 20px;
}

.create-btn {
  height: 38px;
  width: 244px;
  border-radius: 10px;
  border: none;
  outline: none;
  background-color: #6366f1;
  color: white;
}

.go-back-btn {
  background: #bdbdbd;
  border: none;
  width: 172px;
  height: 38px;
  border-radius: 5px;
}

.upload-main-container-popup {
  position: fixed;
  width: 800px;
  height: 393px;
  border-radius: 15px;
  z-index: 9;
  align-self: anchor-center;
  justify-self: anchor-center;
  padding: 20px;
  background-color: white;
  border: 0.5px solid grey;
}

.cursor-pointer {
  cursor: pointer;
}

.upload-first-container {
  width: 760px;
  position: relative;
}

.placeholder {
  /* color:#8f8f8f; */

  flex-grow: 1;
  background: none;
  cursor: pointer;
}

.pdf-wrapper {
  display: flex;
  gap: 20px;
  padding-top: 10px;
  padding-bottom: 10px;
  overflow-x: auto;
}

.document-img {
  height: 150px;
}

.selected-display {
  display: flex;
  align-items: center;
  border: none;
  border-radius: 4px;
  padding: 8px 12px;
  cursor: pointer;
  height: 35px;
  background-color: #ededed;
  position: relative;
  box-sizing: border-box;
  transition: border-color 0.2s, box-shadow 0.2s;
  font-size: 14px;
  font-weight: 400;
}

.selected-display.is-open {
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
}

.dept-remove-btn {
  background: none;
  border: none;
  color: #0d99ff;
}

.options-dropdown {
  position: absolute;
  width: 42.6%;
  border: none;
  border-top: none;
  border-radius: 0 0 4px 4px;
  background-color: white;
  z-index: 1000;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  max-height: 200px;
  overflow-y: auto;
  box-sizing: border-box;
}

.options-dropdown ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.options-dropdown li {
  padding: 10px 12px;
  cursor: pointer;
  transition: background-color 0.2s, color 0.2s;
}

.options-dropdown li:hover {
  background-color: #f0f0f0;
}

.options-dropdown li.is-selected {
  font-weight: bold;
}

.selected-dept-span {
  background: #cbe7fb;
  padding: 4px 12px;
  border-radius: 20px;
  color: #0d99ff;
  font-size: small;
  display: flex;
  gap: 8px;
  align-items: center;
  height: 25px;
}

.document_check {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 10px;
}

.dashboardbody {
  height: calc(100vh - 113px);
}

.sign-off-wrapper[data-v-713e32f8] {
  height: calc(100vh - 499px);
}

table.table thead.position-indexing {
  z-index: 9;
}

@media only screen and (min-width: 1024px) and (max-width: 1800px) {
  .dashboardbody {
    height: calc(100vh - 113px);
    overflow: hidden !important;
  }

  .left-side-main-container {
    overflow: hidden;
  }

  .right-side-main-container {
    overflow: hidden;
  }
}

.correct-option {
  background-color: #d4edda;
  border: 1px solid #c3e6cb;
}

.button-wrapper.edit-questions {
  margin-top: 60px;
}

input.form-control.custom_inputbox {
  border: unset;
  padding-top: 10px;
}

input.form-control.custom_inputbox:focus {
  box-shadow: unset;
  outline: unset;
}

.table-responsive.sign-off-inside {
  height: calc(100vh - 584px);
  padding-bottom: 12px;
}
</style>
