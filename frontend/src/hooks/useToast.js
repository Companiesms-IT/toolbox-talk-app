import { ref } from "vue";

const toasts = ref([]);

export function useToast() {
  function addToast(toast) {
    const id = Date.now(); // Generate a unique ID
    toasts.value.push({ ...toast, id });
    setTimeout(() => removeToast(id), toast.duration || 5000); // Auto-dismiss after 5 seconds
  }

  function removeToast(id) {
    toasts.value = toasts.value.filter((toast) => toast.id !== id);
  }

  return { toasts, addToast };
}
