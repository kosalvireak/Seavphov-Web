<template>
  <div
    class="ForgotPassword shadow-5 flex-center flex-column col-md-6 col-sm-12 justify-content-between m-3 p-2 w-100"
  >
    <span class="w-100 my-3 ms-4">
      <i
        @click="switchPage()"
        class="fa fa-arrow-circle-left clickable pe-2"
      ></i>
      {{ backText }}
    </span>
    <div class="flex-center">
      <img src="/img/book.png" alt="booklogo" class="logo_img img-fluid" />
    </div>

    <div class="ForgotPassword_top flex-center">
      <h2 class="mt-2">Forgot Password</h2>
    </div>

    <div
      v-if="page == 1"
      class="SendEmailForm flex-center flex-column mb-7 w-60"
    >
      <h6 class="my-3">Enter your email address</h6>
      <form v-on:submit.prevent="SendEmail()" class="w-100">
        <div class="form-floating mb-3">
          <MDBInput
            type="email"
            label="Email"
            id="email"
            v-model="sendEmail"
            wrapperClass="bg-white h-3rem"
            required
          />
        </div>
        <p v-if="Error" class="text-danger">{{ errorMessage }}</p>
        <div class="form-floating flex-center justify-content-end">
          <button type="submit" class="btn mt-2 flex-center btn_submit">
            <span v-if="!isLoading">Next</span>
            <Loader v-else :size="15" :Color="'#FFFFFF'" />
          </button>
        </div>
      </form>
    </div>
    <div
      v-if="page == 2"
      class="ResetPasswordForm flex-center flex-column my-3 w-60"
    >
      <h5 class="my-3">Enter the token we sent to your email address.</h5>
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
          <button
            type="submit"
            class="btn btn-primary mt-2 flex-center btn_submit"
          >
            <span v-if="!isLoading">Reset</span>
            <Loader v-else :size="15" :Color="'#FFFFFF'" />
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { MDBInput } from "mdb-vue-ui-kit";
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
      page: "1",
      backText: "Login",
    };
  },
  methods: {
    async SendEmail() {
      this.isLoading = true;
      const formData = new FormData();
      formData.append("email", this.sendEmail);
      await this.$store.dispatch("sendEmailResetPassword", formData);
      this.isLoading = false;
      this.page = 2;
      this.backText = "Send gmail";
    },
    async SendResetPassword() {
      this.isLoading = true;
      const formData = new FormData();
      formData.append("email", this.email);
      formData.append("token", this.token);
      formData.append("password", this.password);
      formData.append("password_confirmation", this.password_confirmation);
      await this.$store.dispatch("resetPassword", formData);
      this.isLoading = false;
      if (this.page == 2) {
        this.toRouteName("login");
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
    switchPage() {
      if (this.page == 1) {
        this.toRouteName("login");
      } else if (this.page == 2) {
        this.page = 1;
        this.backText = "Login";
      }
    },
  },
};
</script>

<style>
.ForgotPassword {
  margin-top: 100px !important;
  max-width: 750px;
  min-height: 400px !important;
}

.ForgotPassword_top {
  height: 50px;
  width: 100%;
}

.btn_submit {
  width: 80px;
  height: 40px;
  background-color: #5c836e;
  color: #ffffff;
}

.btn_submit:hover {
  background-color: #444;
}

.logo_img {
  width: 140px;
  height: auto;
}
</style>
