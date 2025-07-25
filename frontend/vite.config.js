import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import tailwindcss from "@tailwindcss/vite";
import RadixVueResolver from "radix-vue/resolver";
import Components from "unplugin-vue-components/vite";

export default defineConfig({
  plugins: [
    vue(),
    Components({
      dts: true,
      resolvers: [RadixVueResolver()],
    }),
    tailwindcss(),
  ],
});
