<template>
  <section class="Register flex-center w-full h-screen">
    <div class="card w-auto min-h-96 grid grid-cols-12 p-3 relative">
      <BackRoute route="home" class="absolute top-3 left-3" />
      <div class="col-span-12 lg:col-span-6 flex-center">
        <div class="w-40 lg:w-52">
          <img src="/img/Seavphov Logo.png" alt="booklogo" class="img-fluid" />
        </div>
      </div>
      <div class="container-xl min-w-80 col-span-12 lg:col-span-6 text-center">
        <p class="h1 text-seavphov">Register</p>
        <form v-on:submit.prevent="Register()">
          <div class="form-floating mb-3">
            <MDBInput
              type="text"
              label="Name"
              id="name"
              v-model="name"
              wrapperClass="bg-white h-3rem"
              required
            />
          </div>
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
          <div class="form-floating password mb-3">
            <MDBInput
              type="password"
              label="Password"
              id="password"
              v-model="password"
              wrapperClass="bg-white h-3rem"
              required
            />
          </div>
          <div class="form-floating mb-3">
            <MDBInput
              type="password"
              label="Confirm Password"
              id="password_confirmation"
              v-model="password_confirmation"
              wrapperClass="bg-white h-3rem"
              required
            />
          </div>
          <div class="d-flex align-items-start justify-content-between my-3">
            <div class="d-flex justify-content-center align-items-start">
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
          <div class="form-floating flex-center">
            <LoadingButton
              :isLoading="isLoading"
              text="Register"
              type="submit"
            />
          </div>
        </form>

        <div class="text-center mt-3">
          Already have an account?
          <a @click="toRouteName('login')" class="text-seavphov clickable"
            >Login.</a
          >
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { MDBInput } from "mdb-vue-ui-kit";
import UserController from "../../controllers/UserController";
export default {
  name: "Register",
  components: { MDBInput },
  data() {
    return {
      email: "",
      name: "",
      password: "",
      password_confirmation: "",
      Error: false,
      errorMessage: "",
      isShowPassword: false,
      isLoading: false,
    };
  },
  methods: {
    async Register() {
      if (this.password.length > 8) {
        this.Error = true;
        this.errorMessage = "Password must be 8 characters or more";
        return;
      }

      if (this.password !== this.password_confirmation) {
        this.Error = true;
        this.errorMessage = "Password & confirm password does not match!";
        return;
      }

      this.isLoading = true;
      const responseData = await UserController.register(
        this.createSignupDate()
      );
      this.isLoading = false;

      if (responseData) {
        await this.$store.dispatch("setCookieAndRedirectToHome", responseData);
      }
    },

    createSignupDate() {
      const form = new FormData();
      form.append("email", this.email);
      form.append("name", this.name);
      form.append("password", this.password);
      form.append("password_confirmation", this.password_confirmation);
      return form;
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
      this.toRouteName("forgot-password");
    },
  },
};
</script>

<style scoped></style>
