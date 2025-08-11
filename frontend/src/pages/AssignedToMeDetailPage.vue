<template>
  <div class="dashboardbody">
    <div class="left-side-main-container">
      <div class="icons-wrapper">
        <div
          @click="
            this.$router.push({
              name: 'assign-to-me-talks',
            })
          "
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
            {{ talkDetails?.created_by }}
          </span>
          <span class="dateHeading">{{
            formatDate(talkDetails?.created_at)
          }}</span>
          <span class="assignSpan" v-if="status === '1'">Ended</span>
          <span class="assignSpan" v-if="status === '2'">Completed</span>
          <span class="unassignSpan" v-if="status === '3'">Ongoing</span>
        </div>
        <div class="description-main-wrapper">
          <span class="bottom-des">Description</span>
          <span class="bottom-description">{{ talkDetails?.description }}</span>
        </div>
      </div>
    </div>
    <div class="right-side-main-container overflow-auto">
      <div class="updates-main-container">
        <span class="font-bold text-[18px]">Updates & Attachments</span>
        <div
          v-if="talkDetails.result_data !== 'passed' && status == '3'"
          class="flex gap-[12px] items-center justify-center mt-[32px]"
        >
          <span v-if="questionSheet.length > 0"
            >"Please
            {{
              file.length ? "read all the files" : "watch the video entirely"
            }}
            before starting the questions."</span
          >
          <span v-else
            >"Please
            {{
              file.length ? "read all the files" : "watch the video entirely"
            }}
            before acknowledging."</span
          >
          <button
            v-if="questionSheet.length > 0"
            class="bg-[#3cacfe] text-white h-[30px] px-[8px] rounded-[4px]! disabled:bg-[#bdbdbd] whitespace-nowrap"
            :disabled="disableStartButton"
            @click="
              () =>
                $router.push({
                  name: 'attempt-questions',
                  params: { id: $route.params.id },
                })
            "
          >
            Start Questions
          </button>
          <button
            v-else
            :disabled="disableStartButton"
            class="bg-[#42bd7c] h-[30px] px-2 text-white rounded-[4px]! float-end my-2 flex items-center disabled:bg-[#bdbdbd]"
            @click="handleAcknowledgeClick"
          >
            Acknowledge
          </button>
        </div>
        <!-- For video attachment -->
        <div
          v-if="attachmentType === 'VIDEO'"
          class="flex flex-col items-center gap-[40px] py-[20px]"
        >
          <video-player
            ref="videoPlayer"
            class="w-full! aspect-video h-full! max-w-[960px]"
            @ended="handleVideoEnded"
            :options="
              videoLink && {
                sources: [
                  {
                    type: videoLink?.type,
                    src: videoLink?.video_url,
                  },
                ],
              }
            "
          >
            <template v-slot="{ player, state }">
              <div
                class="absolute w-full h-full flex items-center justify-center group"
              >
                <button
                  v-if="state.playing"
                  class="group-hover:opacity-100! opacity-0 transition-all text-white bg-[#bdbdbd30]! border-2! border-white rounded-full! aspect-square p-2"
                >
                  <i
                    class="pi pi-pause fill-white text-lg"
                    @click="player.pause()"
                  ></i>
                </button>
                <button
                  v-else
                  class="text-white bg-[#bdbdbd30]! border-2! border-white rounded-full! aspect-square p-2"
                >
                  <i
                    class="pi pi-play translate-x-[2px] fill-white text-lg"
                    @click="player.play()"
                  ></i>
                </button>
              </div>
            </template>
          </video-player>
        </div>
        <!-- For PDF attachments -->
        <div
          class="flex mt-[24px] gap-[24px] justify-center"
          v-if="attachmentType === 'PDF'"
        >
          <div class="flex flex-col gap-[24px]">
            <div
              class="w-[90px] flex flex-col items-center bg-[#eee] rounded-[4px]! gap-[12px] py-[16px] px-[8px] hover:scale-105 transition-all relative"
              v-for="(pdf, pdfIdx) in file"
              @click="() => (selectedPDFIdx = pdfIdx)"
            >
              <i
                v-if="pdf.status"
                class="pi pi-check text-green-600 absolute top-2 left-2"
              ></i>
              <img
                src="/images/pdf.svg"
                class="object-contain"
                width="44"
                height="51"
              />
              <span class="overflow-hidden text-ellipsis max-w-full">
                {{ pdf.file_name }}
              </span>
            </div>
          </div>
          <div
            class="flex-1 overflow-auto"
            style="max-height: calc(100vh - 320px)"
            @scroll="handlePDFScroll"
          >
            <VuePdfEmbed
              class="w-full! h-full!"
              annotation-layer
              text-layer
              :source="file?.[selectedPDFIdx]?.file_url"
            />
          </div>
        </div>
        <div
          v-if="talkDetails.attempt || status == '2'"
          class="tableWrapperBox sign-off-wrapper pt-4"
        >
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
                    <span>{{
                      this.talkDetails.date
                        ? new Date(this.talkDetails.date).toLocaleDateString(
                            "en-GB"
                          )
                        : "N/A"
                    }}</span>
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
            ref="acknowlegde"
            v-if="status == '3'"
            :disabled="talkDetails.result_data !== 'passed'"
            class="bg-[#42bd7c] h-[30px] px-2 text-white rounded-[4px]! float-end my-2 flex items-center disabled:bg-[#bdbdbd]"
            @click="handleAcknowledgeClick"
          >
            Acknowledge
          </button>
        </div>
      </div>
    </div>
  </div>
  <!-- </div> -->
</template>

<script>
import { inject } from "vue";
import apiClient from "../router/axios";
import Swal from "sweetalert2";
import "videojs-youtube";
import VuePdfEmbed from "vue-pdf-embed";

export default {
  setup() {
    const showAlert = inject("showAlert");
    return { showAlert };
  },
  components: {
    VuePdfEmbed,
  },
  data() {
    return {
      selectedPDFIdx: 0, // selected pdf file for viewer
      disableStartButton: true, // disable start button state
      attachmentType: null, // attachment type, i.e., VIDEO , PDF
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
      videoLink: null,
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
  watch: {
    file: {
      handler(pdfs) {
        if (pdfs.length && !pdfs.some((file) => !file.status))
          this.disableStartButton = false;
      },
      deep: true,
    },
    talkDetails: {
      handler({ result_data }) {
        if (result_data === "passed") {
          console.log(this.$refs);
        }
      },
      deep: true,
    },
  },
  mounted() {
    this.getAssignedToMeById();
    this.getRolesAndPermission();
  },
  methods: {
    handlePDFScroll(e) {
      if (
        e.target.scrollHeight <
        e.target.scrollTop + e.target.clientHeight + 100
      )
        this.file[this.selectedPDFIdx].status = true;
    },
    async handleConfirmAcknowledge() {
      try {
        await apiClient.post("/acknowledged-status", {
          toolbox_talk_id: this.$route.params.id,
          status: 2,
        });
        this.getAssignedToMeById();
      } catch (err) {
        this.showAlert({
          title: "Error",
          description: "Failed to update status",
          type: "error",
        });
      }
    },
    handleAcknowledgeClick() {
      this.showAlert({
        title: "Confirm Acknowledgement",
        description:
          "Are you sure you want to sign and acknowledge this Toolbox Talk?",
        actions: [
          {
            label: "Cancel",
          },
          {
            label: "Yes",
            handler: () => this.handleConfirmAcknowledge(),
          },
        ],
      });
    },

    handleVideoEnded() {
      if (this.videoLink) this.disableStartButton = false;
    },
    // type can be Video / PDF

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
      const youtubeRegex =
        /^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|shorts\/|watch\?.+&v=))((?:\w|-){11})(?:\S+)?$/;

      const id = this.$route.params.id;
      try {
        const response = await apiClient.post(`/assignedtome`, {
          toolbox_talk_id: id,
        });
        this.talkDetails = response.data.assignToMeToolboxTalks;
        let videoType;
        if (youtubeRegex.test(this.talkDetails?.video_url?.[0]?.video_url))
          videoType = "video/youtube";
        else videoType = "video/mp4";

        this.videoLink = this.talkDetails?.video_url?.[0]
          ? {
              ...this.talkDetails?.video_url?.[0],
              type: videoType,
            }
          : null;

        this.file = this.talkDetails?.file_data || [];
        if (this.videoLink) this.attachmentType = "VIDEO";
        if (this.file.length) this.attachmentType = "PDF";

        this.status = response.data.assignToMeToolboxTalks.status;
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
  background-color: #fafafa;
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
  background-color: #e3f2ea;
  color: #14ae5c;
  font-size: smaller;
  padding: 0 15px;
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
