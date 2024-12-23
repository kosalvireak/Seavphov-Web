<template>
  <section class="BookReview">
    <h5 class="font-bold text-black">Reviews</h5>
    <form
      v-on:submit.prevent="addReview()"
      class="d-flex flex-column align-items-end"
    >
      <div class="w-100 mb-2">
        <MDBTextarea
          label="Enter your review"
          rows="3"
          v-model="commentBody"
          required
        />
      </div>
      <FwbButton gradient="green" class="ml-auto text-sm"> Submit </FwbButton>
    </form>
  </section>
</template>

<script>
import { MDBTextarea } from "mdb-vue-ui-kit";
export default {
  name: "BookReview",
  components: { MDBTextarea },
  data() {
    return {
      commentBody: "asd",
    };
  },
  methods: {
    addReview() {
      if (!this.commentBody.trim()) {
        this.$toast.warning("Review can't be empty");
      }
    },
  },
};
</script>

<style>
</style>