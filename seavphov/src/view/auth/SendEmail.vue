<template>
  <section class="SendEmail flex-center w-full h-screen">
    <div
      class="card container-xl w-auto min-h-96 grid grid-cols-12 p-5 relative flex-center"
    >
      <BackRoute route="login" class="absolute top-3 left-3" />

      <div class="w-40">
        <img src="/img/Seavphov Logo.png" alt="booklogo" class="img-fluid" />
      </div>

      <div class="SendEmailForm flex-center flex-column">
        <p class="my-3">Enter your email address</p>
        <form v-on:submit.prevent="sendEmail()" class="w-100">
          <div class="form-floating mb-3">
            <MDBInput
              type="email"
              label="Email"
              id="email"
              v-model="email"
              wrapperClass="bg-white h-3rem w-80"
              required
            />
          </div>
          <p v-if="Error" class="text-danger">{{ errorMessage }}</p>
          <div class="form-floating flex-center justify-content-end">
            <LoadingButton type="submit" text="Next" :isLoading="isLoading" />
          </div>
        </form>
      </div>
    </div>
  </section>
</template>

<script>
import { MDBInput } from "mdb-vue-ui-kit";
export default {
  name: "SendEmail",
  components: { MDBInput },
  data() {
    return {
      email: "",
      isLoading: false,
      errorMessage: "",
    };
  },
  methods: {
    async sendEmail() {
      this.isLoading = true;
      const formData = new FormData();
      formData.append("email", this.email);
      await this.$store.dispatch("sendEmailResetPassword", formData);
      this.toRouteName("forgot-password");
      this.isLoading = false;
    },
  },
};
</script>

<style>
</style>
