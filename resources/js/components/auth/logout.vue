<template>
  <div>
    <h1>Logging Out...</h1>
  </div>
</template>
  
  <script>
export default {
  mounted() {
    this.logout();
  },
  methods: {
    logout() {
      this.$router.push("/login");
    }
  }
};
</script>