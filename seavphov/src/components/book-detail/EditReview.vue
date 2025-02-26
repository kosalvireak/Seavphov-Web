<template>
  <form
    v-on:submit.prevent="editReview()"
    class="d-flex flex-column align-items-end position-relative mt-4 min-h-40"
  >
    <div class="w-100">
      <MDBTextarea
        label="Edit review"
        class="py-3"
        rows="3"
        v-model="review.body"
        required
      />
    </div>

    <LoadingButton
      @click="finishEditing()"
      class="w-20 position-absolute end-24 bottom-2"
      color="gray"
      text="Cancel"
      type="button"
    />
    <LoadingButton
      :isLoading="isLoading"
      class="w-20 position-absolute end-0 bottom-2"
      text="Done"
      type="submit"
    />
  </form>
</template>

<script>
import { MDBTextarea } from "mdb-vue-ui-kit";
import ReviewController from "../../controllers/ReviewController";
export default {
  name: "editReview",
  components: { MDBTextarea },
  props: ["review"],
  data() {
    return {
      isLoading: false,
      formData: new FormData(),
    };
  },
  methods: {
    async editReview() {
      this.isLoading = true;

      this.formData.append("_method", "put");
      this.formData.append("id", this.review.id);
      this.formData.append("body", this.review.body);
      this.review.body = await ReviewController.editReview(this.formData);

      this.$emit("update:review", this.review);
      this.finishEditing();

      this.isLoading = false;
    },

    finishEditing() {
      this.$emit("finishEditing");
    },
  },
};
</script>

<style></style>
