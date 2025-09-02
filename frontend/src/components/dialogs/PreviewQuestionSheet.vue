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
import Dropdown from "../Dropdown.vue";
const props = defineProps([
  "questionsToAskCount",
  "correctAnswersRequiredCount",
  "questions",
  "handleDeleteQuestion",
]);
console.log(props.questions);
</script>

<template>
  <DialogRoot>
    <DialogTrigger
      class="w-fit bg-[#3cacfe] text-white h-[30px] px-3 rounded mx-2"
    >
      Preview
    </DialogTrigger>
    <DialogPortal>
      <DialogOverlay class="bg-black/75 fixed inset-0 z-40" />
      <DialogContent
        class="z-40 font-sans fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white p-4 rounded-lg w-[800px] flex flex-col gap-3"
      >
        <div class="rounded-full py-2 px-3 bg-[#afb0f5] font-bold">
          Question Sheet
        </div>
        <div class="flex justify-between px-3 items-center text-[#a7a7a7]">
          <span class="text-sm text-[#969696]"
            >Number of Questions to Ask per Participant*</span
          >
          <Dropdown
            disabled
            :value="questionsToAskCount"
            :options="[
              { label: questionsToAskCount, value: questionsToAskCount },
            ]"
            trigger-class="w-[368px] bg-[#eee] h-6"
            content-class="w-[368px] bg-[#eee] text-[#a7a7a7]"
          />
        </div>
        <div class="flex justify-between px-3 items-center text-[#a7a7a7]">
          <span class="text-sm text-[#969696]"
            >Number of Correct Answers Required to Pass*</span
          >
          <Dropdown
            disabled
            :value="correctAnswersRequiredCount"
            :options="[
              {
                label: correctAnswersRequiredCount,
                value: correctAnswersRequiredCount,
              },
            ]"
            trigger-class="w-[368px] bg-[#eee] h-6"
            content-class="w-[368px] bg-[#eee] text-[#a7a7a7]"
          />
        </div>
        <div class="rounded-full py-2 px-3 bg-[#afb0f5] font-bold">
          Questions
        </div>
        <div
          class="text-sm text-[#a7a7a7] max-h-[148px] overflow-auto border-b border-[#e1e1e1] mx-2 px-1"
        >
          <div
            v-for="(question, questionIdx) of questions"
            class="flex gap-3 border-b border-[#e1e1e1] py-2"
          >
            <RadioGroupRoot
              disabled
              :model-value="
                question.options.find((option) => option.correct_answer === '1')
                  ?.id
              "
              class="flex flex-1 flex-col gap-2"
            >
              <div class="flex gap-4">
                <span class="min-w-16 text-end text-[#969696]"
                  >Question{{ questionIdx + 1 }}</span
                >
                <input
                  disabled
                  placeholder="Question"
                  :value="question.name"
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
                    :id="`A`"
                  >
                    <RadioGroupIndicator
                      class="flex items-center justify-center w-full h-full relative after:content-[''] after:block after:w-[11px] after:h-[11px] after:rounded-[50%] after:bg-[#6366f1]"
                    />
                  </RadioGroupItem>
                  <label for="q1-A" class="text-[#969696] w-[16px]"
                    >{{ String.fromCharCode(65 + optionIdx) }}*</label
                  >
                </div>
                <input
                  disabled
                  :value="option.name"
                  placeholder="Write Choice 1"
                  class="bg-[#eee] flex-1 px-2 rounded-sm"
                />
              </div>
            </RadioGroupRoot>
          </div>
        </div>
        <div class="flex justify-end gap-3">
          <DialogClose class="px-12 bg-[#bdbdbd] h-[38px] rounded text-[#666]">
            Cancel
          </DialogClose>
        </div>
      </DialogContent>
    </DialogPortal>
  </DialogRoot>
</template>

<style scoped></style>
