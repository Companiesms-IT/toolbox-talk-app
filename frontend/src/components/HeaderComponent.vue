<!-- @format -->

<template>
  <header class="header_Sec position-sticky top-0">
    <a href="javascript:void(0)">
      <img src="/images/logo.png" class="img-fluid" alt="Logo" />
    </a>

    <div class="island_IconBox">
      <a href="javascript:void(0)" @click="onSearchClick">
        <img src="/images/searc.svg" alt="Search Icon" />
      </a>

      <a href="javascript:void(0)" @click="onSquareIconClick">
        <img src="/images/squareicon.svg" alt="Square Icon" />
      </a>

      <a href="javascript:void(0)" @click="onUserIconClick">
        <img src="/images/user.svg" alt="User Icon" />
      </a>
    </div>
  </header>
</template>

<script>
export default {
  name: "HeaderComponent",
  methods: {
    onSearchClick() {},
    onSquareIconClick() {},
    onUserIconClick() {},
  },
};
</script>
