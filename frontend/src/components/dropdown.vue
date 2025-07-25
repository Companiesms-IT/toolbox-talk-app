<script setup>
import {
  SelectContent,
  SelectItem,
  SelectItemText,
  SelectPortal,
  SelectRoot,
  SelectTrigger,
  SelectValue,
  SelectViewport,
} from "radix-vue";
import { cn } from "../lib/utils";

defineProps(["triggerClass", "contentClass", "options", "value", "disabled"]);
</script>

<template>
  <SelectRoot :model-value="value" :disabled="disabled">
    <SelectTrigger
      :class="
        cn(
          'inline-flex items-center justify-between rounded px-[15px] text-[13px]! leading-none h-[35px] gap-[5px] bg-black/10 outline-none',
          triggerClass
        )
      "
    >
      <SelectValue placeholder="Select" />
      <i class="pi pi-chevron-down"></i>
    </SelectTrigger>
    <SelectPortal>
      <SelectContent
        position="popper"
        :class="
          cn(
            'bg-black/10 shadow mt-1 rounded will-change-[opacity,transform] data-[side=top]:animate-slideDownAndFade data-[side=right]:animate-slideLeftAndFade data-[side=bottom]:animate-slideUpAndFade data-[side=left]:animate-slideRightAndFade z-[100]',
            contentClass
          )
        "
      >
        <SelectViewport class="px-[15px] py-1 space-y-1">
          <SelectItem
            v-for="option in options"
            :value="option.value"
            class="text-[13px] leading-none rounded-[3px] flex items-center h-[25px] relative select-none data-[disabled]:text-mauve8 data-[disabled]:pointer-events-none data-[highlighted]:outline-none data-[highlighted]:bg-green9 data-[highlighted]:text-green1"
          >
            <SelectItemText> {{ option.label }} </SelectItemText>
          </SelectItem>
        </SelectViewport>
      </SelectContent>
    </SelectPortal>
  </SelectRoot>
</template>
