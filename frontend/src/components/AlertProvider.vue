<script setup>
import { provide, ref } from "vue";
import Alert from "./dialogs/Alert.vue";

const isVisible = ref(false);
const title = ref("");
const description = ref("");
const type = ref("");
const actions = ref(null);

function openAlert({
  title: newTitle,
  description: newDescription,
  type: newType,
  actions: newActions,
}) {
  isVisible.value = true;
  title.value = newTitle;
  description.value = newDescription;
  type.value = newType;
  actions.value = newActions;
}

function closeAlert() {
  isVisible.value = false;
  title.value = "";
  description.value = "";
  type.value = "";
  actions.value = null;
}

// Provide the alert's control functions and state to descendants
provide("showAlert", openAlert);
provide("closeAlert", closeAlert);
provide("alertState", {
  isVisible,
  title,
  description,
});
</script>

<template>
  <Alert
    :isVisible="isVisible"
    :title="title"
    :description="description"
    :type="type"
    :close="closeAlert"
    :actions="actions"
  />
  <slot></slot>
</template>
