<!-- @format -->

<template>
  <div class="dashboard-container">
    <div class="main-section">
      <div class="content-area">
        <h2 class="section-title">Update Toolbox Talk</h2>
        <form @submit.prevent="submitForm" class="toolbox-form">
          <div class="form-section">
            <h3>Talk Details</h3>
            <div class="form-grid">
              <div class="form-group">
                <label for="talkTitle"
                  >Talk Title <span class="required">*</span></label
                >
                <input
                  type="text"
                  id="talkTitle"
                  v-model="talkDetails.title"
                  :class="{ 'input-error': submitted && !talkDetails.title }"
                  placeholder="Enter talk title"
                  required
                />
                <span
                  v-if="submitted && !talkDetails.title"
                  class="error-message"
                >
                  Talk title is required
                </span>
              </div>
              <div class="form-group">
                <label for="video_url">Resource URL</label>
                <input
                  type="url"
                  id="video_url"
                  v-model="talkDetails.video_url"
                  placeholder="Enter Video URL"
                />
                <a
                  v-if="talkDetails.video_url"
                  :href="talkDetails.video_url"
                  target="_blank"
                  >View</a
                >
              </div>
              <div class="form-group">
                <label for="upload_pdf">Upload Pdf</label>
                <input type="file" id="upload_pdf" @change="handleFileUpload" />
                <a
                  v-if="talkDetails.file"
                  :href="
                    'https://companiesmanagementsystems-back-uat.chetu.com/storage/' +
                    talkDetails.file
                  "
                  target="_blank"
                  >View</a
                >
              </div>
            </div>
          </div>
          <div class="form-section">
            <div class="section-header">
              <h3>Questions</h3>
              <button
                style="margin-bottom: 8px"
                type="button"
                class="btn btn-secondary"
                @click="addNewQuestion"
                :disabled="questions.length >= 10"
              >
                + Add Question
              </button>
            </div>
            <div
              v-for="(question, index) in questions"
              :key="index"
              class="question-card"
            >
              <div class="question-header">
                <h4>Question {{ index + 1 }}</h4>
                <button
                  type="button"
                  class="btn btn-remove"
                  @click="removeQuestion(index)"
                  v-if="questions.length > 1"
                >
                  Remove
                </button>
              </div>
              <div class="form-group">
                <label :for="`questionText${index}`"
                  >Question Text <span class="required">*</span></label
                >
                <input
                  type="text"
                  :id="`questionText${index}`"
                  v-model="question.text"
                  :class="{ 'input-error': submitted && !question.text }"
                  placeholder="Enter question"
                  required
                />
                <span v-if="submitted && !question.text" class="error-message">
                  Question text is required
                </span>
              </div>
              <div class="options-section">
                <h5>Options</h5>
                <div class="options-grid">
                  <div
                    v-for="(option, optIndex) in question.options"
                    :key="optIndex"
                    class="form-group"
                  >
                    <label :for="`option${index}-${optIndex}`">
                      Option {{ optIndex + 1 }}
                      <span class="required">*</span>
                    </label>
                    <input
                      type="text"
                      :id="`option${index}-${optIndex}`"
                      v-model="question.options[optIndex]"
                      :class="{
                        'input-error': submitted && !question.options[optIndex],
                      }"
                      :placeholder="`Option ${optIndex + 1}`"
                      required
                    />
                    <span
                      v-if="submitted && !question.options[optIndex]"
                      class="error-message"
                    >
                      Option is required
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label :for="`correctAnswer${index}`"
                  >Correct Answer <span class="required">*</span></label
                >
                <select
                  :id="`correctAnswer${index}`"
                  v-model="question.correctAnswer"
                  :class="{
                    'input-error': submitted && question.correctAnswer === null,
                  }"
                  required
                >
                  <option value="" disabled>Select Correct Answer</option>
                  <option
                    v-for="(option, optIndex) in question.options"
                    :key="optIndex"
                    :value="optIndex"
                  >
                    Option {{ optIndex + 1 }}
                  </option>
                </select>
                <span
                  v-if="submitted && question.correctAnswer === null"
                  class="error-message"
                >
                  Correct answer is required
                </span>
              </div>
            </div>
          </div>
          <div class="form-actions">
            <button type="button" class="btn btn-secondary" @click="resetForm">
              Reset
            </button>
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
import apiClient from "axios";
import Swal from "sweetalert2";
export default {
  data() {
    return {
      submitted: false,
      talkDetails: {
        title: "",
        video_url: "",
        upload_pdf: "",
      },
      questions: [],
    };
  },
  mounted() {
    this.fetchToolboxTalk();
  },
  methods: {
    handleFileUpload(event) {
      this.talkDetails.upload_pdf = event.target.files[0];
    },
    async fetchToolboxTalk() {
      const id = this.$route.params.id;
      try {
        const response = await apiClient.get(`/toolbox-talk/${id}`);
        const { title, video_url, file, questions } = response.data.talkDetails;
        this.talkDetails.title = title;
        this.talkDetails.video_url = video_url;
        this.talkDetails.file = file;
        this.questions = questions.map((question) => ({
          text: question.name,
          options: question.options.map((option) => option.name),
          correctAnswer: question.options.findIndex(
            (opt) => opt.correct_answer == 1
          ),
        }));
      } catch (error) {
        console.error("Error fetching toolbox talk:", error);
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "Could not fetch toolbox talk details",
        });
      }
    },
    addNewQuestion() {
      if (this.questions.length < 10) {
        this.questions.push({
          text: "",
          options: ["", "", "", ""],
          correctAnswer: null,
        });
      }
    },
    removeQuestion(index) {
      if (this.questions.length > 1) {
        this.questions.splice(index, 1);
      }
    },
    resetForm() {
      this.submitted = false;
      this.talkDetails = {
        title: "",
        video_url: "",
        upload_pdf: "",
      };
      this.questions = [];
    },
    async submitForm() {
      this.submitted = true;
      const isValid = this.validateForm();
      if (isValid) {
        const formData = new FormData();
        formData.append("title", this.talkDetails.title);
        formData.append("resource_url", this.talkDetails.video_url || "");
        if (this.talkDetails.upload_pdf) {
          formData.append("file", this.talkDetails.upload_pdf);
        }
        formData.append("questions", JSON.stringify(this.questions));
        const id = this.$route.params.id; // Get the ID from the route params
        try {
          await apiClient.put(`/toolboxtalk/${id}`, formData);
          Swal.fire({
            icon: "success",
            title: "Toolbox Talk Updated",
            text: "Your toolbox talk has been successfully updated!",
          });
          this.resetForm();
          setTimeout(() => {
            this.$router.push("/toolbox-talks");
          }, 1500);
        } catch (error) {
          console.error("Update error:", error);
          Swal.fire({
            icon: "error",
            title: "Update Failed",
            text:
              error.response?.data?.message ||
              "An error occurred while updating the form",
          });
        }
      }
    },
    validateForm() {
      if (!this.talkDetails.title) {
        Swal.fire({
          icon: "warning",
          title: "Incomplete Form",
          text: "Please fill in all required fields",
        });
        return false;
      }
    },
  },
};
</script>

<style scoped>
/* Sidebar Styles */
.dashboard-container {
  display: flex;
  height: 100vh;
  background-color: #f4f4f7;
  gap: 16px;
}
/* Topbar Styles */
.topbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  height: 70px;
  background-color: white;
  padding: 0 24px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.title {
  display: flex;
  align-items: center;
}

.title-bold {
  font-size: 20px;
  font-weight: 700;
  color: #1e1e2d;
}

.topbar-icons {
  display: flex;
  align-items: center;
  gap: 16px;
}

.circle-icon {
  width: 40px;
  height: 40px;
  background-color: #f3f6f9;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.circle-icon:hover {
  background-color: #e4e6ef;
}

.circle-icon i {
  color: #3699ff;
  font-size: 18px;
}

/* Main Section */
.main-section {
  flex-grow: 1;
  overflow-y: auto;
  background-color: #f4f4f7;
}

.content-area {
  padding: 24px;
}

.section-title {
  color: #1e1e2d;
  margin-bottom: 24px;
  font-size: 22px;
  font-weight: 600;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
  .dashboard-container {
    flex-direction: column;
  }

  .topbar {
    padding: 0 16px;
  }
}
.toolbox-form {
  background-color: white;
  border-radius: 12px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
  padding: 32px;
  margin: 0 auto;
}

/* Form Sections */
.form-section {
  margin-bottom: 32px;
  padding-bottom: 24px;
  border-bottom: 1px solid #e9ecef;
}

.form-section h3 {
  color: #2c3e50;
  font-size: 18px;
  font-weight: 600;
  margin-bottom: 20px;
  display: flex;
  align-items: center;
}

.form-section h3::before {
  content: "";
  display: inline-block;
  width: 6px;
  height: 20px;
  background-color: #6b21a8;
  margin-right: 12px;
  border-radius: 3px;
}

/* Form Grid */
.form-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
}

/* Form Group */
.form-group {
  display: flex;
  flex-direction: column;
}

.form-group label {
  margin-bottom: 8px;
  color: #495057;
  font-weight: 500;
  font-size: 14px;
}

.form-group input,
.form-group select {
  padding: 12px 16px;
  border: 2px solid #e9ecef;
  border-radius: 8px;
  font-size: 15px;
  transition: all 0.3s ease;
}

.form-group input:focus,
.form-group select:focus {
  border-color: #6b21a8;
  outline: none;
  box-shadow: 0 0 0 3px rgba(107, 33, 168, 0.1);
}

/* Error States */
.input-error {
  border-color: #dc3545 !important;
}

.error-message {
  color: #dc3545;
  font-size: 12px;
  margin-top: 6px;
  animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Question Card */
.question-card {
  background-color: #f8f9fa;
  border-radius: 10px;
  padding: 24px;
  margin-bottom: 20px;
  border: 1px solid #e9ecef;
  transition: all 0.3s ease;
}

.question-card:hover {
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.question-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.question-header h4 {
  color: #2c3e50;
  display: flex;
  align-items: center;
}

.question-header h4::before {
  content: "";
  display: inline-block;
  width: 4px;
  height: 16px;
  background-color: #6b21a8;
  margin-right: 10px;
  border-radius: 2px;
}

/* Options Grid */
.options-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 16px;
}

.recipient-item {
  display: flex;
  align-items: center;
  background-color: #f8f9fa;
  padding: 10px;
  border-radius: 6px;
  transition: background-color 0.3s ease;
}

.recipient-item:hover {
  background-color: #e9ecef;
}

/* Buttons */
.form-actions {
  display: flex;
  justify-content: flex-end;
  gap: 16px;
  margin-top: 24px;
}

.btn {
  padding: 12px 24px;
  border-radius: 8px;
  font-weight: 600;
  transition: all 0.3s ease;
}

.btn-primary {
  background-color: #6b21a8;
  color: white;
  border: none;
}

.btn-primary:hover {
  background-color: #5a189a;
}

.btn-secondary {
  background-color: #f8f9fa;
  color: #495057;
  border: 2px solid #e9ecef;
}

.btn-secondary:hover {
  background-color: #e9ecef;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
  .form-grid,
  .options-grid,
  .recipients-grid {
    grid-template-columns: 1fr;
  }
}
</style>
