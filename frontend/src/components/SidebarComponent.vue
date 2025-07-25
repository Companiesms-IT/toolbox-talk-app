<template>
  <aside class="sidebarmenu">
    <div class="topmenubox activeCustom_Nav">
      <ul class="navbar ul_Active">
        <li>
          <router-link
            :to="{ name: 'create-new-talk' }"
            title="Create New Toolbox Talk"
            class="sidenavlink"
          >
            <svg
              width="25"
              height="24"
              viewBox="0 0 25 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M19 13H13V19H11V13H5V11H11V5H13V11H19V13Z"
                fill="#6366F1"
              />
            </svg>
          </router-link>
        </li>

        <li>
          <router-link
            :to="{ name: 'my-toolbox-talks' }"
            title="Created by Me Toolbox Talks"
            class="sidenavlink"
            :class="
              this.$route.path.startsWith('/my-toolbox-talks') &&
              'activenavlink'
            "
          >
            <svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M22.5 10.4865V18.9006C22.5 20.0604 21.5692 21.0001 20.4202 21.0001H3.57872C2.42979 21.0001 1.5 20.0604 1.5 18.9006V10.4865H4.6266V11.1394C4.6266 11.3714 4.81277 11.5604 5.04362 11.5604H8.4383C8.66809 11.5604 8.85638 11.3724 8.85638 11.1394V10.4865H15.1574V11.1394C15.1574 11.3714 15.3447 11.5604 15.5755 11.5604H18.9702C19.2 11.5604 19.3883 11.3724 19.3883 11.1394V10.4865H22.5Z"
                fill="#6366F1"
              />
              <path
                d="M22.5 6.19167V8.28473H1.5V6.19167C1.5 5.03292 2.42979 4.09324 3.57872 4.09324H8.85638V4.01163C8.85638 3.45319 9.30532 3 9.85851 3H14.1585C14.7106 3 15.1585 3.45212 15.1585 4.01163V4.09324H20.4202C21.5692 4.09324 22.5 5.03292 22.5 6.19167Z"
                fill="#6366F1"
              />
            </svg>
          </router-link>
        </li>

        <li>
          <router-link
            :to="{ name: 'toolbox-talks-library' }"
            title="Toolbox Library"
            class="sidenavlink"
          >
            <svg
              width="25"
              height="24"
              viewBox="0 0 25 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M21.0911 4.89474H14.4093L12.5002 3H7.72745C6.67745 3 5.82791 3.85263 5.82791 4.89474L5.81836 15.3158C5.81836 16.3579 6.67745 17.2105 7.72745 17.2105H21.0911C22.1411 17.2105 23.0002 16.3579 23.0002 15.3158V6.78947C23.0002 5.74737 22.1411 4.89474 21.0911 4.89474Z"
                fill="#6366F1"
              />
              <path
                d="M3.90909 6.78949H2V19.1053C2 20.1474 2.85909 21 3.90909 21H20.1364V19.1053H3.90909V6.78949Z"
                fill="#6366F1"
              />
            </svg>
          </router-link>
        </li>
      </ul>
    </div>

    <div class="bottommenubox d-flex justify-content-center">
      <a href="javascript:void(0)" @click="onBottomIconClick">
        <svg
          width="25"
          height="24"
          viewBox="0 0 25 24"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M4.5 21V9L12.5 3L20.5 9V21H14.5V14H10.5V21H4.5Z"
            fill="#6366F1"
            fill-opacity="0.6"
          />
        </svg>
      </a>
    </div>
  </aside>
</template>

<script>
export default {
  name: "SidebarMenu",
  methods: {
    onFirstIconClick() {
      this.$router.push({ name: "create-new-talk" });
    },
    onSecondIconClick() {},
    onThirdIconClick() {},
    onBottomIconClick() {},
  },
};
</script>
