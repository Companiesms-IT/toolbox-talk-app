<template>
  <div class="dashboardbody">
    <div class="left-side-main-container">
      <div class="icons-wrapper">
        <a href="javascript:void(0)" class="iconBTN">
          <i class="fa-solid fa-chevron-left"></i>
        </a>
        <a href="javascript:void(0)" class="iconBTN">
          <i class="fa-solid fa-arrow-up-right-from-square"></i>
        </a>
      </div>
      <div class="details-wrapper">
        <div class="details-main-wrapper">
          <span class="mianHeading">Toolbox123</span>
          <span class="createdByHeading">Created by John Rhys Smith </span>
          <span class="dateHeading">01/01/2025</span>
          <span class="assignSpan">Assigned</span>
        </div>
        <div class="description-main-wrapper">
          <span class="bottom-des">Description</span>
          <span class="bottom-description"
            >This talk covers essential safety measures when working at heights,
            including the use of protective equipment, proper setup of ladders
            and scaffolding, and awareness of potential fall hazards.</span
          >
        </div>
      </div>
    </div>
    <div class="right-side-main-container">
      <div class="updates-main-container">
        <div class="headingContainer">
          <span>Updates & Attachments</span>
          <!-- <div class="optionsContainer">
            <button class="submitButton">Submit</button>
            <div class="cstmInputBox sendButtonWrapper">
              <select class="form-select sendButtonWrapper">
                <option hidden="">Send</option>
                <option value="Save in Library">Save in Library</option>
                <option value="Send & Save">Send & Save</option>
              </select>
            </div>
          </div> -->
          <button class="copy-btn">Make a copy</button>
        </div>
        <div class="options-main-container">
          <div class="commonContainer">
            <div class="uploadWrapper">
              <span class="uplaodHead">Upload Attachments</span>
              <span class="attactmentSpan">2 Attachments</span>
            </div>
          </div>
          <button class="editButton" @click="showDocumentsPopup">
            Preview
          </button>
          <div class="commonContainer">
            <span class="uplaodHead">Question Sheet</span>
          </div>
          <button class="editButton" @click="showQuesPopup">Preview</button>
        </div>
      </div>
    </div>
    <div v-if="showPopup" class="popup-overlay">
      <div class="first-container">
        <div class="main-heading-wrapper">
          <span class="main-heading-span">Create New Question Sheet</span>
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
              <option value="">Number</option>
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
              <option value="">Number</option>

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
            v-for="(question, index) in questions"
            :key="index"
          >
            <div class="question-wrapper">
              <span class="question-span">Question {{ index + 1 }}</span>
              <input
                v-model="question.text"
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
                    <span style="color: red" v-if="optIndex < 2">*</span>
                  </label>
                  <input
                    type="text"
                    :id="`option${index}-${optIndex}`"
                    v-model="question.options[optIndex]"
                    class="question-input"
                    :required="optIndex < 2"
                  />
                  <!-- <span v-if="
											submitted && optIndex < 2 && !question.options[optIndex]
										" class="error-message">
											Option {{ optIndex + 1 }} is required
										</span> -->
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
                <option value="">Select Correct Choice</option>

                <option value="1">A</option>
                <option value="2">B</option>
                <option value="3">C</option>
                <option value="4">D</option>
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
        <button class="cancel-btn" @click="showPopup = false" type="button">
          Cancel
        </button>
        <button class="create-btn" @click="showPopup = false" type="button">
          Create Question Sheet
        </button>
      </div>
    </div>

    <div
      class="upload-main-container-popup"
      v-if="documentPopup"
      @click.self="removePopup"
    >
      <div class="upload-first-container">
        <div class="main-heading-wrapper">
          <span class="main-heading-span">Video</span>
        </div>
        <div class="link-wrapper">
          <span>Video Link</span>
          <span>https://www.youtube.com/watch?v=W4YG7y8IfE8</span>
          <button
            class="trash-button"
            @click="removeQuestion(index)"
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
        <div class="pdf-wrapper">
          <div>
            <img src="/images/PDF.png" class="document-img" />
          </div>
          <div>
            <img src="/images/PDF.png" class="document-img" />
          </div>
          <div>
            <img src="/images/PDF.png" class="document-img" />
          </div>
        </div>
        <button type="button" @click="goBack" class="backBtnEnd">
          Go Back
        </button>
      </div>
    </div>
  </div>
  <!-- </div> -->
</template>

<script>
export default {
  data() {
    return {
      documentPopup: false,
      errorPop: false,
      totalQuestions: "",
      correctAnswers: "",
      showPopup: false,
          questions: [
        {
          text: "",
          options: ["", "", "", ""],
          correctAnswer: null,
        },
      ],
    };
  },
  methods: {
    removePopup() {
      this.documentPopup = false;
    },
    goBack() {
      this.documentPopup = false;
    },
    showDocumentsPopup() {
      this.documentPopup = true;
    },
    showQuesPopup() {
      this.showPopup = true;
      this.buttonValue = "Edit";
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
.dashboardbody {
  height: 960px;
  background-color: #eeeeee;
  overflow: hidden;
  border-radius: 15px;
  display: flex;
  gap: 15px;
  flex-direction: row;
}

.left-side-main-container {
  width: 25%;
  height: 940px;
  border-radius: 25px;
  padding-top: 10px;
  padding-bottom: 10px;
  background-color: white;
}

.right-side-main-container {
  background-color: white;
  width: 75%;
  border-radius: 25px;
  height: 940px;
  border-radius: 25px;
  padding-bottom: 10px;
  padding-top: 20px;
  padding-left: 20px;
  padding-right: 20px;
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
  height: 850px;
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
  justify-content: space-evenly;
  border-radius: 10px;
  width: 95%;
  align-self: anchor-center;
  padding-right: 10px;
  padding-left: 10px;
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
  height: 22px;
  width: 80px;
  background-color: #e3f2ea;
  color: #14ae5c;
  font-size: smaller;
  /* padding-left: 5px; */
  border-radius: 5px;
  display: flex;
  justify-content: center;
  align-items: center;
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

/* .optionsContainer {
  display: flex;
  flex-direction: row;
  width: 230px;
  height: 30px;
  gap: 10px;
} */

/* .submitButton {
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
} */

/* .sendButtonWrapper {
  height: 30px;
  width: 120px;
  border: none;
  background-color: #e1e1e1;
  color: #9e9e9e;
  border-radius: 5px;
  cursor: pointer;
} */

.options-main-container {
  height: 277px;
  display: flex;
  flex-direction: column;
  justify-content: space-around;
}

.editButton {
  width: 75px;
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
  justify-content: space-between;
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
  justify-content: space-between;
  padding-right: 10px;
}

.secondDocumentWrapper {
  height: 185px;
}

.pdf-wrapper {
}

.backBtnEnd {
  display: flex;
  justify-self: end;
  margin-right: 15px;
  border: none;
  border-radius: 5px;
  height: 30px;
  align-items: center;
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
</style>
