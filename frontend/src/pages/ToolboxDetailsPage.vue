<!-- @format -->

<template>
  <div class="cstm-cart">
    <h4 class="cart-title">Talk Details</h4>
    <div class="cstm-card-body">
      <div class="cstm-cart-row">
        <label class="csmt-label">Talk Title:</label>
        <span class="cstm-txt">{{ talkDetails.title }}</span>
      </div>
      <div class="cstm-cart-row align-items-start-mobile">
        <label class="csmt-label">Resource URL:</label>
        <a class="cstm-txt" :href="talkDetails.video_url">{{
          talkDetails.video_url
        }}</a>
      </div>
      <div class="cstm-cart-row">
        <label class="csmt-label">PDF:</label>
        <div class="card-pdf-file">
          <svg
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M6.66637 22.7679H17.3335C19.4129 22.7679 20.4475 21.7131 20.4475 19.6239V10.5034C20.4475 9.20743 20.3069 8.64514 19.5034 7.82143L13.9585 2.18657C13.1957 1.40271 12.5725 1.23214 11.4377 1.23214H6.66637C4.59723 1.23214 3.55237 2.29671 3.55237 4.38643V19.6239C3.55237 21.723 4.59723 22.7679 6.66637 22.7679ZM6.74651 21.1509C5.71194 21.1509 5.16937 20.598 5.16937 19.5939V4.41643C5.16937 3.42214 5.71194 2.84914 6.7568 2.84914H11.2165V8.68543C11.2165 9.951 11.8594 10.5737 13.1048 10.5737H18.8305V19.5939C18.8305 20.598 18.2978 21.1509 17.2534 21.1509H6.74651ZM13.2857 9.05657C12.8939 9.05657 12.7328 8.89628 12.7328 8.49428V3.16071L18.5185 9.057L13.2857 9.05657ZM15.6964 13.3359H8.07208C7.7108 13.3359 7.4498 13.6071 7.4498 13.9487C7.4498 14.3001 7.71123 14.5714 8.07251 14.5714H15.6964C15.7785 14.5728 15.8601 14.5576 15.9362 14.5267C16.0124 14.4959 16.0816 14.4501 16.1397 14.392C16.1978 14.3339 16.2436 14.2647 16.2744 14.1886C16.3052 14.1124 16.3204 14.0309 16.3191 13.9487C16.3191 13.6071 16.0478 13.3359 15.6964 13.3359ZM15.6964 16.8416H8.07208C7.7108 16.8416 7.4498 17.1227 7.4498 17.4741C7.4498 17.8157 7.71123 18.0771 8.07251 18.0771H15.6964C16.0478 18.0771 16.3191 17.8157 16.3191 17.4741C16.3191 17.1227 16.0478 16.8416 15.6964 16.8416Z"
              fill="#C37B79"
            />
          </svg>
          <span>{{ talkDetails.file.split("/").pop() }}</span>
        </div>
      </div>
      <div class="cstm-cart-row">
        <label class="csmt-label">Due Date:</label>
        <span class="cstm-txt">{{
          new Date(talkDetails.due_date).toLocaleDateString()
        }}</span>
      </div>
      <div class="cstm-cart-row">
        <label class="csmt-label">Add Toolbox Talk in CMS Library:</label>
        <span class="cstm-txt">{{
          talkDetails.is_library ? "Yes" : "No"
        }}</span>
      </div>
    </div>
    <h4 class="cart-title">Questions</h4>
    <div class="question-box">
      <div
        class="question-items"
        v-for="(question, index) in talkDetails.questions"
        :key="question.id"
      >
        <div class="question-with-answe">
          <div class="quest">Question {{ index + 1 }}:</div>
          <div class="answer-bx">
            <p>{{ question.name }}</p>
            <div class="options-box-wrp">
              <div
                class="option-card"
                v-for="(option, index) in question.options"
                :key="option.id"
              >
                <label>Option {{ index + 1 }} :</label>
                <span>{{ option.name }}</span>
              </div>
            </div>
          </div>
        </div>
        <div class="right-aswer-bx">
          <label>Correct Answer:</label>
          <span
            >Option
            {{
              question.options.find((option) => option.correct_answer === "1")
                .name
            }}</span
          >
        </div>
      </div>
    </div>
    <h4 class="cart-title mt-8px">Recipients</h4>
    <div class="cstm-card-body res-cart">
      <div class="cstm-cart-row">
        <label class="csmt-label">Departments:</label>
        <div class="cstm-box-cart-row">
          <span v-for="role in talkDetails.get_assign_role" :key="role.id"
            ><p v-if="role.get_role">{{ role.get_role.name }}</p></span
          >
        </div>
      </div>
      <div class="cstm-cart-row">
        <label class="csmt-label">Roles:</label>
        <div class="cstm-box-cart-row">
          <span
            v-for="permission in talkDetails.get_assign_role"
            :key="permission.id"
            ><p v-if="permission.get_permission">
              {{ permission.get_permission.name }}
            </p></span
          >
          <span class="act">View All</span>
        </div>
      </div>
      <div class="cstm-cart-row align-items-start">
        <label class="csmt-label">Users:</label>
        <div class="cstm-box-cart-row">
          <span v-for="role in talkDetails.get_assign_role" :key="role.id"
            >User ID: {{ role.user_id }}</span
          >
        </div>
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
      talkDetails: {},
    };
  },
  mounted() {
    this.getDetailsToolboxTalk();
  },
  methods: {
    async getDetailsToolboxTalk() {
      const id = this.$route.params.id;
      try {
        const response = await apiClient.get(`/toolbox-talk/${id}`);
        this.talkDetails = response.data.talkDetails;
      } catch (error) {
        console.error("Error fetching toolbox talk:", error);
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "Could not fetch toolbox talk details",
        });
      }
    },
  },
};
</script>

<style scoped>
* {
  margin: 0;
  padding: 0;
  font-family: "Lato", sans-serif;
  box-sizing: border-box;
}
body {
  background-color: #f4f4f7;
}
.cstm-cart {
  max-width: 1212px;
  margin: 80px auto 0;
  box-shadow: 0px 0px 15.9px 6px rgb(0, 0, 0, 0.07);
  padding: 30px;
  border-radius: 12px;
  background-color: white;
}
h4.cart-title {
  background: #f5f5f5;
  font-weight: 600;
  font-size: 22px;
  padding: 12px 30px;
  border-radius: 8px 8px 0 0;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

h4.cart-title:has(butto.attempt-ques) {
  padding: 8px 16px;
}
.cstm-card-body .cstm-cart-row {
  padding: 0px 30px;
  border-bottom: 1px solid #dddddd;
  min-height: 60px;
  display: flex;
  align-items: center;
  gap: 14px;
}
.cstm-card-body {
  display: flex;
  flex-direction: column;
}
.cstm-card-body .cstm-cart-row label.csmt-label {
  color: #1f1b1b;
  font-size: 18px;
  font-weight: 600;
  padding: 18px 0;
  white-space: nowrap;
}
.cstm-card-body .cstm-cart-row span.cstm-txt {
  font-weight: 500;
  font-size: 16px;
  color: #444444;
}
.cstm-card-body .cstm-cart-row a.cstm-txt {
  color: #6191d0;
  font-size: 16px;
  font-weight: 500;
  text-decoration: underline;
}
.cstm-card-body .cstm-cart-row .card-pdf-file {
  display: flex;
  align-items: center;
  gap: 8px;
  border: 1px solid #dadada;
  padding: 0px 10px;
  border-radius: 4px;
}
.cstm-card-body .cstm-cart-row .card-pdf-file span {
  padding: 10px 0;
}
.cstm-card-body .cstm-cart-row:last-child {
  border: 0;
}
.question-box {
  display: flex;
  flex-direction: column;
}
.question-box .question-items {
  padding: 22px 30px 22px;
  border-bottom: 1px solid #dddddd;
}
.question-box .question-items .question-with-answe {
  display: flex;
  gap: 8px;
  padding-bottom: 32px;
}
.question-box .question-items .question-with-answe .quest {
  white-space: nowrap;
  font-weight: 700;
  color: #1f1b1b;
  font-size: 18px;
}
.question-box .question-items .question-with-answe .answer-bx > p {
  margin-bottom: 26px;
  color: #444444;
  font-size: 16px;
  line-height: 26px;
}
.question-box .question-items .question-with-answe .answer-bx .options-box-wrp {
  display: flex;
  flex-wrap: wrap;
  row-gap: 8px;
}
.question-box
  .question-items
  .question-with-answe
  .answer-bx
  .options-box-wrp
  .option-card {
  width: 50%;
  display: flex;
  gap: 8px;
}
.question-box
  .question-items
  .question-with-answe
  .answer-bx
  .options-box-wrp
  .option-card:nth-child(even) {
  justify-content: end;
  display: flex;
}
.question-box
  .question-items
  .question-with-answe
  .answer-bx
  .options-box-wrp
  .option-card
  label {
  color: #3a3939;
  font-weight: 700;
  font-size: 16px;
}
.question-box
  .question-items
  .question-with-answe
  .answer-bx
  .options-box-wrp
  .option-card
  span {
  color: #444444;
  line-height: 26px;
  font-size: 16px;
}
.question-box .question-items .right-aswer-bx {
  background: #f5f5f5;
  padding: 10px 22px;
  border-radius: 4px;
  display: flex;
  align-items: center;
  gap: 10px;
}
.question-box .question-items .right-aswer-bx label {
  color: #3a3939;
  font-weight: 700;
  font-size: 18px;
}
.question-box .question-items .right-aswer-bx span {
  color: #444444;
  font-size: 16px;
}
.question-box .question-items:last-child {
  border: 0;
}
.mt-8px {
  margin-top: 8px;
}
.cstm-box-cart-row {
  display: flex;
  gap: 8px;
  padding: 18px 0px;
  flex-wrap: wrap;
}
.cstm-box-cart-row span {
  cursor: pointer;
  border-radius: 4px;
  border: 1px solid #e3e3e3;
  padding: 10px 8px;
}
.cstm-box-cart-row span:hover {
  background-color: #eaf3ff;
  border-color: #6191d0;
  color: #5379ac;
}
.cstm-box-cart-row span.act {
  background-color: #eaf3ff;
  border-color: #6191d0;
  color: #5379ac;
  font-size: 14px;
}
.cstm-cart-row.align-items-start {
  align-items: flex-start;
}
.attempt-ques {
  font-size: 16px;
  font-weight: 500;
  line-height: 26px;
  color: #fff;
  background-color: #72b974;
  padding: 12px 16px;
  border-radius: 4px;
}

@media (max-width: 767px) {
  .cstm-card-body .cstm-cart-row a.cstm-txt {
    word-break: break-all;
    padding: 16px 0px;
  }
  .question-box .question-items .question-with-answe {
    flex-direction: column;
    padding-bottom: 20px;
  }
  .question-box
    .question-items
    .question-with-answe
    .answer-bx
    .options-box-wrp
    .option-card {
    width: 100%;
  }
  .question-box
    .question-items
    .question-with-answe
    .answer-bx
    .options-box-wrp
    .option-card:nth-child(even) {
    justify-content: flex-start;
  }
  .cstm-card-body.res-cart .cstm-cart-row {
    flex-direction: column;
    align-items: flex-start;
  }
  .cstm-card-body.res-cart .cstm-cart-row label.csmt-label {
    padding-bottom: 0;
  }
  .cstm-card-body.res-cart .cstm-cart-row .cstm-box-cart-row {
    padding-top: 0;
  }
  .cstm-cart {
    width: calc(100% - 20px);
    margin-top: 20px;
    margin-bottom: 20px;
    padding: 14px 8px;
  }
  .cstm-card-body .cstm-cart-row {
    padding: 0px 16px;
  }
  h4.cart-title {
    padding: 12px 16px;
  }
  .align-items-start-mobile {
    align-items: flex-start !important;
  }
}
</style>
