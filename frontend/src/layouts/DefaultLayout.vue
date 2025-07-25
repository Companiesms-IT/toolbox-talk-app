<!-- @format -->

<template>
  <div class="layout">
    <HeaderComponent />
    <div class="main-content">
      <SidebarComponent />
      <div class="page-content">
        <router-view />
      </div>
    </div>
  </div>
</template>

<script>
import SidebarComponent from "../components/SidebarComponent.vue";
import HeaderComponent from "../components/HeaderComponent.vue";

export default {
  components: {
    SidebarComponent,
    HeaderComponent,
  },
};
</script>


<style  scoped>
.page-content{
  padding-right: 20px;
  padding-top: 20px;
}

@media   (min-width: 2560px){
  .main-content{

    height: 92vh;
  }
}

</style>