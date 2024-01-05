<template>
  <div class="bg-gray-100 min-h-screen">
    <nav class="bg-blue-500 p-4 text-white">
      <div class="container mx-auto flex justify-between items-center">
        <span class="text-2xl font-semibold">Dashboard</span>
        <div class="relative" @click="toggleDropdown">
          <button class="text-white">{{ currentUser.name }}</button>
          <div
            v-show="isDropdownOpen"
            class="absolute top-10 right-0 bg-white shadow-md p-2 rounded-lg"
          >
            <button @click="logout" class="block px-4 py-2 text-red-500 hover:bg-gray-100">Logout</button>
          </div>
        </div>
      </div>
    </nav>

    <div class="container mx-auto p-4">
      <h2 class="text-3xl font-semibold mb-4">Welcome to Your Dashboard, {{ currentUser.name }}!</h2>

      <div class="bg-green-100 p-6 rounded-md">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <router-link
            to="/user/showAlbums"
            class="bg-white p-4 rounded-md text-green-500 font-bold text-lg hover:underline"
          >
            <div class="flex items-center">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                class="w-6 h-6 mr-2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17v1M12 22V2M21 12h-1M3 12H2m4-6h14a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2zm4 2h6"
                />
              </svg>
              <span>Browse Albums</span>
            </div>
          </router-link>

          <router-link
            to="/user/showPurchasedAlbums"
            class="bg-white p-4 rounded-md text-green-500 font-bold text-lg hover:underline"
          >
            <div class="flex items-center">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                class="w-6 h-6 mr-2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 11l-3-3m6 0l-3 3m0-6v12"
                />
              </svg>
              <span>Purchased Albums</span>
            </div>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Dashboard",
  data() {
    return {
      isDropdownOpen: false,
      currentUser: {
        name: ""
      }
    };
  },
  mounted() {
    this.fetchUserData();
  },
  methods: {
    fetchUserData() {
      axios
        .get("/user")
        .then(response => {
          this.currentUser = response.data.user;
        })
        .catch(error => {
          console.error("Error fetching user data", error);
        });
    },
    toggleDropdown() {
      this.isDropdownOpen = !this.isDropdownOpen;
    },
    logout() {
      this.$router.push("/logout");
    }
  }
};
</script>
