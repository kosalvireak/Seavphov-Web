<template>
  <section class="BookReview">
    <h5 class="font-bold text-black">Reader reviews</h5>
    <form v-on:submit.prevent="AddBook()">
      <div class="mb-2">
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
      commentBody: "",
    };
  },
};
</script>

<style>
</style>