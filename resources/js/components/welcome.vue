<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded shadow-md w-96">
      <div class="text-center mb-6">
        <img
          src="https://thumbs.dreamstime.com/b/music-headset-logo-design-template-element-design-music-store-vector-illustration-music-headset-logo-design-template-element-111522829.jpg"
          alt="Music Store Logo"
          class="mx-auto h-32"
        />
        <h2 class="text-2xl font-bold mt-2">Welcome to the Music Store</h2>
        <p class="text-gray-500">Your one-stop destination for musical bliss!</p>
      </div>
      <div class="space-y-4">
        <div class="bg-blue-100 p-4 rounded-md">
          <router-link
            to="/login"
            class="block text-blue-500 font-bold text-lg hover:underline"
          >Login</router-link>
        </div>

        <div class="bg-green-100 p-4 rounded-md">
          <router-link
            to="/register"
            class="block text-green-500 font-bold text-lg hover:underline"
          >Register</router-link>
        </div>
      </div>
    </div>
  </div>
</template>
  
  <script>
export default {};
</script>