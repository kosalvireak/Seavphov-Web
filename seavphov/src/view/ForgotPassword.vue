<template>
  <div class="ForgotPassword row">
    <div class="container d-flex-center col-md-6 col-sm-12 flex-column">
      <h2>Forgot Password</h2>
      <p>
        Enter your email address we will send a token for reset your password .
      </p>
      <form v-on:submit.prevent="SendEmail()">
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
        <button
          type="submit"
          class="btn btn-primary mt-2 d-flex-center btn_submit"
        >
          <span v-if="!isLoading">Send</span>
          <Loader v-else :size="20" :Color="'#FFFFFF'" />
        </button>
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
      isLoading: false,
      Error: false,
      errorMessage: "",
      page: "",
    };
  },
  methods: {
    async SendEmail() {
      this.isLoading = true;
      await this.$store.dispatch("registerUser", signupData);
      this.isLoading = false;
    },
  },
};
</script>

<style>
.ForgotPassword {
  width: 800px;
  height: 500px;
  margin-bottom: 100px;
}
.btn_submit {
  width: 80px;
  height: 40px;
}
</style>