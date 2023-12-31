<template>
  <div class="min-h-screen flex items-center justify-center">
    <form @submit.prevent="register" class="bg-white p-8 rounded shadow-md">
      <h2 class="text-2xl font-bold mb-6">Register</h2>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
        <input v-model="name" class="w-full p-2 border border-gray-300 rounded" required />
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
        <input
          v-model="email"
          type="email"
          class="w-full p-2 border border-gray-300 rounded"
          required
        />
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Password:</label>
        <input
          v-model="password"
          type="password"
          class="w-full p-2 border border-gray-300 rounded"
          required
        />
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Confirm Password:</label>
        <input
          v-model="password_confirmation"
          type="password"
          class="w-full p-2 border border-gray-300 rounded"
          required
        />
      </div>

      <div class="mb-4">
        <label for="role">Role:</label>
        <select id="role" v-model="role" class="form-control">
          <option value="user">User</option>
          <option value="admin">Admin</option>
        </select>
      </div>
      <button
        type="submit"
        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 focus:outline-none focus:shadow-outline-green"
      >Register</button>
      <router-link
        to="/login"
        class="block text-center text-blue-500 mt-4 hover:underline"
      >Already have an account? Login</router-link>
    </form>
  </div>
</template>
  
  <script>
import axios from "axios";
export default {
  data() {
    return {
      name: "",
      email: "",
      password: "",
      password_confirmation: "",
      role: ""
    };
  },
  methods: {
    async register() {
      try {
        if (this.password !== this.password_confirmation) {
          console.error("Password and Confirm Password do not match");
          return;
        }

        const response = await axios.post("/register", {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation,
          role: this.role
        });

        console.log("Registration successful:", response.data);

        this.$router.push("/login");
      } catch (error) {
        console.error("Registration failed:", error);
      }
    }
  }
};
</script>
  