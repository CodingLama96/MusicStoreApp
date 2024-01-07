<template>
    <nav class="bg-blue-500 p-4 text-white">
      <div class="container mx-auto flex justify-between items-center">
        <router-link to="/admin/dashboard" class="text-2xl font-semibold text-white">Dashboard</router-link>
        <div class="relative" @click="toggleDropdown">
          <button class="text-white">{{ currentUser.name }}</button>
          <div v-show="isDropdownOpen" class="absolute top-10 right-0 bg-white shadow-md p-2 rounded-lg">
            <button @click="logout" class="block px-4 py-2 text-red-500 hover:bg-gray-100">Logout</button>
          </div>
        </div>
      </div>
    </nav>
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
  