<template>
  <div class="dashboardbody" style="padding: 0px 15px 20px 15px">
    <form
      class="bg-[#FAFAFA] rounded-[20px] pb-4 overflow-hidden"
      style="height: calc(100vh - 115px)"
      @submit.prevent="submitData"
      novalidate
      autocomplete="off"
    >
      <div class="sectionHeading">
        <h3>Create Toolbox Talk</h3>
      </div>

      <div class="row mx-0 py-2 cstmFormRow">
        <div class="col-md-3 col-lg-4">
          <div class="cstmInputBox">
            <label for="Text1" class="form-label">Title</label>
          </div>
        </div>

        <div class="col-md-9 col-lg-8">
          <div class="cstmInputBox">
            <input
              v-model="talkTitle"
              required
              type="text"
              class="form-control"
              id="Text1"
              placeholder="Text"
            />
          </div>
        </div>
      </div>

      <div class="overflow-auto" style="height: calc(100vh - 248px)">
        <div class="row mx-0 cstmFormRow">
          <div class="col-md-12 main-data-wrapper">
            <div class="row py-2 cstmFormRow border-0">
              <div class="col-md-3 col-lg-4">
                <div class="cstmInputBox">
                  <label for="Text1" class="form-label">Attendees</label>
                </div>
              </div>

              <div class="col-md-9 col-lg-8">
                <div class="p-0 flex items-center gap-2">
                  <label
                    class="form-check-label text-sm opacity-40 mt-1"
                    for="selectAll"
                  >
                    Select All Users
                  </label>
                  <input
                    class="form-check-input float-none m-0 rounded-md!"
                    type="checkbox"
                    id="selectAll"
                    v-model="selectAll"
                  />
                </div>
              </div>
            </div>

            <div class="row py-2 cstmFormRow border-0">
              <div class="col-md-3 col-lg-4">
                <div class="cstmInputBox">
                  <label for="custom-dept-select" class="form-label"
                    >Select Department</label
                  >
                </div>
              </div>

              <div class="col-md-9 col-lg-8">
                <div
                  class="selected-dept-main"
                  v-if="selectedDepartment.length > 0"
                >
                  <span
                    class="selected-dept-span"
                    v-for="department in selectedDepartment"
                    :key="department.id"
                  >
                    {{ department.name }}
                    <button
                      type="button"
                      aria-label="Remove"
                      @click="removeDepartment(department)"
                      class="dept-remove-btn"
                    >
                      <i class="pi pi-times"></i>
                    </button>
                  </span>
                </div>

                <div
                  class="custom-dept"
                  :class="selectAll && 'opacity-50'"
                  id="custom-dept-select"
                  @focusin="!selectAll ? toggleDropdownDepartment() : null"
                  @focusout="closeDropdownDepartment"
                  tabindex="0"
                  @keydown.enter.space.prevent="toggleDropdownDepartment"
                  @keydown.esc="closeDropdownDepartment"
                >
                  <div
                    class="selected-display"
                    :class="{ 'is-open': dropDownOpenDepartment }"
                  >
                    <span class="placeholder">
                      Choose a responsible person or team
                    </span>
                    <span class="pi pi-angle-down"></span>
                  </div>
                  <div v-if="dropDownOpenDepartment" class="options-dropdown">
                    <ul>
                      <li
                        v-for="department in departments"
                        :key="department.id"
                        @click="toggleDepartmentSelection(department)"
                        :class="{
                          'is-selected': isSelectedDepartment(department),
                        }"
                      >
                        {{ department.name }}
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <div class="row py-2 cstmFormRow border-0">
              <div class="col-md-3 col-lg-4">
                <div class="cstmInputBox">
                  <label for="custom-role-select" class="form-label"
                    >Select Role</label
                  >
                </div>
              </div>

              <div class="col-md-9 col-lg-8">
                <div class="selected-dept-main" v-if="selectedRole.length > 0">
                  <span
                    class="selected-dept-span"
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
                      <i class="pi pi-times"></i>
                    </button>
                  </span>
                </div>

                <div
                  class="custom-dept"
                  :class="selectAll && 'opacity-50'"
                  tabindex="0"
                  @focusin="!selectAll ? toggleDropdownRole() : null"
                  @focusout="closeDropdownRole"
                  @keydown.enter.space.prevent="toggleDropdownRole"
                  @keydown.esc="closeDropdownRole"
                  id="custom-role-select"
                >
                  <div
                    class="selected-display"
                    :class="{ 'is-open': dropDownOpenRole }"
                    tabindex="0"
                  >
                    <span class="placeholder">
                      Choose a responsible person or team
                    </span>
                    <span class="pi pi-angle-down"></span>
                  </div>
                  <div v-if="dropDownOpenRole" class="options-dropdown">
                    <ul>
                      <li
                        v-for="role in roles"
                        :key="role.id"
                        @click="toggleRoleSelection(role)"
                        :class="{
                          'is-selected': isSelectedRole(role),
                        }"
                      >
                        {{ role.name }}
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <div class="row py-2 cstmFormRow border-0">
              <div class="col-md-3 col-lg-4">
                <div class="cstmInputBox">
                  <label for="custom-user-select" class="form-label"
                    >Users</label
                  >
                </div>
              </div>

              <div class="col-md-9 col-lg-8">
                <div
                  class="selected-users-main"
                  v-if="selectedUsers.length > 0"
                >
                  <span
                    class="selected-dept-span"
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
                <div
                  class="custom-dept"
                  :class="selectAll && 'opacity-50'"
                  @focusin="!selectAll ? openDropdownUsers() : null"
                  @focusout="closeDropdownUsers"
                  tabindex="0"
                  @keydown.enter.space.prevent="openDropdownUsers"
                  @keydown.esc="closeDropdownUsers"
                  id="custom-user-select"
                >
                  <div
                    class="selected-display"
                    :class="{ 'is-open': dropDownOpenUsers }"
                  >
                    <span class="placeholder">
                      Choose a responsible person or team
                    </span>

                    <span class="pi pi-angle-down"></span>
                  </div>
                  <div v-if="dropDownOpenUsers" class="options-dropdown">
                    <ul>
                      <li
                        v-for="user in users"
                        :key="user.id"
                        @click="toggleUsersSelection(user)"
                        :class="{
                          'is-selected': isSelectedUsers(user),
                        }"
                      >
                        {{ user.name }}
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row mx-0 py-2 cstmFormRow">
          <div class="col-md-3 col-lg-4">
            <div class="cstmInputBox">
              <label for="Text1" class="form-label">Due Date</label>
            </div>
          </div>

          <div class="col-md-9 col-lg-8">
            <div class="cstmInputBox">
              <DatePicker
                fieldClass="w-48"
                v-model="talkDueDate"
                disableBeforeToday="true"
              />
            </div>
          </div>
        </div>

        <div class="row mx-0 py-2 cstmFormRow">
          <div class="col-md-3 col-lg-4">
            <div class="cstmInputBox">
              <label for="Text3" class="form-label">Supporting files</label>
            </div>
          </div>

          <div class="col-md-9 col-lg-8">
            <div class="d-flex gap-4 align-items-center">
              <input
                type="file"
                @change="handleFileChange"
                ref="fileInput"
                class="hidden-input"
                multiple
              />
              <button
                class="cstmFormLinkBTN flex justify-center items-center gap-1"
                type="button"
                @click="triggerFileInput"
              >
                <p class="m-0 mt-1">Upload File</p>
                <svg
                  width="16"
                  height="16"
                  viewBox="0 0 16 16"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M10.9993 4.00008V11.6667C10.9993 13.1401 9.80602 14.3334 8.33268 14.3334C6.85935 14.3334 5.66602 13.1401 5.66602 11.6667V3.33341C5.66602 2.89139 5.84161 2.46746 6.15417 2.1549C6.46673 1.84234 6.89065 1.66675 7.33268 1.66675C7.77471 1.66675 8.19863 1.84234 8.51119 2.1549C8.82375 2.46746 8.99935 2.89139 8.99935 3.33341V10.3334C8.99935 10.7001 8.69935 11.0001 8.33268 11.0001C7.96602 11.0001 7.66602 10.7001 7.66602 10.3334V4.00008H6.66602V10.3334C6.66602 10.7754 6.84161 11.1994 7.15417 11.5119C7.46673 11.8245 7.89065 12.0001 8.33268 12.0001C8.77471 12.0001 9.19863 11.8245 9.51119 11.5119C9.82375 11.1994 9.99935 10.7754 9.99935 10.3334V3.33341C9.99935 1.86008 8.80602 0.666748 7.33268 0.666748C5.85935 0.666748 4.66602 1.86008 4.66602 3.33341V11.6667C4.66602 13.6934 6.30602 15.3334 8.33268 15.3334C10.3593 15.3334 11.9993 13.6934 11.9993 11.6667V4.00008H10.9993Z"
                    fill="#323232"
                  />
                </svg>
              </button>

              <div class="cstmInputBox w-100">
                <input
                  v-model="talkURL"
                  type="text"
                  class="form-control"
                  id="Text3"
                  placeholder="Add your link"
                />
              </div>
            </div>
            <div class="selected-file-main">
              <span
                v-for="(file, idx) in talkPdfs"
                class="selected-dept-span gap-2 items-center justify-center px-3"
                >{{ file.name }}

                <button
                  type="button"
                  class="dept-remove-btn"
                  @click="removeUploadedFile(idx)"
                >
                  X
                </button>
              </span>
            </div>
          </div>
        </div>

        <div class="row mx-0 py-2 cstmFormRow">
          <div class="col-md-3 col-lg-4">
            <div class="cstmInputBox">
              <label for="Text1" class="form-label">Description</label>
            </div>
          </div>

          <div class="col-md-9 col-lg-8">
            <div class="cstmInputBox">
              <textarea
                v-model="talkDescription"
                class="form-control"
                placeholder="Text"
                id="textarea"
                style="height: 100px"
              ></textarea>
            </div>
          </div>
        </div>

        <div class="btnBox mt-5 button-container-count">
          <CreateQuestionSheet
            :initialQuestions="questions"
            :handleSubmit="handleCreateQuestionSheet"
          />
          <span v-if="questions.length" class="question-count-badge">
            {{ questions.length }} Questions Added
          </span>
        </div>

        <div class="footerBtnbox mt-5">
          <button class="cstmFormLinkBTN">Cancel</button>

          <button
            class="cstmFormLinkBTN cstmprimaryBTN flex items-center justify-center h-[35px]"
            type="submit"
          >
            <i v-if="loading" class="pi pi-spinner animate-spin"></i>
            <span v-else> Submit </span>
          </button>

          <div class="cstmInputBox">
            <SelectRoot v-model="isLibrary">
              <SelectTrigger
                class="inline-flex min-w-[160px] items-center justify-between rounded px-[15px] text-[13px]! leading-none h-[35px] gap-[5px] bg-black/10 outline-none"
              >
                <SelectValue placeholder="Select" />
                <i class="pi pi-chevron-down"></i>
              </SelectTrigger>
              <SelectPortal>
                <SelectContent
                  position="popper"
                  class="min-w-[160px] bg-black/10 mt-1 rounded will-change-[opacity,transform] data-[side=top]:animate-slideDownAndFade data-[side=right]:animate-slideLeftAndFade data-[side=bottom]:animate-slideUpAndFade data-[side=left]:animate-slideRightAndFade z-[100]"
                >
                  <SelectViewport class="px-[15px] py-1 space-y-1">
                    <SelectItem
                      value="3"
                      class="text-[13px] leading-none rounded-[3px] flex items-center h-[25px] relative select-none data-[disabled]:text-mauve8 data-[disabled]:pointer-events-none data-[highlighted]:outline-none data-[highlighted]:bg-green9 data-[highlighted]:text-green1"
                    >
                      <SelectItemText> Send </SelectItemText>
                    </SelectItem>
                    <SelectItem
                      value="1"
                      class="text-[13px] leading-none rounded-[3px] flex items-center h-[25px] relative select-none data-[disabled]:text-mauve8 data-[disabled]:pointer-events-none data-[highlighted]:outline-none data-[highlighted]:bg-green9 data-[highlighted]:text-green1"
                    >
                      <SelectItemText> Save in Library </SelectItemText>
                    </SelectItem>
                    <SelectItem
                      value="2"
                      class="text-[13px] leading-none rounded-[3px] flex items-center h-[25px] relative select-none data-[disabled]:text-mauve8 data-[disabled]:pointer-events-none data-[highlighted]:outline-none data-[highlighted]:bg-green9 data-[highlighted]:text-green1"
                    >
                      <SelectItemText> Send & Save </SelectItemText>
                    </SelectItem>
                  </SelectViewport>
                </SelectContent>
              </SelectPortal>
            </SelectRoot>
          </div>
        </div>
      </div>
    </form>

    <div class="error-pop" v-if="submitPopUp">
      <div class="main-pop-msg">
        <div class="heading-wrap">
          <span class="submit-msg-span">Toolbox Talk Created</span>
          <span class="msgspan"
            >Your toolbox talk has been successfully created!</span
          >
        </div>
        <div class="line-break"></div>
        <div class="go-back-btn-wrapper">
          <button
            type="button"
            class="go-back-btn"
            @click="submitPopUp = false"
          >
            Done
          </button>
        </div>
      </div>
    </div>
    <div v-if="questionNumberSelectError" class="error-pop">
      <div class="main-pop-msg">
        <div class="heading-wrap">
          <span class="ques-error-msg-span">Action Required</span>
          <span class="msgspan"
            >Please select both 'Number of Questions to Ask' and 'Number of
            Correct Answers Required'.</span
          >
        </div>
        <div class="line-break"></div>
        <div class="go-back-btn-wrapper">
          <button
            class="go-back-btn"
            type="button"
            @click="questionNumberSelectError = false"
          >
            Go Back
          </button>
        </div>
      </div>
    </div>
    <div v-if="questionSelectError" class="error-pop">
      <div class="main-pop-msg">
        <div class="heading-wrap">
          <span class="ques-error-msg-span">Action Required</span>
          <span class="msgspan">{{ questionError }}</span>
        </div>
        <div class="line-break"></div>
        <div class="go-back-btn-wrapper">
          <button
            class="go-back-btn"
            type="button"
            @click="questionSelectError = false"
          >
            Go Back
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import apiClient from "../router/axios";
import Swal from "sweetalert2";
import "primeicons/primeicons.css";
import {
  SelectContent,
  SelectIcon,
  SelectItem,
  SelectItemText,
  SelectPortal,
  SelectRoot,
  SelectTrigger,
  SelectValue,
  SelectViewport,
} from "radix-vue";
import axios from "axios";
import DatePicker from "../components/DatePicker.vue";
import { useToast } from "../hooks/useToast";
import moment from "moment";
import CreateQuestionSheet from "../components/dialogs/CreateQuestionSheet.vue";

const { addToast } = useToast();

export default {
  components: {},
  data() {
    return {
      // loading state for create API
      loading: false,
      questionSelectError: false,
      questionError: "",
      questionNumberSelectError: false,
      submitPopUp: false,
      dropDownOpenDepartment: false,
      dropDownOpenRole: false,
      dropDownOpenUsers: false,
      selectedUsers: [],
      buttonValue: "Add",
      selectedDepartment: [],
      selectedRole: [],
      errorPop: false,
      totalQuestions: "",
      correctAnswers: "",
      selectAll: false,
      showPopup: false,
      meta: {
        totalQuestions: "",
        passMark: "",
      },
      departments: [],
      roles: [],
      users: [],
      selected: [],
      selectedTemp: [],
      talkTitle: "",
      talkURL: "",
      talkPdfs: [],
      talkDueDate: "",
      talkDescription: "",
      isLibrary: "3",
      selectAllUsers: false,
      attemptQuestions: "",
      selectAllRoles: false,
      selectAllDept: false,
      val: "",
      questions: [],
      minDate: new Date().toISOString().split("T")[0],
    };
  },
  mounted() {
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
    handleCreateQuestionSheet(
      filledQuestions,
      questionsToAskCount,
      correctAnswersRequiredCount
    ) {
      console.log(
        filledQuestions,
        questionsToAskCount,
        correctAnswersRequiredCount
      );
      this.questions = filledQuestions;
      this.totalQuestions = questionsToAskCount;
      this.correctAnswers = correctAnswersRequiredCount;
    },
    openDropdownUsers() {
      this.dropDownOpenUsers = true;
    },

    closeDropdownUsers() {
      this.dropDownOpenUsers = false;
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
      this.selectedUsers = this.selectedUsers.filter(
        (curr) => curr.id !== userToRemove.id
      );
    },
    toggleDropdownRole() {
      this.dropDownOpenRole = !this.dropDownOpenRole;
    },

    closeDropdownRole() {
      this.dropDownOpenRole = false;
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

    isSelectedRole(role) {
      return !!this.selectedRole.find((curr) => curr.id === role.id);
    },

    removeRole(roleToRemove) {
      this.selectedRole = this.selectedRole.filter(
        (curr) => curr.id !== roleToRemove.id
      );
    },

    isSelectedDepartment(dept) {
      return !!this.selectedDepartment.find((curr) => curr.id === dept.id);
    },
    toggleDropdownDepartment() {
      this.dropDownOpenDepartment = !this.dropDownOpenDepartment;
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
    closeDropdownDepartment() {
      this.dropDownOpenDepartment = false;
    },
    // handleCreateSheet() {
    //   if (this.questions.length > 0) {
    //     this.buttonValue = "Edit";
    //     this.val = this.questions.length;
    //   } else {
    //     this.buttonValue = "Add";
    //   }
    //   this.showPopup = false;
    // },
    triggerFileInput() {
      this.$refs.fileInput.click();
    },
    handleFileChange(e) {
      for (const file of e.target.files) {
        this.talkPdfs.push(file);
      }
    },

    removeUploadedFile(idx) {
      this.talkPdfs.splice(idx, 1);
    },
    removeDepartment(departmentToRemove) {
      this.selectedDepartment = this.selectedDepartment.filter(
        (curr) => curr.id !== departmentToRemove.id
      );
    },

    showQuesPopup() {
      this.showPopup = true;
    },
    getOptionLabel(index) {
      return String.fromCharCode(65 + index);
    },

    addNewQuestion() {
      if (this.questions.length < 10) {
        this.questions.push({
          text: "",
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
    handleCreateSheet() {
      if (this.totalQuestions === "" || this.correctAnswers === "") {
        // alert("Please select both 'Number of Questions to Ask' and 'Number of Correct Answers Required'.");
        this.questionNumberSelectError = true;
        return;
      }

      // Validate each question and its options
      for (const question of this.questions) {
        if (!question.text.trim()) {
          this.questionError = "Please fill in the text for all questions.";
          this.questionSelectError = true;
          return; // Stop and show alert if a question text is empty
        }
        // Validate options A and B are not empty
        if (!question.options[0].trim() || !question.options[1].trim()) {
          this.questionError = `Please fill in Options A and B for question: "${question.text.substring(
            0,
            30
          )}..."`;
          this.questionSelectError = true;
          return; // Stop and show alert if options A or B are empty
        }
        if (!question.correctAnswer) {
          this.questionError = `Please select a correct answer for question: "${question.text.substring(
            0,
            30
          )}..."`;
          this.questionSelectError = true;
          return; // Stop and show alert if correct answer is not selected
        }
      }

      // If all validations pass
      this.val = this.questions.length;
      this.buttonValue = "Edit";
      this.showPopup = false;
    },
    removeQuestion(index) {
      if (this.questions.length > 1) {
        this.questions.splice(index, 1);
      }
      // this.questions = this.questions.filter((question, i) => i !== index);
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
    scrollToLatestQuestion() {
      const container =
        this.$refs.questionsContainer[this.questions.length - 1];
      if (container) {
        container.scrollIntoView({ behavior: "smooth" });
      }
    },
    // Get Departments from CMS API
    async getDepartments() {
      try {
        const { data } = await axios.get(
          "https://dash.cmsdesk.com/api/dev-hub/departments",
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
          "https://dash.cmsdesk.com/api/dev-hub/roles",
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
          "https://dash.cmsdesk.com/api/dev-hub/users",
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
        "https://dash.cmsdesk.com/api/dev-hub/users",
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
    addSelected() {
      if (
        this.selectedTemp &&
        !this.selected.find((i) => i.id === this.selectedTemp.id)
      ) {
        this.selected.push(this.selectedTemp);
      }
      this.selectedTemp = "";
    },
    removeSelected(index) {
      this.selected.splice(index, 1);
    },

    validationCheck() {
      // if (!moment(this.talkDueDate).isValid()) {
      //   addToast({
      //     title: "Validation Error",
      //     description: "Please enter correct Due Date.",
      //     type: "warning",
      //   });
      //   return false;
      // }
      if (!this.talkTitle.length) {
        addToast({
          title: "Validation Error",
          description: "Please enter Talk Title.",
          type: "warning",
        });
        return false;
      }

      if (
        (this.isLibrary === "2" || this.isLibrary === "3") &&
        !this.selectAll &&
        !this.selectedDepartment.length &&
        !this.selectedRole.length &&
        !this.selectedUsers.length
      ) {
        addToast({
          title: "Validation Error",
          description: "Please select at least one Department, Role, or User.",
          type: "warning",
        });
        return false;
      }
      return true;
    },

    async submitData() {
      try {
        if (!this.validationCheck()) return;

        const uniqueUsers = new Map();

        if (this.selectAll)
          this.users.forEach((user) => {
            uniqueUsers.set(user.id, {
              select_user_id: user.id,
              user_name: user.name,
            });
          });
        else {
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
        const formData = {
          title: this.talkTitle,
          resource_url: this.talkURL,
          pdf_file: this.talkPdfs,
          questions: JSON.stringify(this.questions),
          due_date: this.talkDueDate,
          isLibrary: this.isLibrary,
          select_user_detail: JSON.stringify(Array.from(uniqueUsers.values())),
          description: this.talkDescription,
          attemptQuestions: this.totalQuestions,
          number_of_correct_answer_to_pass: this.correctAnswers,
        };

        this.loading = true;
        await apiClient.post("/create-toolbox-talk", formData);
        // Swal.fire({
        //   icon: "success",
        //   title: "Toolbox Talk Created",
        //   text: "Your toolbox talk has been successfully created!",
        // });
        this.submitPopUp = true;
        setTimeout(() => {
          this.$router.push({ name: "created-by-me-talks" });
        }, 2000);
      } catch (error) {
        console.log(error);
        addToast({
          title: "Submission Failed",
          description: error.response?.data?.message
            ? error.response?.data?.message ===
              "The number of correct answer to pass field is required."
              ? "Minimum one question is required!"
              : error.response?.data?.message
            : "An error occurred while submitting the form",
          type: "error",
        });
      }
      this.loading = false;
    },
  },
};
</script>

<style scoped>
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

.main-heading-span {
  font-weight: bold;
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
  height: 1px;
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

.main-data-wrapper {
  padding-bottom: 10px;
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

.go-back-btn-wrapper {
  display: flex;
  justify-content: end;
}

.heading-wrap {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.go-back-btn {
  background: #bdbdbd;
  border: none;
  width: 172px;
  height: 38px;
  border-radius: 5px;
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

.selected-tags {
  margin-top: 10px;
  display: flex;
  flex-wrap: wrap;
}

.ques-scroll-wrapper {
  height: 210px;
  overflow-y: scroll;
}

.tag {
  background-color: #e0e0e0;
  border-radius: 16px;
  padding: 5px 10px;
  margin: 5px;
  display: flex;
  align-items: center;
}

.tag button {
  background: none;
  border: none;
  margin-left: 8px;
  cursor: pointer;
}

.error-pop {
  position: fixed;
  width: 920px;
  height: 200px;
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
  width: 880px;
  height: 158px;
  display: flex;
  flex-direction: column;
  gap: 15px;
  justify-content: center;
}

.action-msg-span {
  width: 880px;
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

.selected-users-main {
  width: 100%;
  justify-self: end;
  display: flex;
  flex-direction: row;
  gap: 5px;
  flex-wrap: wrap;
  overflow-x: hidden;
  margin-bottom: 8px;
}

.selected-dept-main {
  width: 100%;
  justify-self: end;
  display: flex;
  flex-direction: row;
  gap: 5px;
  flex-wrap: wrap;
  overflow-x: hidden;
  margin-bottom: 8px;
}

.selected-file-main {
  width: 100%;
  padding-bottom: 8px;
  overflow-x: auto;
  margin-top: 10px;
  display: flex;
  flex-direction: row;
  padding-left: 5px;
  gap: 5px;
}

.selected-dept-span {
  background: #cbe7fb;
  padding: 0 12px;
  border-radius: 20px;
  color: #0d99ff;
  font-size: small;
  display: flex;
  gap: 8px;
  align-items: center;
  height: 20px;
  white-space: nowrap;
}

.hidden-input {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
}

.dept-remove-btn {
  margin-top: 2px;
  font-size: 10px;
  background: none;
  border: none;
  color: #0d99ff;
}

.question-count-badge {
  background-color: #e3e3e4;
  color: #808080;
  display: flex;
  height: 25px;
  margin-left: 20px;
  width: fit-content;
  padding: 2px 8px;
  justify-content: center;
  border: none;
  outline: none;
  border-radius: 4px;
}

.button-container-count {
  display: flex;
  align-items: center;
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

.placeholder {
  /* color:#8f8f8f; */

  flex-grow: 1;
  background: none;
  cursor: pointer;
}

.dropdown-arrow {
  margin-left: auto;
  width: 0;
  height: 0;
  border-left: 5px solid transparent;
  border-right: 5px solid transparent;
  border-top: 5px solid #555;
  transition: transform 0.2s ease;
}

.dropdown-arrow.arrow-up {
  transform: rotate(180deg);
}

.custom-dept {
  position: relative;
}

.options-dropdown {
  position: absolute;
  width: 100%;
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

.submit-msg-span {
  width: 880px;
  background-color: #4cbb17;
  height: 45px;
  align-content: space-evenly;
  padding-left: 20px;
  border-radius: 60px;
  font-weight: bold;
}

.ques-error-msg-span {
  width: 880px;
  background-color: #f46c4d;
  height: 45px;
  align-content: space-evenly;
  padding-left: 20px;
  border-radius: 60px;
  font-weight: bold;
}

@media (min-width: 992px) {
  .col-lg-4 {
    flex: 0 0 auto;
    width: 15%;
  }
}

@media (min-width: 992px) {
  .col-lg-8 {
    flex: 0 0 auto;
    width: 84.666667%;
  }
}

@media (min-width: 2560px) {
  .popup-overlay {
    height: 800px;
    width: 1000px;
    display: flex;
    flex-direction: column;
  }

  .first-container {
    display: flex;
    flex-direction: column;
    width: 97%;
    gap: -11px;
    height: 200px;
    gap: 20px;
  }

  .second-container {
    display: flex;
    flex-direction: column;
    width: 97%;
    gap: 10px;
    height: 350px;
    gap: 30px;
  }

  .question-wrapper {
    width: 100%;
  }

  .question-input {
    width: 75%;
  }
}
</style>
