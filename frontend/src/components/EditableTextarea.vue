<script setup>
import {
  EditableArea,
  EditableInput,
  EditablePreview,
  EditableRoot,
} from "radix-vue";
import { ref, watch, watchEffect } from "vue";

const { value, onSubmit } = defineProps(["value", "onSubmit"]);

const editedValue = ref(value);

watchEffect(() => {
  editedValue.value = value;
});

watch(editedValue, (newVal) => {
  onSubmit(newVal);
});
</script>

<template>
  <div>
    <EditableRoot
      v-slot="{ isEditing, edit, submit }"
      v-model:model-value="editedValue"
      placeholder="Enter text..."
      class="flex flex-col w-full min-h-[210px] rounded-[10px] p-[10px] gap-[30px] bg-[#f4f4f4] description-main-wrapper"
      auto-resize
      submit-mode="none"
    >
      <div class="flex gap-3 items-center">
        <span class="bottom-des">Description</span>
        <i
          v-if="!isEditing"
          class="pi pi-pen-to-square hover:scale-105 cursor-pointer"
          @click="edit"
        ></i>
        <i
          v-else
          class="pi pi-check text-lg cursor-pointer hover:scale-105"
          @click="submit"
        ></i>
      </div>
      <EditableArea class="text-black w-full!">
        <EditablePreview
          v-if="!isEditing"
          class="text-[12px] whitespace-normal!"
        />
        <EditableInput
          rows="8"
          wrap="soft"
          as="textarea"
          v-else
          class="flex-1! h-full! w-full! placeholder:text-black bg-[#eee]! rounded! text-[12px]!"
        />
      </EditableArea>
    </EditableRoot>
  </div>
</template>
