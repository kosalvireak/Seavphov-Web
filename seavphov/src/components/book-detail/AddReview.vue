<template>
  <form
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
    <FwbButton gradient="green" class="ml-auto text-sm"> Submit </FwbButton>
  </form>
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
      formData: new FormData(),
    };
  },
  methods: {
    async addReview() {
      if (!this.review.body.trim()) {
        this.$toast.warning("Review can't be empty");
      }
      this.formData.append("body", this.review.body);
      this.formData.append("book_id", this.book_id);
      const data = await this.$store.dispatch("createReview", this.formData);
      if (data) {
        console.log("Review", data);
      }
    },
  },
};
</script>

<style>
</style>