<script setup>
import {
  DatePickerArrow,
  DatePickerCalendar,
  DatePickerCell,
  DatePickerCellTrigger,
  DatePickerContent,
  DatePickerField,
  DatePickerGrid,
  DatePickerGridBody,
  DatePickerGridHead,
  DatePickerGridRow,
  DatePickerHeadCell,
  DatePickerHeader,
  DatePickerHeading,
  DatePickerInput,
  DatePickerNext,
  DatePickerPrev,
  DatePickerRoot,
  DatePickerTrigger,
  Label,
} from "radix-vue";
import { cn } from "../lib/utils";
import moment from "moment";

const { disableAfter } = defineProps([
  "fieldClass",
  "disableBeforeToday",
  "readonly",
  "disabled",
  "disableBefore",
  "disableAfter",
]);

const model = defineModel();
</script>

<template>
  <DatePickerRoot
    id="date-field"
    locale="en-GB"
    class="font-sans"
    v-model:model-value="model"
    :readonly="readonly"
    :disabled="disabled"
    :is-date-disabled="
      (date) =>
        (moment(date.toDate()).add(1, 'day').isBefore(moment.now()) &&
          disableBeforeToday) ||
        (!!disableBefore &&
          moment(date.toDate()).add(1, 'months').isBefore(disableBefore)) ||
        (!!disableAfter &&
          moment(date.toDate()).add(1, 'months').isAfter(disableAfter))
    "
  >
    <DatePickerField
      v-slot="{ segments }"
      :class="
        cn(
          'flex select-none bg-[#ededed] text-[#848484] text-[14px] items-center justify-between rounded-[4px] text-center py-1 px-[12px] w-full data-[invalid]:border-red-500',
          fieldClass
        )
      "
    >
      <div class="flex items-center">
        <template v-for="item in segments" :key="item.part">
          <DatePickerInput v-if="item.part === 'literal'" :part="item.part">
            {{ item.value }}
          </DatePickerInput>
          <DatePickerInput
            v-else
            :part="item.part"
            class="rounded-md p-0.5 focus:outline-none focus:shadow-[0_0_0_2px] data-[placeholder]:text-green9"
          >
            {{ item.value }}
          </DatePickerInput>
        </template>
      </div>
      <DatePickerTrigger
        class="focus:shadow-[0_0_0_2px] rounded-md text-xl p-1"
      >
        <i class="pi pi-calendar mt-1 text-black"></i>
      </DatePickerTrigger>
    </DatePickerField>

    <DatePickerContent
      :side-offset="4"
      class="rounded-xl font-sans bg-white shadow-[0_10px_38px_-10px_hsla(206,22%,7%,.35),0_10px_20px_-15px_hsla(206,22%,7%,.2)] focus:shadow-[0_10px_38px_-10px_hsla(206,22%,7%,.35),0_10px_20px_-15px_hsla(206,22%,7%,.2),0_0_0_2px_theme(colors.green7)] will-change-[transform,opacity] data-[state=open]:data-[side=top]:animate-slideDownAndFade data-[state=open]:data-[side=right]:animate-slideLeftAndFade data-[state=open]:data-[side=bottom]:animate-slideUpAndFade data-[state=open]:data-[side=left]:animate-slideRightAndFade"
    >
      <DatePickerArrow class="fill-white" />
      <DatePickerCalendar v-slot="{ weekDays, grid }" class="p-4">
        <DatePickerHeader class="flex items-center justify-between">
          <DatePickerPrev
            class="inline-flex items-center cursor-pointer text-black justify-center rounded-[9px] bg-transparent w-8 h-8 hover:bg-black hover:text-white active:scale-98 active:transition-all focus:shadow-[0_0_0_2px] focus:shadow-black"
          >
            <i class="pi pi-chevron-left"></i>
          </DatePickerPrev>

          <DatePickerHeading class="text-black font-medium" />
          <DatePickerNext
            class="inline-flex items-center cursor-pointer text-black justify-center rounded-[9px] bg-transparent w-8 h-8 hover:bg-black hover:text-white active:scale-98 active:transition-all focus:shadow-[0_0_0_2px] focus:shadow-black"
          >
            <i class="pi pi-chevron-right"></i>
          </DatePickerNext>
        </DatePickerHeader>
        <div
          class="flex flex-col space-y-4 pt-4 sm:flex-row sm:space-x-4 sm:space-y-0"
        >
          <DatePickerGrid
            v-for="month in grid"
            :key="month.value.toString()"
            class="w-full border-collapse select-none space-y-1"
          >
            <DatePickerGridHead class="mb-1">
              <DatePickerGridRow class="mb-1 flex w-full justify-between">
                <DatePickerHeadCell
                  v-for="day in weekDays"
                  :key="day"
                  class="w-8 rounded-md text-xs text-center"
                >
                  {{ day }}
                </DatePickerHeadCell>
              </DatePickerGridRow>
            </DatePickerGridHead>
            <DatePickerGridBody class="space-y-1">
              <DatePickerGridRow
                v-for="(weekDates, index) in month.rows"
                :key="`weekDate-${index}`"
                class="flex w-full gap-1"
              >
                <DatePickerCell
                  v-for="weekDate in weekDates"
                  :key="weekDate.toString()"
                  :date="weekDate"
                >
                  <DatePickerCellTrigger
                    :day="weekDate"
                    :month="month.value"
                    class="relative flex items-center justify-center whitespace-nowrap rounded-[9px] border border-transparent bg-transparent text-sm font-normal text-black w-8 h-8 outline-none data-[selected]:bg-black! data-[selected]:text-white! data-[selected]:font-medium data-[outside-view]:text-black/30 data-[unavailable]:pointer-events-none data-[disabled]:bg-[#969696]! data-[disabled]:cursor-default! data-[unavailable]:text-black/30 data-[unavailable]:line-through before:absolute before:top-[5px] before:hidden before:rounded-full before:w-1 before:h-1 before:bg-white data-[today]:before:block data-[today]:before:bg-green9 data-[selected]:before:bg-white"
                  />
                </DatePickerCell>
              </DatePickerGridRow>
            </DatePickerGridBody>
          </DatePickerGrid>
        </div>
      </DatePickerCalendar>
    </DatePickerContent>
  </DatePickerRoot>
</template>
