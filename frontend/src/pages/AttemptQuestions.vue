<script setup>
import { RadioGroupIndicator, RadioGroupItem, RadioGroupRoot } from "radix-vue";
import { inject, onMounted, ref } from "vue";
import apiClient from "../router/axios";
import { useRoute, useRouter } from "vue-router";

const questions = ref([]);
const correctAnswersRequired = ref("");
const router = useRouter();
const route = useRoute();

const showAlert = inject("showAlert");

const getQuestions = async () => {
  try {
    const { data } = await apiClient.post("/get-questions-options", {
      toolbox_talk_id: route.params.id,
    });
    questions.value = data.data.questions.map((question) => ({
      ...question,
      answer: null,
    }));
    correctAnswersRequired.value =
      data.data.number_of_correct_answer_to_pass || "";
  } catch (err) {
    console.error(err);
  }
};

const handleCancel = () => {
  router.push({
    name: "update-attachments",
    params: { id: route.params.id },
  });
};

const handleSubmit = async () => {
  try {
    if (questions.value.some((question) => !question.answer)) {
      showAlert({
        title: "Error",
        description: "Please select an answer for each question",
        type: "error",
      });
      return;
    }
    const { data } = await apiClient.post("/attempt-questions", {
      toolbox_talk_id: route.params.id,
      questions: JSON.stringify(
        questions.value
          .filter((question) => question.answer)
          .map((question) => ({
            question_id: question.id,
            answer: question.answer,
          }))
      ),
    });

    const totalQuestions = data.data[0].result_data_count.number_of_attempted;
    const numberOfCorrectAnswer =
      data.data[0].result_data_count.number_of_passed;
    if (data.result.status === "passed") {
      router.push({
        name: "update-attachments",
        params: { id: route.params.id },
      });
      showAlert({
        title: "Great Job! You Passed",
        description: `You answered ${numberOfCorrectAnswer} out of ${totalQuestions} questions correctly.<br /><br />You can now proceed to sign and submit the Toolbox Talk.`,
        type: "success",
        actions: [
          {
            label: "OK",
            handler: () => {
              router.push({
                name: "update-attachments",
                params: { id: route.params.id },
              });
            },
          },
        ],
      });
    } else
      showAlert({
        title: "You Didn’t Pass",
        description: `You answered ${numberOfCorrectAnswer} out of ${totalQuestions} questions correctly.<br /><br />You must answer ${correctAnswersRequired.value} questions correctly to pass. Please review content and try again.`,
        type: "error",
        actions: [
          {
            label: "Go back",
            handler: () => {
              router.push({
                name: "update-attachments",
                params: { id: route.params.id },
              });
            },
          },
          {
            label: "Try again",
          },
        ],
      });
  } catch (err) {
    showAlert({
      title: "Error",
      description: err.response.data.message,
      type: "error",
    });
  }
};

onMounted(() => {
  getQuestions();
});
</script>

<template>
  <main
    class="dashboardbody bg-[#fafafa] rounded-[12px] px-0 overflow-auto"
    style="height: calc(100vh - 116px)"
  >
    <div class="px-[15px]">
      <h3 class="text-[20px] font-bold! text-black mb-[32px]!">
        Question Sheet
      </h3>
      <span
        >Number of Correct Answers Required to Pass:
        {{ correctAnswersRequired }}</span
      >
    </div>
    <hr />
    <div
      v-for="(question, questionIdx) in questions"
      class="border-b border-[#bdbdbd] px-[15px] py-[15px]"
    >
      <p>
        <span class="font-bold">Question {{ questionIdx + 1 }}:</span>
        {{ question.name }}
      </p>
      <RadioGroupRoot
        :id="question.id"
        v-model="question.answer"
        class="flex flex-col gap-[8px]"
      >
        <div
          v-for="(option, optionIdx) in question.options"
          class="flex gap-[8px] items-center"
        >
          <RadioGroupItem
            :value="option.id"
            class="w-[18px] h-[18px] border rounded-full!"
            :id="String.fromCharCode(65 + optionIdx)"
          >
            <RadioGroupIndicator
              class="flex items-center justify-center w-full h-full relative after:content-[''] after:block after:w-[11px] after:h-[11px] after:rounded-[50%] after:bg-[#6366f1]"
            />
          </RadioGroupItem>
          {{ option.name }}
        </div>
      </RadioGroupRoot>
    </div>
    <div class="flex justify-center gap-[16px] mt-[40px]">
      <button
        @click="handleCancel"
        class="bg-[#7d7d7d] text-white rounded-[4px]! px-[12px] py-[4px]"
      >
        Cancel
      </button>
      <button
        @click="handleSubmit"
        class="bg-[#0d99ff] text-white rounded-[4px]! px-[12px] py-[4px]"
      >
        Submit
      </button>
    </div>
  </main>
</template>
