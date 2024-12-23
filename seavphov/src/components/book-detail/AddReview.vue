<template>
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
</template>

<script>
import { MDBTextarea } from "mdb-vue-ui-kit";
export default {
  name: "AddReview",
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