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
          <span class="mianHeading">{{ talkDetails?.title }}</span>
          <span class="createdByHeading"
            >Created by
            {{ talkDetails?.get_created_by_user?.name }}
          </span>
          <span class="dateHeading">{{
            formatDate(talkDetails?.created_at)
          }}</span>
          <span class="assignSpan" v-if="status === '1'">Ended</span>
          <span class="unassignSpan" v-if="status === '2'">Completed</span>
          <span class="unassignSpan" v-if="status === '3'">Ongoing</span>
        </div>
        <div class="description-main-wrapper">
          <span class="bottom-des">Description</span>
          <span class="bottom-description">{{ talkDetails?.description }}</span>
        </div>
      </div>
    </div>
    <div class="right-side-main-container">
      <div class="updates-main-container">
        <div class="headingContainer">
          <span>Updates & Attachments</span>
          <button v-if="status == 1" class="copy-btn">Make a copy</button>

          <div v-if="status == 0" class="optionsContainer">
            <button class="submitButton">Submit</button>
            <div class="cstmInputBox sendButtonWrapper">
              <select class="form-select sendButtonWrapper">
                <option hidden="">Send</option>
                <option value="Save in Library">Save in Library</option>
                <option value="Send & Save">Send & Save</option>
              </select>
            </div>
          </div>
        </div>
        <div class="options-main-container">
          <div class="commonContainer">
            <div class="uploadWrapper">
              <span class="uplaodHead">Upload Attachments</span>
              <span class="attactmentSpan">{{ file.length }} Attachments</span>
            </div>
            <input
              type="file"
              @change="handleFileChange"
              ref="fileInput"
              class="hidden-input"
            />
            <button
              v-if="status == 0"
              class="cstmFormLinkBTN"
              type="button"
              @click="triggerFileInput"
            >
              Upload Files
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
          </div>
          <button class="editButton" @click="showDocumentsPopup">
            Preview
          </button>
          <div class="commonContainer">
            <span class="uplaodHead">Question Sheet</span>
            <span class="attactmentSpan"
              >{{ questionSheet.length }} Questions</span
            >
          </div>
          <button
            :disabled="questionSheet.length === 0"
            :class="
              questionSheet.length === 0 ? 'disabledButton' : 'editButton'
            "
            @click="showQuesPopup"
            class="whitespace-nowrap w-fit px-2"
          >
            {{ status == "3" ? "Start Questions" : "Preview" }}
          </button>
        </div>
      </div>
      <div class="attendes-main-wrapper pt-4" v-if="status == 0">
        <!-- <div class="row py-2 cstmFormRow border-0"> -->
        <div class="row py-2 cstmFormRow border-0">
          <div class="col-md-3 col-lg-4">
            <div class="cstmInputBox">
              <label for="Text1" class="form-label">Attendees</label>
            </div>
          </div>

          <div class="col-md-9 col-lg-8">
            <div class="form-check cstmformcheck">
              <input
                class="form-check-input"
                type="checkbox"
                id="selectAll"
                @click="allSelected()"
              />
              <label
                class="form-check-label"
                for="selectAll"
                @click="allSelected()"
              >
                Select All
              </label>
            </div>
          </div>
        </div>
        <div class="line-break"></div>

        <div class="row py-2 cstmFormRow border-0">
          <div class="col-md-3 col-lg-4">
            <div class="cstmInputBox">
              <label for="Text1" class="form-label">Select Department</label>
            </div>
          </div>

          <div class="col-md-9 col-lg-8" id="custom-dept-select">
            <div
              class="selected-display"
              :class="{ 'is-open': dropDownOpenDepartment }"
              @click="toggleDropdownDepartment"
              tabindex="0"
              @keydown.enter.space.prevent="toggleDropdownDepartment"
              @keydown.esc="closeDropdownDepartment"
            >
              <span class="placeholder">
                Choose a responsible person or team
              </span>

              <span class="pi pi-angle-down"></span>
            </div>
            <div v-if="dropDownOpenDepartment" class="options-dropdown">
              <ul>
                <li
                  v-for="role in roles"
                  :key="role.id"
                  @click="toggleDepartmentSelection(role.name)"
                  :class="{
                    'is-selected': isSelectedDepartment(role.name),
                  }"
                >
                  {{ role.name }}
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="selected-dept-main" v-if="selectedDepartment.length > 0">
          <span
            class="selected-dept-span"
            v-for="departmentName in selectedDepartment"
            :key="departmentName.name"
          >
            {{ departmentName }}
            <button
              type="button"
              aria-label="Remove"
              @click="removeDepartment(departmentName)"
              class="dept-remove-btn"
            >
              X
            </button>
          </span>
        </div>

        <div class="row py-2 cstmFormRow border-0">
          <div class="col-md-3 col-lg-4">
            <div class="cstmInputBox">
              <label for="Text1" class="form-label">Select Role</label>
            </div>
          </div>

          <div class="col-md-9 col-lg-8">
            <div
              id="custom-role-select"
              class="selected-display"
              :class="{ 'is-open': dropDownOpenRole }"
              @click="toggleDropdownRole"
              tabindex="0"
              @keydown.enter.space.prevent="toggleDropdownRole"
              @keydown.esc="closeDropdownRole"
            >
              <span class="placeholder">
                Choose a responsible person or team
              </span>

              <span class="pi pi-angle-down"></span>
            </div>
            <div v-if="dropDownOpenRole" class="options-dropdown">
              <ul>
                <li
                  v-for="permission in permissions"
                  :key="permission.id"
                  @click="toggleRoleSelection(permission.name)"
                  :class="{
                    'is-selected': isSelectedRole(permission.name),
                  }"
                >
                  {{ permission.name }}
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div class="selected-dept-main" v-if="selectedRole.length > 0">
          <span
            class="selected-dept-span"
            v-for="roleName in selectedRole"
            :key="roleName.name"
          >
            {{ roleName }}
            <button
              type="button"
              aria-label="Remove"
              @click="removeRole(roleName)"
              class="dept-remove-btn"
            >
              X
            </button>
          </span>
        </div>

        <div class="row py-2 cstmFormRow border-0">
          <div class="col-md-3 col-lg-4">
            <div class="cstmInputBox">
              <label for="Text1" class="form-label">Users</label>
            </div>
          </div>

          <div class="col-md-9 col-lg-8">
            <div
              id="custom-user-select"
              class="selected-display"
              :class="{ 'is-open': dropDownOpenUsers }"
              @click="toggleDropdownUsers"
              tabindex="0"
              @keydown.enter.space.prevent="toggleDropdownUsers"
              @keydown.esc="closeDropdownUsers"
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
                  @click="toggleUsersSelection(user.name)"
                  :class="{
                    'is-selected': isSelectedUsers(user.name),
                  }"
                >
                  {{ user.name }}
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="selected-users-main" v-if="selectedUsers.length > 0">
          <span
            class="selected-dept-span"
            v-for="usersName in selectedUsers"
            :key="usersName.name"
          >
            {{ usersName }}
            <button
              type="button"
              aria-label="Remove"
              @click="removeUser(usersName)"
              class="dept-remove-btn"
            >
              X
            </button>
          </span>
        </div>
      </div>
      <div class="tableWrapperBox sign-off-wrapper pt-4">
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
                <th v-if="questionSheet.length" width="150">Result</th>
                <th v-if="questionSheet.length" width="150">Attempts</th>
                <th width="120">Sign</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <span>{{ talkDetails.name }}</span>
                </td>
                <td>
                  <span>{{ talkDetails.date || "N/A" }}</span>
                </td>
                <td>
                  <span>{{ talkDetails.time || "N/A" }}</span>
                </td>
                <td v-if="questionSheet.length">
                  <span>{{ talkDetails.result.result }}</span>
                  <span
                    >&nbsp;<i class="fa fa-file-text cursor-pointer"></i
                  ></span>
                </td>
                <td v-if="questionSheet.length">
                  <span>{{ talkDetails.attempt }}</span>
                </td>
                <td>
                  <input
                    class="form-check-input"
                    style="opacity: 1"
                    type="checkbox"
                    :checked="talkDetails.status === '2'"
                    disabled
                  />
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <button
          class="bg-[#42bd7c] h-[30px] px-2 text-white rounded-[4px]! float-end my-2 flex items-center"
        >
          Acknowledge
        </button>
      </div>
    </div>
    <div v-if="editQuestionSheet" class="popup-overlay">
      <div class="first-container">
        <div class="main-heading-wrapper">
          <span class="main-heading-span">Update Question Sheet</span>
        </div>
        <div class="ques-main-wrapper">
          <div class="input-ques-wrapper">
            <span class="ques-span"
              >Number of Questions to Ask per Participant*
            </span>
            <!-- <input type="text" class="ques-input"/> -->

            <select
              name="ques"
              id="ques"
              class="ques-input"
              v-model="totalQuestions"
            >
              <option v-for="n in 10" :value="n" :key="n">{{ n }}</option>
            </select>
          </div>
          <div class="line-break"></div>
          <div class="input-ques-wrapper">
            <span class="ques-span"
              >Number of Correct Answers Required to Pass*</span
            >

            <select
              name="correct-ques"
              id="correct-ques"
              v-model="correctAnswers"
              @change="validateSelection"
              class="ques-input"
            >
              <option v-for="n in 10" :value="n" :key="n">{{ n }}</option>
            </select>
          </div>
          <div class="line-break"></div>
          <div class="error-pop" v-if="errorPop">
            <div class="main-pop-msg">
              <div class="heading-wrap">
                <span class="action-msg-span">Action Required</span>
                <span class="msgspan"
                  >The number of questions asked must be less than or the same
                  as the amount of questions added.</span
                >
              </div>
              <div class="line-break"></div>
              <div class="go-back-btn-wrapper">
                <button class="go-back-btn" @click="errorPop = false">
                  Go Back
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="second-container">
        <div class="main-heading-wrapper">
          <span>Questions</span>
        </div>
        <div class="ques-scroll-wrapper">
          <div
            class="ques-container"
            v-for="(question, index) in questionSheet"
            :key="index"
            ref="questionsContainer"
          >
            <div class="question-wrapper">
              <span class="question-span">Question {{ index + 1 }}</span>
              <input
                v-model="question.name"
                type="text"
                placeholder="Question"
                class="question-input"
              />
              <button
                class="trash-button"
                @click="removeQuestion(index)"
                type="button"
              >
                <i class="pi pi-trash"></i>
              </button>
            </div>
            <div class="line-break"></div>

            <div class="options-section">
              <div>
                <div
                  v-for="(option, optIndex) in question.options"
                  :key="optIndex"
                  class="question-wrapper"
                >
                  <label
                    :for="`option${index}-${optIndex}`"
                    class="question-span"
                  >
                    Option {{ optIndex + 1 }}
                    <span style="color: red" v-if="optIndex < 2"></span>
                  </label>
                  <input
                    type="text"
                    :id="`option${index}-${optIndex}`"
                    v-model="option.name"
                    class="question-input"
                    :required="optIndex < 2"
                    :placeholder="option.name"
                  />
                </div>
              </div>
            </div>

            <div class="line-break"></div>

            <div class="question-wrapper">
              <span class="question-span">Correct Answer</span>
              <select
                v-model="question.correctAnswer"
                required
                name="correct-ans"
                id="correct-ans"
                class="question-input"
              >
                <option value="" disabled>Select Correct Choice</option>
                <option
                  v-for="(option, optIndex) in question.options"
                  :key="optIndex"
                  :value="option.id"
                  :selected="option.name == question.correct_answer[0].name"
                >
                  {{ option.name }}
                </option>
              </select>
            </div>

            <div class="line-break"></div>
          </div>
        </div>
      </div>
      <button
        class="add-ques"
        @click="addNewQuestion"
        :disabled="questions.length >= 10"
        type="button"
      >
        <i class="pi pi-plus-circle"></i>
        Add Question
      </button>
      <div class="button-wrapper">
        <button
          class="cancel-btn"
          @click="editQuestionSheet = false"
          type="button"
        >
          Cancel
        </button>
        <button
          class="create-btn"
          @click="editQuestionSheet = false"
          type="button"
        >
          Update Question Sheet
        </button>
      </div>
    </div>
    <div v-if="previewQuestionSheet" class="popup-overlay">
      <div class="first-container">
        <div class="main-heading-wrapper">
          <span class="main-heading-span"> Question Sheet</span>
        </div>
        <div class="ques-main-wrapper">
          <div class="input-ques-wrapper">
            <span class="ques-span"
              >Number of Questions to Ask per Participant*
            </span>
            <!-- <input type="text" class="ques-input"/> -->

            <select
              disabled
              name="ques"
              id="ques"
              class="ques-input"
              v-model="totalQuestions"
            >
              <option v-for="n in 10" :value="n" :key="n">{{ n }}</option>
            </select>
          </div>
          <div class="line-break"></div>
          <div class="input-ques-wrapper">
            <span class="ques-span"
              >Number of Correct Answers Required to Pass*</span
            >

            <select
              disabled
              name="correct-ques"
              id="correct-ques"
              v-model="correctAnswers"
              @change="validateSelection"
              class="ques-input"
            >
              <option v-for="n in 10" :value="n" :key="n">{{ n }}</option>
            </select>
          </div>
          <div class="line-break"></div>
          <div class="error-pop" v-if="errorPop">
            <div class="main-pop-msg">
              <div class="heading-wrap">
                <span class="action-msg-span">Action Required</span>
                <span class="msgspan"
                  >The number of questions asked must be less than or the same
                  as the amount of questions added.</span
                >
              </div>
              <div class="line-break"></div>
              <div class="go-back-btn-wrapper">
                <button class="go-back-btn" @click="errorPop = false">
                  Go Back
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="second-container">
        <div class="main-heading-wrapper">
          <span>Questions</span>
        </div>
        <div class="ques-scroll-wrapper">
          <div
            class="ques-container"
            v-for="(question, index) in questionSheet"
            :key="index"
          >
            <div class="question-wrapper">
              <span class="question-span">Question {{ index + 1 }}</span>
              <input
                disabled
                v-model="question.name"
                type="text"
                placeholder="Question"
                class="question-input"
              />
            </div>
            <div class="line-break"></div>

            <div class="options-section">
              <div>
                <div
                  v-for="(option, optIndex) in question.options"
                  :key="optIndex"
                  class="question-wrapper"
                >
                  <label
                    :for="`option${index}-${optIndex}`"
                    class="question-span"
                  >
                    Option {{ optIndex + 1 }}
                    <span style="color: red" v-if="optIndex < 2"></span>
                  </label>
                  <input
                    disabled
                    type="text"
                    :id="`option${index}-${optIndex}`"
                    v-model="option.name"
                    class="question-input"
                    :required="optIndex < 2"
                    :placeholder="option.name"
                    :class="{
                      'correct-option':
                        option.name === question.correct_answer[0].name,
                    }"
                  />
                </div>
              </div>
            </div>

            <div class="line-break"></div>

            <div class="question-wrapper">
              <span class="question-span">Correct Answer</span>
              <span class="question-input">{{
                question.correct_answer[0].name
              }}</span>
            </div>
            <div class="line-break"></div>
          </div>
        </div>
      </div>

      <div class="button-wrapper edit-questions">
        <button
          class="cancel-btn"
          @click="previewQuestionSheet = false"
          type="button"
        >
          Close
        </button>
      </div>
    </div>
    <!-- Edit Popup -->
    <div
      class="upload-main-container-popup"
      v-if="documentEditPopup"
      @click.self="closeEditPopup"
    >
      <div class="popup-content">
        <div class="upload-first-container">
          <div class="main-heading-wrapper">
            <span class="main-heading-span">Video</span>
          </div>
          <div class="link-wrapper">
            <!-- <span>Video Link</span> -->
            <input
              type="text"
              class="form-control custom_inputbox"
              placeholder="Video Link"
              v-model="videoLink"
            />
            <!-- <span class="url-span">{{ videoLink }}</span> -->
            <button
              v-if="status == 0"
              class="trash-button"
              @click="removeVideoLink()"
              type="button"
            >
              <i class="pi pi-trash"></i>
            </button>
          </div>
          <div class="line-break"></div>
        </div>
        <div class="secondDocumentWrapper">
          <div class="main-heading-wrapper">
            <span class="main-heading-span">Files</span>
          </div>
          <div class="pdf_flex">
            <div class="pdf-wrapper">
              <div class="doc-span-wrapper check_flex">
                <input type="checkbox" class="check_box form-check" />
                <div v-for="doc of file" class="document_check">
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
            <button
              v-if="status == 0"
              class="trash-button"
              @click="removeVideoLink()"
              type="button"
            >
              <i class="pi pi-trash"></i>
            </button>
          </div>
        </div>
      </div>
      <div class="text-end end_btn">
        <button type="button" @click="closeEditPopup" class="backBtnEnd">
          Cancel
        </button>
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
          <div class="link-wrapper">
            <a
              style="text-decoration: none"
              :href="videoLink"
              target="_blank"
              >{{ videoLink }}</a
            >
          </div>
          <div class="line-break"></div>
        </div>
        <div class="secondDocumentWrapper">
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
</template>

<script>
import apiClient from "../router/axios";
import Swal from "sweetalert2";

export default {
  data() {
    return {
      questionSheet: [],
      previewQuestionSheet: false,
      dropDownOpenDepartment: false,
      dropDownOpenRole: false,
      dropDownOpenUsers: false,
      selectedDepartment: [],
      selectedUsers: [],
      file: [],
      roles: [],
      permissions: [],
      users: [],
      signOffSheet: [],
      editQuestionSheet: false,
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
      showPopup: false,
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
    this.getAssignedToMeById();
    this.getRolesAndPermission();
  },
  methods: {
    toggleUsersSelection(userName) {
      if (this.isSelectedUsers(userName)) {
        this.selectedUsers = this.selectedUsers.filter(
          (name) => name !== userName
        );
      } else {
        this.selectedUsers.push(userName);
      }
    },

    isSelectedUsers(name) {
      return this.selectedUsers.includes(name);
    },

    removeUser(userToRemove) {
      const val = userToRemove.name;
      this.selectedUsers.splice(val, 1);
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
    isSelectedDepartment(name) {
      return this.selectedDepartment.includes(name);
    },
    toggleRoleSelection(permissionName) {
      if (this.isSelectedRole(permissionName)) {
        this.selectedRole = this.selectedRole.filter(
          (name) => name !== permissionName
        );
      } else {
        this.selectedRole.push(permissionName);
      }
    },
    isSelectedRole(name) {
      return this.selectedRole.includes(name);
    },
    removeRole(roleToRemove) {
      const val = roleToRemove.name;
      this.selectedRole.splice(val, 1);
    },
    toggleDepartmentSelection(rolesName) {
      if (this.isSelectedDepartment(rolesName)) {
        this.selectedDepartment = this.selectedDepartment.filter(
          (name) => name !== rolesName
        );
      } else {
        this.selectedDepartment.push(rolesName);
      }
    },
    toggleDropdownDepartment() {
      this.dropDownOpenDepartment = !this.dropDownOpenDepartment;
    },
    removeDepartment(departmentToRemove) {
      const val = departmentToRemove.name;
      this.selectedDepartment.splice(val, 1);
    },

    closeDropdownDepartment() {
      this.dropDownOpenDepartment = false;
    },
    toggleDropdownUsers() {
      this.dropDownOpenUsers = !this.dropDownOpenUsers;
    },

    async getRolesAndPermission() {
      try {
        const response = await apiClient.get("/roles-permissions-users");
        this.roles = response.data.roles;
        this.permissions = response.data.permissions;
        this.users = response.data.users;
      } catch (error) {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "Could not fetch roles and permissions",
        });
      }
    },

    async getAssignedToMeById() {
      const id = this.$route.params.id;
      try {
        const response = await apiClient.post(`/assignedtome`, {
          toolbox_talk_id: id,
        });
        this.talkDetails = response.data.assignToMeToolboxTalks;
        this.videoLink = this.talkDetails?.video_url?.[0]?.video_url || "";
        this.status = response.data.assignToMeToolboxTalks.status;
        this.file = this.talkDetails?.file || [];
        this.correctAnswers =
          this.talkDetails?.number_of_correct_answer_to_pass;
        this.totalQuestions = this.talkDetails?.number_of_questions_to_ask;
        this.questionSheet = this.talkDetails?.questions || [];
        this.signOffSheet = this.talkDetails.get_assigned_users;
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
    showQuesPopup() {
      this.previewQuestionSheet = true;
    },
    showQuesEditPopup() {
      this.editQuestionSheet = true;
    },
    addNewQuestion() {
      if (this.questions.length < 10) {
        this.questions.push({
          text: "",
          options: ["", "", "", ""],
          correctAnswer: null,
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
    quesPop() {
      this.showQuesPop = true;
    },
    removeQuestion(index) {
      if (this.questions.length > 1) {
        this.questions.splice(index, 1);
      }
    },
    validateSelection() {
      if (this.totalQuestions && this.correctAnswers) {
        if (parseInt(this.correctAnswers) >= parseInt(this.totalQuestions)) {
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
    handleFileChange(e) {
      const files = e.target.files[0];
      if (files) {
        this.talkPdf = files;
      }
    },
    triggerFileInput() {
      this.$refs.fileInput.click();
    },
  },
};
</script>

<style scoped>
.end_btn button.backBtnEnd {
  margin-left: auto;
  margin-right: 20px;
  margin-bottom: 20px;
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
  padding-top: unset;
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
  width: 25%;
  /* height: 940px; */
  height: 100%;
  border-radius: 25px;
  padding-top: 10px;
  padding-bottom: 10px;
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
  height: 75px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-left: 20px;
  padding-right: 20px;
}

.details-wrapper {
  /* height: 850px; */
  height: 92%;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  padding-bottom: 10px;
}

.details-main-wrapper {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: space-between;
  height: 132px;
}

.description-main-wrapper {
  background-color: #f4f4f4;
  display: flex;
  flex-direction: column;
  height: 210px;
  border-radius: 10px;
  width: 95%;
  align-self: anchor-center;
  padding-right: 10px;
  padding-left: 10px;
  gap: 30px;
}

.mianHeading {
  font-size: xx-large;
  font-weight: bold;
  color: #000000;
}

.createdByHeading {
  color: #323232;
}

.dateHeading {
  color: #828282;
}

.assignSpan {
  display: flex;
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
  width: 120px;
  border: none;
  background-color: #e1e1e1;
  color: #9e9e9e;
  border-radius: 5px;
  cursor: pointer;
}

.options-main-container {
  height: 277px;
  display: flex;
  flex-direction: column;
  justify-content: space-around;
}

.editButton {
  width: fit-content;
  padding: 0 12px;
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

.disabledButton {
  height: 30px;
  background-color: #666666;
  opacity: 0.5;
  cursor: not-allowed;
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
  gap: 8px;
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
  border: none;
  border-radius: 5px;
  font-size: 18px;
  font-weight: bold;
  color: #666;
  height: 38px;
  width: 161px;
  padding: 5px 56px 5px 50px;
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
  height: 464px;
  margin-top: 5%;
  display: flex;
  flex-direction: column;
  padding-top: 3%;
  gap: 13px;
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
  padding-left: 20px;
  padding-top: 20px;
  background-color: white;
  border: 0.5px solid grey;
}

.cursor-pointer {
  cursor: pointer;
}

.upload-first-container {
  height: 150px;
  width: 760px;
  position: relative;
}

.link-wrapper {
  display: flex;
  padding-left: 10px;
  gap: 25px;
  height: 52px;
  align-items: center;
  color: #969696;
  padding-right: 10px;
}

.secondDocumentWrapper {
  /* height: 185px; */
  width: 760px;
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

.selected-dept-main {
  width: 85%;
  justify-self: end;
  display: flex;
  flex-direction: row;
  padding-left: 5px;
  gap: 5px;
  flex-wrap: wrap;
  overflow-x: hidden;
}

.selected-users-main {
  height: 50px;
  overflow: scroll;
  width: 85%;
  justify-self: end;
  display: flex;
  flex-direction: row;
  padding-left: 5px;
  gap: 5px;
  flex-wrap: wrap;
  overflow-x: hidden;
}

.selected-dept-span {
  background: #cbe7fb;
  padding-left: 8px;
  padding-right: 5px;
  border-radius: 20px;
  color: #0d99ff;
  font-size: small;
  display: flex;
  align-items: center;
  height: 25px;
}

.document_check {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 10px;
}

.description-main-wrapper {
  margin-top: 2rem;
  padding: 16px;
  height: auto;
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

  .icons-wrapper {
    height: auto;
    padding: 10px 16px;
  }

  .details-main-wrapper {
    height: auto;
  }

  .details-wrapper {
    height: 100%;
    overflow: auto;
    padding-bottom: 56px;
  }

  .description-main-wrapper {
    margin-top: 1rem;
    padding: 16px;
    height: auto;
    gap: 12px;
  }

  .options-main-container {
    height: auto;
    gap: 16px;
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

.description-main-wrapper {
  max-height: 300px;
  overflow-y: auto;
  margin-bottom: 10px;
  gap: 10px;
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
</style>
