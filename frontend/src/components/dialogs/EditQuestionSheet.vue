<script setup>
import {
  DialogClose,
  DialogContent,
  DialogOverlay,
  DialogPortal,
  DialogRoot,
  DialogTrigger,
  RadioGroupIndicator,
  RadioGroupItem,
  RadioGroupRoot,
} from "radix-vue";
import Dropdown from "../dropdown.vue";
import { reactive, ref, watch } from "vue";
import apiClient from "../../router/axios";
import { useToast } from "../../hooks/useToast";

const {
  questions,
  initialQuestionsToAskCount,
  initialCorrectAnswersRequiredCount,
  toolboxTalkId,
  getDetailsToolboxTalk,
} = defineProps([
  "initialQuestionsToAskCount",
  "initialCorrectAnswersRequiredCount",
  "questions",
  "handleDeleteQuestion",
  "toolboxTalkId",
  "getDetailsToolboxTalk",
]);

const questionsToAskCount = ref(initialQuestionsToAskCount);
const correctAnswersRequiredCount = ref(initialCorrectAnswersRequiredCount);
const updatedQuestions = ref(questions);
const newQuestions = ref([]);
const loadingSaveQuestions = ref(false);
const openDialog = ref(false);

const { addToast } = useToast();

const handleDeleteNewQuestion = (idx) => {
  newQuestions.value.splice(idx, 1);
};

const handleAddNewQuestion = () => {
  if (updatedQuestions.value.length + newQuestions.value.length < 10)
    newQuestions.value.push({
      name: "",
      options: ["", "", "", ""],
      correctAnswer: "",
    });
};

const validationCheck = () => {
  if (!questionsToAskCount.value) {
    addToast({
      title: "Error",
      description: "Please select the number of questions to ask",
      type: "error",
    });
    return false;
  }
  if (!correctAnswersRequiredCount.value) {
    addToast({
      title: "Error",
      description: "Please select the number of correct answers required",
      type: "error",
    });
    return false;
  }
  if (
    questionsToAskCount.value >
    newQuestions.value.length + updatedQuestions.value.length
  ) {
    addToast({
      title: "Error",
      description: "You have selected more questions than you have created",
      type: "error",
    });
    return false;
  }
  if (
    correctAnswersRequiredCount.value >
    newQuestions.value.length + updatedQuestions.value.length
  ) {
    addToast({
      title: "Error",
      description:
        "You have selected more correct answers than you have created",
      type: "error",
    });
    return false;
  }

  if (correctAnswersRequiredCount.value > questionsToAskCount.value) {
    addToast({
      title: "Error",
      description: "You have selected more correct answers than questions",
      type: "error",
    });
    return false;
  }

  if (newQuestions.value.some((ques) => ques.name.length === 0)) {
    addToast({
      title: "Error",
      description: "Please enter a question name",
      type: "error",
    });
    return false;
  }
  if (
    newQuestions.value.some(
      (ques) => ques.options[0].length === 0 || ques.options[1].length === 0
    )
  ) {
    addToast({
      title: "Error",
      description: "Please fill atleast two options for each question",
      type: "error",
    });
    return false;
  }
  if (
    newQuestions.value.some(
      (ques) => !ques.correctAnswer || ques.correctAnswer.length === 0
    )
  ) {
    addToast({
      title: "Error",
      description: "Please select the correct answer for each question",
      type: "error",
    });
    return false;
  }
  return true;
};

const handleSave = async () => {
  try {
    if (!validationCheck()) return;
    loadingSaveQuestions.value = true;
    await apiClient.post("/update-questions", {
      toolbox_talk_id: toolboxTalkId,
      questions: JSON.stringify(updatedQuestions.value),
      new_questions: JSON.stringify(newQuestions.value),
      attemptQuestions: questionsToAskCount.value,
      number_of_correct_answer_to_pass: correctAnswersRequiredCount.value,
    });
    await getDetailsToolboxTalk();
    newQuestions.value = [];
    addToast({
      title: "Success",
      description: "Questions saved successfully.",
      type: "success",
    });
    openDialog.value = false;
  } catch (err) {
    console.log(err);
  }
  loadingSaveQuestions.value = false;
};

watch(
  () => questions,
  (newValue) => {
    updatedQuestions.value = newValue;
  }
);

watch(
  () => initialQuestionsToAskCount,
  (newValue) => (questionsToAskCount.value = newValue)
);

watch(
  () => initialCorrectAnswersRequiredCount,
  (newValue) => (correctAnswersRequiredCount.value = newValue)
);
</script>

<template>
  <DialogRoot
    :open="openDialog"
    v-on:update:open="(value) => (openDialog = value)"
  >
    <DialogTrigger
      class="w-fit bg-[#3cacfe] text-white h-[30px] px-3 rounded mx-2"
    >
      Edit
    </DialogTrigger>
    <DialogPortal>
      <DialogOverlay class="bg-black/75 fixed inset-0 z-40" />
      <DialogContent
        class="z-50 font-sans fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white p-4 rounded-lg w-[800px] flex flex-col gap-3"
      >
        <div class="rounded-full py-2 px-3 bg-[#afb0f5] font-bold">
          Edit question sheet
        </div>
        <div class="flex justify-between px-3 items-center text-[#a7a7a7]">
          <span class="text-sm text-[#969696]"
            >Number of Questions to Ask per Participant*</span
          >
          <Dropdown
            v-model="questionsToAskCount"
            trigger-class="w-[368px] bg-[#eee] h-6"
            content-class="w-[368px] bg-[#eee] text-[#a7a7a7]"
            :options="
              Array.from({ length: 10 }, (_, i) => ({
                label: i + 1,
                value: i + 1,
              }))
            "
          />
        </div>
        <div class="flex justify-between px-3 items-center text-[#a7a7a7]">
          <span class="text-sm text-[#969696]"
            >Number of Correct Answers Required to Pass*</span
          >
          <Dropdown
            v-model="correctAnswersRequiredCount"
            trigger-class="w-[368px] bg-[#eee] h-6"
            content-class="w-[368px] bg-[#eee] text-[#a7a7a7]"
            :options="
              Array.from({ length: 10 }, (_, i) => ({
                label: i + 1,
                value: i + 1,
              }))
            "
          />
        </div>
        <div class="rounded-full py-2 px-3 bg-[#afb0f5] font-bold">
          Questions
        </div>
        <div
          class="text-sm text-[#a7a7a7] max-h-[148px] overflow-auto border-b border-[#e1e1e1] mx-2 px-1"
        >
          <div
            v-for="(question, questionIdx) of updatedQuestions"
            class="flex gap-3 border-b border-[#e1e1e1] py-2"
          >
            <RadioGroupRoot
              :id="questionIdx"
              :model-value="
                question.options.find((option) => option.correct_answer === '1')
                  ?.id
              "
              v-on:update:model-value="
                (val) => {
                  question.options = question.options.map((option) => ({
                    ...option,
                    correct_answer: val === option.id ? '1' : '0',
                  }));
                }
              "
              class="flex flex-1 flex-col gap-2"
            >
              <div class="flex gap-4">
                <span class="min-w-16 text-end text-[#969696]"
                  >Question{{ questionIdx + 1 }}</span
                >
                <input
                  v-model="question.name"
                  placeholder="Question"
                  class="bg-[#eee] flex-1 px-2 rounded-sm"
                />
              </div>
              <div
                v-for="(option, optionIdx) of question.options"
                class="flex gap-4"
              >
                <div class="flex gap-1 min-w-16 justify-end items-center">
                  <RadioGroupItem
                    :value="option.id"
                    class="w-[18px] h-[18px] border rounded-full!"
                    :id="String.fromCharCode(65 + optionIdx)"
                  >
                    <RadioGroupIndicator
                      class="flex items-center justify-center w-full h-full relative after:content-[''] after:block after:w-[11px] after:h-[11px] after:rounded-[50%] after:bg-[#6366f1]"
                    />
                  </RadioGroupItem>
                  <label
                    :for="String.fromCharCode(65 + optionIdx)"
                    class="text-[#969696] w-[16px] flex flex-nowrap"
                  >
                    <span>
                      {{ String.fromCharCode(65 + optionIdx) }}
                    </span>
                    <span v-if="optionIdx < 2">*</span>
                  </label>
                </div>
                <input
                  v-model="option.name"
                  placeholder="Write Choice 1"
                  class="bg-[#eee] flex-1 px-2 rounded-sm"
                />
              </div>
            </RadioGroupRoot>
            <i
              class="pi pi-trash mt-1 cursor-pointer"
              @click="handleDeleteQuestion(question.id)"
            ></i>
          </div>

          <div
            v-for="(question, questionIdx) of newQuestions"
            class="flex gap-3 border-b border-[#e1e1e1] py-2"
          >
            <RadioGroupRoot
              :id="questionIdx"
              v-model="question.correctAnswer"
              class="flex flex-1 flex-col gap-2"
            >
              <div class="flex gap-4">
                <span class="min-w-16 text-end text-[#969696]"
                  >Question{{ updatedQuestions.length + questionIdx + 1 }}</span
                >
                <input
                  v-model="question.name"
                  placeholder="Question"
                  class="bg-[#eee] flex-1 px-2 rounded-sm"
                />
              </div>
              <div
                v-for="(option, optionIdx) of question.options"
                class="flex gap-4"
              >
                <div class="flex gap-1 min-w-16 justify-end items-center">
                  <RadioGroupItem
                    :value="optionIdx + 1"
                    class="w-[18px] h-[18px] border rounded-full!"
                    :id="String.fromCharCode(65 + optionIdx)"
                  >
                    <RadioGroupIndicator
                      class="flex items-center justify-center w-full h-full relative after:content-[''] after:block after:w-[11px] after:h-[11px] after:rounded-[50%] after:bg-[#6366f1]"
                    />
                  </RadioGroupItem>
                  <label
                    :for="String.fromCharCode(65 + optionIdx)"
                    class="text-[#969696] w-[16px] flex flex-nowrap"
                  >
                    <span>
                      {{ String.fromCharCode(65 + optionIdx) }}
                    </span>
                    <span v-if="optionIdx < 2">*</span>
                  </label>
                </div>
                <input
                  v-model="question.options[optionIdx]"
                  placeholder="Write Choice 1"
                  class="bg-[#eee] flex-1 px-2 rounded-sm"
                />
              </div>
            </RadioGroupRoot>
            <i
              class="pi pi-trash mt-1 cursor-pointer"
              @click="handleDeleteNewQuestion(questionIdx)"
            ></i>
          </div>
        </div>
        <div
          class="flex items-center gap-2 px-3 text-[#969696] text-sm cursor-pointer"
          @click="handleAddNewQuestion"
        >
          <i class="pi pi-plus-circle"></i>
          <span>Add Question</span>
        </div>
        <div class="flex justify-end gap-3">
          <DialogClose class="px-12 bg-[#bdbdbd] h-[38px] rounded text-[#666]">
            Cancel
          </DialogClose>
          <button
            class="px-12 bg-[#6366f1] w-[148px] rounded text-white"
            @click="handleSave"
          >
            <i
              v-if="loadingSaveQuestions"
              class="pi pi-spinner animate-spin"
            ></i>
            <span v-else> Update </span>
          </button>
        </div>
      </DialogContent>
    </DialogPortal>
  </DialogRoot>
</template>

<style scoped></style>
