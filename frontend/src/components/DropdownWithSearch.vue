<script setup>
import {
  ComboboxAnchor,
  ComboboxContent,
  ComboboxEmpty,
  ComboboxInput,
  ComboboxItem,
  ComboboxRoot,
  ComboboxTrigger,
  ComboboxViewport,
} from "radix-vue";
import { cn } from "../lib/utils";

defineProps(["anchorClass", "options", "disabled", "placeholder"]);
const model = defineModel();
</script>

<template>
  <ComboboxRoot
    :disabled="disabled"
    v-model:model-value="model"
    class="relative"
    multiple
    :filter-function="
      (values, term) => {
        return values.filter((val) =>
          val.name.toLowerCase().includes(term.toLowerCase())
        );
      }
    "
  >
    <ComboboxAnchor
      :class="
        cn(
          'w-full inline-flex items-center justify-between rounded px-[12px] text-[14px] leading-none h-[35px] gap-[5px] bg-white outline-none',
          disabled ? 'opacity-50' : '',
          anchorClass
        )
      "
    >
      <ComboboxTrigger class="w-full inline-flex items-center justify-between">
        <ComboboxInput
          class="!bg-transparent outline-none h-full selection:bg-grass5 placeholder-mauve8 flex-1"
          :placeholder="placeholder ?? 'Placeholder...'"
        />
        <i class="pi pi-chevron-down"></i>
      </ComboboxTrigger>
    </ComboboxAnchor>

    <ComboboxContent
      class="absolute z-10 w-full mt-2 min-w-[160px] bg-white overflow-auto rounded max-h-[320px]"
    >
      <ComboboxViewport class="p-[8px]">
        <ComboboxEmpty
          class="text-mauve8 text-xs font-medium text-center py-2"
        />

        <ComboboxItem
          v-for="(option, index) in options"
          :key="index"
          class="text-[13px] px-[8px] leading-none text-[#2c3e50] rounded-[3px] flex items-center h-[25px] relative select-none data-[disabled]:pointer-events-none data-[highlighted]:outline-none data-[highlighted]:bg-[#bcbcbc] data-[highlighted]:text-white data-[state=checked]:text-black"
          :value="option"
        >
          <span>
            {{ option.name }}
          </span>
        </ComboboxItem>
      </ComboboxViewport>
    </ComboboxContent>
  </ComboboxRoot>
</template>
