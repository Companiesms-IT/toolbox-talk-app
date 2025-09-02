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
  <EditableRoot
    v-slot="{ isEditing, edit, submit }"
    v-model:model-value="editedValue"
    placeholder="Enter text..."
    class="relative flex items-center gap-2"
    auto-resize
  >
    <EditableArea class="text-black w-full!">
      <EditablePreview class="text-[32px] font-bold px-4 text-center" />
      <EditableInput
        class="flex-1! w-full! placeholder:text-black bg-[#eee]! rounded! text-[32px]! font-bold! text-center"
      />
    </EditableArea>
    <i
      v-if="!isEditing"
      class="pi pi-pen-to-square cursor-pointer hover:scale-105"
      @click="edit"
    ></i>
    <i
      v-else
      class="pi pi-check text-xl cursor-pointer hover:scale-105"
      @click="submit"
    ></i>
  </EditableRoot>
</template>
