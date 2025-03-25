<template>
  <section class="Login flex-center w-full h-screen">
    <div class="card w-auto min-h-96 grid grid-cols-12 p-3 relative">
      <BackRoute route="home" class="absolute top-3 left-3" />
      <div class="col-span-12 lg:col-span-6 flex-center">
        <div class="w-40 lg:w-52">
          <img src="/img/Seavphov Logo.png" alt="booklogo" class="img-fluid" />
        </div>
      </div>
      <div class="container-xl min-w-80 col-span-12 lg:col-span-6 text-center">
        <p class="h1 text-seavphov">Log In</p>
        <form v-on:submit.prevent="Login()">
          <div class="form-floating mb-3">
            <MDBInput
              type="email"
              label="Email address"
              id="email"
              v-model="email"
              wrapperClass="bg-white h-3rem"
              required
            />
          </div>
          <div class="form-floating">
            <MDBInput
              type="password"
              label="Password"
              id="password"
              v-model="password"
              wrapperClass="bg-white h-3rem"
              required
            />
          </div>

          <div class="d-flex align-items-start justify-content-between my-3">
            <div class="d-flex justify-content-center">
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
              <label @click="toRouteName('send-mail')" class="clickable"
                >Forgot password?</label
              >
            </div>
          </div>
          <p v-if="Error" class="text-danger">{{ errorMessage }}</p>
          <div class="form-floating flex-center">
            <LoadingButton :isLoading="isLoading" text="Login" type="submit" />
          </div>
        </form>

        <div class="text-center mt-3">
          Doesn't have an account?
          <a @click="toRouteName('signup')" class="text-seavphov clickable"
            >Register!</a
          >
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { MDBInput } from "mdb-vue-ui-kit";
export default {
  name: "Login",
  components: { MDBInput },
  data() {
    return {
      email: "",
      password: "",
      Error: false,
      errorMessage: "",
      isLoading: false,
      isShowPassword: false,
    };
  },
  methods: {
    async Login() {
      if (this.email.length == 0 || this.password.length == 0) {
        this.Error = true;
        this.errorMessage = "Email or password cannot be empty!";
      } else if (this.email.length > 0 || this.password.length > 6) {
        const loginData = {
          email: this.email,
          password: this.password,
        };
        this.isLoading = true;
        await this.$store.dispatch("loginUser", loginData);
        this.isLoading = false;
      } else {
        this.Error = true;
        this.errorMessage = "Incorrect email or password!";
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
      this.toRouteName("forgot-password");
    },
    redirectHome() {
      this.toRouteName("home");
    },
  },
};
</script>

<style scoped></style>
