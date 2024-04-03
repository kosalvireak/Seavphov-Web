<template>
  <div class="main-container">
    <div class="row">
      <div
        class="d-flex align-items-center justify-content-center logo col-md-6 col-sm-12"
      >
        <img src="/img/book.png" alt="booklogo" class="logoimg img-fluid" />
      </div>
      <div class="container col-md-6 col-sm-12">
        <h1>Sign Up</h1>
        <form v-on:submit.prevent="Signup()">
          <div class="form-floating mb-3">
            <input
              type="name"
              class="form-control btn rounded-pill text-start"
              id="name"
              placeholder="name"
              v-model="name"
              style="background-color: #d9d9d9"
              @focus="toggleLabel('name', true)"
              @blur="toggleLabel('name', false)"
              required
            />
            <label for="name" :class="{ 'special-style': toggleEmail }"
              >Name</label
            >
          </div>
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
              required
            />
            <label for="email" :class="{ 'special-style': toggleEmail }"
              >Email address</label
            >
          </div>
          <div class="form-floating password mb-3">
            <input
              type="password"
              class="form-control btn rounded-pill text-start"
              id="password"
              placeholder="password"
              v-model="password"
              style="background-color: #d9d9d9"
              @focus="toggleLabel('password', true)"
              @blur="toggleLabel('password', false)"
              required
            />
            <label for="password" :class="{ 'special-style': togglePassword }"
              >Password</label
            >
          </div>
          <div class="form-floating mb-3">
            <input
              type="password"
              class="form-control btn rounded-pill text-start"
              id="password_confirmation"
              placeholder="password_confirmation"
              v-model="password_confirmation"
              style="background-color: #d9d9d9"
              @focus="toggleLabel('password_confirmation', true)"
              @blur="toggleLabel('password_confirmation', false)"
              required
            />
            <label
              for="password_confirmation"
              :class="{ 'special-style': toggleConfirmPassword }"
              >Confirm Password</label
            >
          </div>
          <div class="d-flex align-items-start justify-content-between my-3">
            <div class="d-flex justify-content-center ps-4 align-items-start">
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
          </div>
          <p v-if="Error" class="text-danger">{{ errorMessage }}</p>
          <button type="submit" class="btn btn-primary btn-block">
            Sign up
          </button>
        </form>

        <div class="text-center mt-3">
          Already have an account?
          <a
            @click="
              () => {
                this.$router.push('/login');
              }
            "
            class="text-seavphov"
            >Login.</a
          >
        </div>
      </div>
    </div>
  </div>
</template>
  
<script>
export default {
  name: "Signup",
  data() {
    return {
      email: "virakvary@gmail.com",
      name: "virak",
      password: "123456789",
      password_confirmation: "123456789",
      Error: false,
      errorMessage: "",
      isShowPassword: false,
      toggleEmail: false,
      togglePassword: false,
      toggleConfirmPassword: false,
    };
  },
  methods: {
    async Signup() {
      if (this.password.length >= 8) {
        if (this.password == this.password_confirmation) {
          const signupData = {
            email: this.email,
            name: this.name,
            password: this.password,
            password_confirmation: this.password_confirmation,
          };
          await this.$store.dispatch("registerUser", signupData);
        } else {
          this.Error = true;
          this.errorMessage = "Password & confirm password does not match!";
        }
      } else {
        this.Error = true;
        this.errorMessage = "Password must be 8 characters or more";
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
      } else if (input == "password_confirmation") {
        this.toggleConfirmPassword = bool;
        if (this.password.length !== 0) {
          this.toggleConfirmPassword = true;
        }
      }
    },
    showPassword() {
      if (this.isShowPassword) {
        password.type = "password";
        password_confirmation.type = "password";
      } else {
        password.type = "text";
        password_confirmation.type = "text";
      }
    },
    forgotPassword() {
      alert("Coming soon");
    },
  },
};
</script>
  
<style scoped>
.main-container {
  height: 100vh;
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