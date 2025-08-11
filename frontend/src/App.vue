<!-- @format -->

<template>
  <div id="app">
    <ToastProvider>
      <AlertProvider>
        <router-view />
        <Toaster />
      </AlertProvider>
    </ToastProvider>
  </div>
</template>

<script>
import { ToastProvider } from "radix-vue";
import Toaster from "./components/Toaster.vue";
import AlertProvider from "./components/AlertProvider.vue";
import "vue-pdf-embed/dist/styles/annotationLayer.css";
import "vue-pdf-embed/dist/styles/textLayer.css";

export default {
  name: "App",
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}
</style>
