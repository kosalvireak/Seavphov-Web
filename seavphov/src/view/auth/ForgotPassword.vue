<template>
  <section class="Login flex-center w-full h-screen">
    <div class="card w-auto min-h-96 grid grid-cols-12 p-3 relative">
      <BackRoute route="send-mail" class="absolute top-3 left-3" />
      <div class="col-span-12 lg:col-span-6 flex-center">
        <div class="w-40 lg:w-52">
          <img src="/img/Seavphov Logo.png" alt="booklogo" class="img-fluid" />
        </div>
      </div>

      <div class="container-xl min-w-80 col-span-12 lg:col-span-6 text-center">
        <p class="h1 mb-0 text-seavphov">Forgot Password</p>

        <div class="ResetPasswordForm flex-center flex-column">
          <p class="my-3">Enter the token we sent to your email address.</p>

          <form v-on:submit.prevent="SendResetPassword()" class="w-100">
            <div class="form-floating mb-3">
              <MDBInput
                type="email"
                label="Email"
                id="email"
                v-model="email"
                wrapperClass="bg-white h-3rem"
                required
              />
            </div>
            <div class="form-floating password mb-3">
              <MDBInput
                type="text"
                label="Token"
                id="token"
                v-model="token"
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
            <div class="form-floating flex-center justify-content-end">
              <LoadingButton
                type="submit"
                text="Reset"
                :isLoading="isLoading"
              />
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { MDBInput } from "mdb-vue-ui-kit";
import AuthController from "../../controllers/AuthController";
export default {
  name: "ForgotPassword",

  components: { MDBInput },
  data() {
    return {
      sendEmail: "",
      email: "",
      token: "",
      password: "",
      password_confirmation: "",
      isLoading: false,
      Error: false,
      errorMessage: "",
      isShowPassword: false,
      page: 2,
      backText: "Login",
    };
  },
  methods: {
    async SendResetPassword() {
      this.isLoading = true;
      const formData = new FormData();
      formData.append("email", this.email);
      formData.append("token", this.token);
      formData.append("password", this.password);
      formData.append("password_confirmation", this.password_confirmation);

      const response = await AuthController.resetPassword(formData);
      this.isLoading = false;
      if (response) {
        if (this.page == 2) {
          this.toRouteName("login");
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
  },
};
</script>

<style></style>
