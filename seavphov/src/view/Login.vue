<template>
  <div class="main-container">
    <div class="row">
      <div
        class="d-flex align-items-center justify-content-center logo col-md-6 col-sm-12"
      >
        <img src="/img/book.png" alt="booklogo" class="logoimg img-fluid" />
      </div>
      <div class="container col-md-6 col-sm-12">
        <h1>Log In</h1>
        <form v-on:submit.prevent="Login()">
          <div class="form-floating mb-3">
            <input
              type="email"
              class="form-control btn rounded-pill text-start"
              id="email"
              placeholder="name@example.com"
              v-model="email"
              style="background-color: #d9d9d9"
              @focus="toggleLabel('email', true)"
              @blur="toggleLabel('email', false)"
            />
            <label for="email" :class="{ 'special-style': toggleEmail }"
              >Email address</label
            >
          </div>
          <div class="form-floating">
            <input
              type="password"
              class="form-control btn rounded-pill text-start"
              id="password"
              placeholder="Password"
              v-model="password"
              style="background-color: #d9d9d9"
              @focus="toggleLabel('password', true)"
              @blur="toggleLabel('password', false)"
            />
            <label for="password" :class="{ 'special-style': togglePassword }"
              >Password</label
            >
          </div>

          <!-- 2 column grid layout for inline styling -->
          <div
            class="d-flex align-items-start justify-content-between my-3 px-4"
          >
            <div class="d-flex justify-content-center">
              <!-- Checkbox -->
              <div
                class="form-check h-100 d-flex align-items-start justify-content-center"
              >
                <input
                  class="form-check-input"
                  type="checkbox"
                  value=""
                  id="form1Example3"
                  checked
                  v-model="isShowPassword"
                  @click="showPassword"
                />
                <label class="form-check-label" for="form1Example3">
                  Show password
                </label>
              </div>
            </div>

            <div class="text-seavphov">
              <!-- Simple link -->
              <label @click="forgotPassword()">Forgot password?</label>
            </div>
          </div>
          <p v-if="Error" class="text-danger">{{ errorMessage }}</p>
          <!-- Submit button -->
          <button type="submit" class="btn btn-primary btn-block">
            Log in
          </button>
        </form>

        <!-- Register buttons -->
        <div class="text-center mt-3">
          Doesn't have an account?
          <a
            @click="
              () => {
                this.$router.push('/signup');
              }
            "
            class="text-seavphov"
            >Sign up.</a
          >
        </div>
      </div>
    </div>
  </div>
</template>
  
  <script>
export default {
  name: "Login",
  data() {
    return {
      email: "virakvary@gmail.com",
      password: "12345678",
      Error: false,
      errorMessage: "",
      isShowPassword: false,
      toggleEmail: false,
      togglePassword: false,
    };
  },
  methods: {
    async Login() {
      // if both input are empty
      if (this.email.length == 0 || this.password.length == 0) {
        this.Error = true;
        this.errorMessage = "Email or password cannot be empty!";
      } else if (this.email.length > 0 || this.password.length > 6) {
        const loginData = {
          email: this.email,
          password: this.password,
        };
        await this.$store.dispatch("loginUser", loginData);
      } else {
        this.Error = true;
        this.errorMessage = "Incorrect email or password!";
      }
    },
    toggleLabel(input, bool) {
      if (input == "email") {
        this.toggleEmail = bool;
        if (this.email.length !== 0) {
          this.toggleEmail = true;
        }
      } else if (input == "password") {
        this.togglePassword = bool;
        if (this.password.length !== 0) {
          this.togglePassword = true;
        }
      }
    },
    showPassword() {
      if (this.isShowPassword) {
        password.type = "password";
      } else {
        password.type = "text";
      }
    },
    forgotPassword() {
      alert("Comming soon");
    },
  },
};
</script>
  
  <style scoped>
.main-container {
  display: flex;
  align-items: center;
  justify-content: center;
}
.row {
  background-color: #fff;
  border-radius: 30px;
  width: 900px;
  padding: 50px;
}

.logo {
  text-align: center;
}

.logoimg {
  max-width: 300px;
}

h1 {
  font-size: 50px;
  font-weight: bold;
  margin-bottom: 25px;
  color: #5c836e;
  text-align: center;
}

form {
  width: 100%;
  text-align: center;
}

label {
  margin-bottom: 5px;
  text-align: center;
  display: block;
  margin: 0 auto;
}
label::after {
  background-color: #d9d9d9 !important;
  width: 100% !important;
}

.special-style {
  width: 430px !important;
}
button {
  text-align: center;
  background-color: #5c836e;
  color: #fff;
  padding: 7px 70px;
  width: 300px;
  margin: auto;
  border-radius: 15px;
  font-weight: bold;
  font-size: 25px;
  cursor: pointer;
}

button:hover {
  background-color: #444;
}

.btn {
  text-transform: unset !important;
}

.no-account {
  margin-top: 15px;
  font-size: 12px;
  color: #666;
  text-align: center;
}

a {
  color: #a3b18a;
  text-decoration: none;
}

@media (max-width: 768px) {
  .logoimg {
    max-width: 150px;
  }
  .button {
    width: 200px;
  }
  .row {
    width: 100%;
    padding: 20px;
  }
  .special-style {
    width: 370px !important;
  }
}
</style>