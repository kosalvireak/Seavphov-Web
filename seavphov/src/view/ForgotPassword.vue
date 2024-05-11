<template>
  <div
    class="ForgotPassword shadow-5 d-flex-center flex-column col-md-6 col-sm-12 justify-content-between m-3 p-2"
  >
  <div class="d-flex-center align-items-center justify-content-between me-5">
    <span class="justify-content-left">
        <i
          @click="switchPage()"
          class="fa fa-arrow-left fa-xl cursor-pointer"
        ></i>
      </span>

    <div
      class="d-flex align-items-center justify-content-center logo col-md-2 col-sm-4"
    >
      <img src="/img/book.png" alt="booklogo" class="logoimg img-fluid " />
    </div>

    <span></span>
  </div>

    <div
      class="ForgotPassword_top d-flex-center"
    >
      <h2 class="mt-2">Forgot Password</h2>
    </div>

    <div
      v-if="page == 1"
      class="SendEmailForm d-flex-center flex-column mb-7 w-60"
    >
      <h6 class="my-3">
        Enter your email address
      </h6>
      <form v-on:submit.prevent="SendEmail()" class="w-100">
        <div class="form-floating mb-3">
          <MDBInput
            type="email"
            label="Email"
            id="email"
            v-model="email"
            wrapperClass="bg-white p-2"
            required
          />
        </div>
        <p v-if="Error" class="text-danger">{{ errorMessage }}</p>
        <div class="form-floating d-flex-center justify-content-end">
          <button
            type="submit"
            class="btn mt-2 d-flex-center btn_submit"
          >
            <span v-if="!isLoading">Next</span>
            <Loader v-else :size="20" :Color="'#FFFFFF'" />
          </button>
        </div>
      </form>
    </div>
    <div
      v-if="page == 2"
      class="ResetPasswordForm d-flex-center flex-column my-3 w-60"
    >
      <h5 class="my-3">Enter the token we sent to your email address.</h5>
      <form v-on:submit.prevent="SendResetPassword()" class="w-100">
        <div class="form-floating mb-3">
          <MDBInput
            type="email"
            label="Email"
            id="email"
            v-model="email"
            wrapperClass="bg-white p-2"
            required
          />
        </div>
        <div class="form-floating password mb-3">
          <MDBInput
            type="text"
            label="Token"
            id="token"
            v-model="token"
            wrapperClass="bg-white p-2"
            required
          />
        </div>
        <div class="form-floating password mb-3">
          <MDBInput
            type="password"
            label="Password"
            id="password"
            v-model="password"
            wrapperClass="bg-white p-2"
            required
          />
        </div>
        <div class="form-floating mb-3">
          <MDBInput
            type="password"
            label="Confirm Password"
            id="password_confirmation"
            v-model="password_confirmation"
            wrapperClass="bg-white p-2"
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
        <div class="form-floating d-flex-center justify-content-end">
          <button
            type="submit"
            class="btn btn-primary mt-2 d-flex-center btn_submit"
          >
            <span v-if="!isLoading">Reset</span>
            <Loader v-else :size="20" :Color="'#FFFFFF'" />
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Loader from "../components/Loader.vue";
import { MDBInput } from "mdb-vue-ui-kit";
export default {
  name: "ForgotPassword",

  components: { Loader, MDBInput },
  data() {
    return {
      email: "virakvary@gmail.com",
      token: "1234",
      password: "12345678",
      password_confirmation: "12345678",
      isLoading: false,
      Error: false,
      errorMessage: "",
      isShowPassword: false,
      page: "1",
    };
  },
  methods: {
    async SendEmail() {
      this.page = 2;
      //.isLoading = true;
      // await this.$store.dispatch("registerUser", signupData);
      //this.isLoading = false;
    },
    async SendResetPassword() {
      if (this.page == 2) {
        this.$router.push("/login");
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
        this.$router.push("/login");
      } else if (this.page == 2) {
        this.page = 1;
      }
    },
  },
};
</script>

<style>
.ForgotPassword {
  max-width: 750px;
  min-height: 400px !important;
  margin-bottom: 200px;
}
.ForgotPassword_top {
  height: 50px;
  width: 100%;
}
.btn_submit {
  width: 80px;
  height: 40px;
  background-color:#5c836e;
  color:#FFFFFF;
}

.btn_submit:hover {
  background-color: #444;
}


</style>