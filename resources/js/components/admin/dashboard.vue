<template>
  <div class="dashboard bg-gray-100 min-h-screen">
    <nav class="bg-blue-500 p-4 text-white">
      <div class="container mx-auto flex justify-between items-center">
        <span class="text-2xl font-semibold">Dashboard</span>
        <div class="relative" @click="toggleDropdown">
          <button class="text-white">{{ currentUser.name }}</button>
          <div
            v-show="isDropdownOpen"
            class="absolute top-10 right-0 bg-white shadow-md p-2 rounded-lg"
          >
            <button @click="profile" class="block px-4 py-2 text-red-500 hover:bg-gray-100">Profile</button>
            <button @click="logout" class="block px-4 py-2 text-red-500 hover:bg-gray-100">Logout</button>
          </div>
        </div>
      </div>
    </nav>
    <div class="container mx-auto p-4">
      <h2 class="text-2xl font-semibold mb-4">Welcome, {{ isAdmin ? 'Admin' : 'User' }}!</h2>

      <div class="bg-green-100 p-4 rounded-md" v-if="isAdmin">
        <router-link
          to="/admin/addArtist"
          class="block text-green-500 font-bold text-lg hover:underline"
        >Add New Artist</router-link>
      </div>
    </div>
  </div>
</template>
  
  <script>
import axios from "axios";

export default {
  data() {
    return {
      isDropdownOpen: false,
      currentUser: {
        name: "",
        role: ""
      },
      isAdmin: false
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
          this.isAdmin = this.currentUser.role === "admin";
        })
        .catch(error => {
          console.error("Error fetching user data", error);
        });
    },
    toggleDropdown() {
      this.isDropdownOpen = !this.isDropdownOpen;
    },
    profile() {
      this.$router.push("/profile");
    },
    logout() {
      this.$router.push("/logout");
    }
  }
};
</script>
  