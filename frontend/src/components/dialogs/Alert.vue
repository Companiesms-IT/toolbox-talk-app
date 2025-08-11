<script setup>
import {
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogOverlay,
  AlertDialogPortal,
  AlertDialogRoot,
  AlertDialogTitle,
} from "radix-vue";
import { cn } from "../../lib/utils";

defineProps([
  "title",
  "description",
  "onSuccess",
  "isVisible",
  "close",
  "type",
  "actions",
]);
</script>

<template>
  <AlertDialogRoot
    :open="isVisible"
    v-on:update:open="(val) => (val ? null : close())"
  >
    <AlertDialogPortal>
      <AlertDialogOverlay class="fixed inset-0 bg-black/75 z-50" />
      <AlertDialogContent
        class="flex flex-col rounded-[15px] w-[800px] bg-white p-[20px] fixed top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 z-50 outline-none"
      >
        <AlertDialogTitle
          :class="
            cn(
              'bg-[#afb0f5] h-[45px] text-[15px]! rounded-full flex items-center px-[15px] font-bold! font-sans',
              type === 'error' && 'bg-[#f46c4d]',
              type === 'success' && 'bg-[#42bd7c]'
            )
          "
          >{{ title ?? "Action Required" }}</AlertDialogTitle
        >
        <AlertDialogDescription
          v-html="description ?? 'Do you want to continue?'"
          class="px-[15px] font-sans m-0"
        ></AlertDialogDescription>
        <div class="bg-[#bdbdbd] h-[1px] mt-[8px] mb-[20px] mx-[8px]"></div>
        <div class="flex justify-end gap-[12px]">
          <AlertDialogCancel
            v-if="!actions"
            class="bg-[#bdbdbd] text-[#686868] px-[50px] py-[5px] font-bold font-sans! outline-none rounded-[8px]!"
          >
            Close
          </AlertDialogCancel>
          <AlertDialogAction
            v-for="action in actions"
            :class="
              cn(
                'bg-[#bdbdbd] text-[#686868] px-[50px] py-[5px] font-bold font-sans! outline-none rounded-[8px]!',
                actions.class
              )
            "
            @click="() => (action.handler ? action.handler() : null)"
          >
            {{ action.label }}
          </AlertDialogAction>
        </div>
      </AlertDialogContent>
    </AlertDialogPortal>
  </AlertDialogRoot>
</template>
