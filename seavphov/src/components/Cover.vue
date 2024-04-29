<template>
  <div>
    <div>
      <img src="./BookCover.jpg" alt="book" />
    </div>

    <div>
      <h1>Find Your Favorite Book Here</h1>
    </div>

    <div>
      <router-link to="/login" class="login-button">Login</router-link>
      <router-link to="/signup" class="signup-button">Sign Up</router-link>
    </div>
  </div>
</template>

<script>
export default {
  name: "HomePage",
};
</script>

<style scoped>
/* CSS for centering all elements */
body,
html {
  height: 100%;
  margin: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
}

/* CSS for styling the buttons */
.login-button,
.signup-button {
  display: inline-block;
  padding: 40px 70px;
  background-color: #37aba3;
  color: white;
  text-decoration: none;
  border: none;
  border-radius: 5px;
  font-size: 30px;
  cursor: pointer;
  margin-bottom: 10px;
  transition: background-color 0.3s;
  border: black 1px;
}

.signup-button {
  background-color: #07382c;
}

.login-button:hover,
.signup-button:hover {
  background-color: #13514c;
}

h1 {
  font-family: Arial, sans-serif;
  margin-bottom: 20px;
  color: #37aba3;
  font-size: 80px;
}
</style>
