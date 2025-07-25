<template>
  <ToastProvider>
    <ToastViewport
      class="[--viewport-padding:_25px] fixed top-0 right-0 flex flex-col p-[var(--viewport-padding)] gap-[10px] w-[390px] max-w-[100vw] m-0 list-none z-[2147483647] outline-none"
    />
    <ToastRoot
      v-for="toast in toasts"
      :class="
        cn(
          'rounded-lg bg-white flex flex-col gap-2 shadow p-[15px] data-[state=open]:animate-slideIn data-[state=closed]:animate-hide data-[swipe=move]:translate-x-[var(--radix-toast-swipe-move-x)] data-[swipe=cancel]:translate-x-0 data-[swipe=cancel]:transition-[transform_200ms_ease-out] data-[swipe=end]:animate-swipeOut',
          toast.type === 'success' && 'bg-emerald-100',
          toast.type === 'warning' && 'bg-orange-100',
          toast.type === 'error' && 'bg-red-100'
        )
      "
      :key="toast.id"
      v-model:open="toast.open"
    >
      <ToastTitle
        class="font-bold text-lg flex items-center gap-2"
        v-if="toast.title"
      >
        <i
          v-if="toast.type === 'success'"
          class="pi pi-check-circle text-green-600"
        ></i>
        <i
          v-else-if="toast.type === 'warning'"
          class="pi pi-question-circle text-orange-500"
        ></i>
        <i
          v-else-if="toast.type === 'error'"
          class="pi pi-exclamation-circle text-red-600"
        ></i>
        <i v-else class="pi pi-info-circle text-black"></i>
        {{ toast.title }}</ToastTitle
      >
      <ToastDescription>{{ toast.description }}</ToastDescription>
    </ToastRoot>
  </ToastProvider>
</template>

<script setup lang="ts">
import {
  ToastClose,
  ToastDescription,
  ToastProvider,
  ToastRoot,
  ToastTitle,
  ToastViewport,
} from "radix-vue";
import { useToast } from "../hooks/useToast";
import { cn } from "../lib/utils";

const { toasts } = useToast();
</script>
