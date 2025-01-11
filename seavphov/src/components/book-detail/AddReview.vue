<template>
  <section>
    <div
      v-if="!isLogin"
      class="w-100 h-24 flex-center flex-column border rounded-lg justify-content-evenly"
    >
      <p class="mb-0">Sign up to leave a review!</p>

      <FwbButton
        @click="toRouteName('signup')"
        gradient="green"
        class="m-0 px-2 text-xs w-fit"
        >Signup</FwbButton
      >
    </div>
    <form
      v-else
      v-on:submit.prevent="addReview()"
      class="d-flex flex-column align-items-end"
    >
      <div class="w-100 mb-2">
        <MDBTextarea
          label="Enter your review"
          rows="3"
          v-model="review.body"
          required
        />
      </div>
      <LoadingButton :isLoading="isLoading" text="Submit" type="submit" />
    </form>
  </section>
</template>

<script>
import { MDBTextarea } from "mdb-vue-ui-kit";
export default {
  name: "AddReview",
  components: { MDBTextarea },
  props: { book_id: Number },
  data() {
    return {
      review: {
        body: "",
      },
      isLoading: false,
    };
  },
  methods: {
    async addReview() {
      if (!this.review.body.trim()) {
        this.$toast.warning("Review can't be empty");
      }
      this.isLoading = true;
      let formData = new FormData();
      formData.append("body", this.review.body);
      formData.append("book_id", this.book_id);
      const data = await this.$store.dispatch("createReview", formData);
      this.resetForm();
      this.isLoading = false;
      data.delete_able = true;
      if (data) {
        this.$emit("onAddReview", data);
      }
    },
    resetForm() {
      this.review.body = "";
    },
  },
};
</script>

<style></style>
