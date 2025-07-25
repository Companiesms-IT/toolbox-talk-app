<!-- @format -->

<template>
  <div id="app">
    <ToastProvider>
      <router-view />
      <Toaster />
    </ToastProvider>
  </div>
</template>

<script>
import { ToastProvider } from "radix-vue";
import Toaster from "./components/Toaster.vue";

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
