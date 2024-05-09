<template>
  <div
    class="ForgotPassword shadow-5 d-flex-center flex-column col-md-6 col-sm-12 justify-content-between m-3"
  >
    <h2 class="mt-2">Forgot Password</h2>

    <div v-if="page == 1" class="d-flex-center flex-column">
      <h5 class="my-3">
        Enter your email address we will send a token for reset your password .
      </h5>
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
            class="btn btn-primary mt-2 d-flex-center btn_submit"
          >
            <span v-if="!isLoading">Send</span>
            <Loader v-else :size="20" :Color="'#FFFFFF'" />
          </button>
        </div>
      </form>
    </div>

    <div
      class="ForgotPassword_buttom border-top d-flex-center justify-content-between"
    >
      <span>
        <i
          v-if="page == 2"
          @click="switchPage(1)"
          class="fa fa-arrow-circle-left fa-xl ms-3 cursor-pointer"
        ></i>
      </span>
      <span>
        <i
          v-if="page == 1"
          @click="switchPage(2)"
          class="fa fa-arrow-circle-right fa-xl me-3 cursor-pointer"
        ></i>
      </span>
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
      isLoading: false,
      Error: false,
      errorMessage: "",
      page: "2",
    };
  },
  methods: {
    async SendEmail() {
      this.isLoading = true;
      await this.$store.dispatch("registerUser", signupData);
      this.isLoading = false;
    },
    switchPage(page) {
      this.page = page;
    },
  },
};
</script>

<style>
.ForgotPassword {
  max-width: 750px;
  min-height: 400px;
  margin-bottom: 200px;
}
.ForgotPassword_buttom {
  height: 50px;
  width: 100%;
}
.btn_submit {
  width: 80px;
  height: 40px;
}
</style>