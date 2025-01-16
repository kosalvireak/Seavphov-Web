<template>
  <section>
    <div
      v-if="!isLogin"
      class="w-100 h-24 flex-center flex-column border rounded-lg justify-content-evenly"
    >
      <p class="mb-0">Sign up to leave a comment!</p>

      <FwbButton
        @click="toRouteName('signup')"
        gradient="green"
        class="m-0 px-2 text-xs w-fit"
        >Signup</FwbButton
      >
    </div>
    <form
      v-else
      v-on:submit.prevent="addComment()"
      class="d-flex flex-column align-items-end"
    >
      <div class="w-100 mb-2">
        <MDBTextarea
          label="Add a comment"
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
  name: "addComment",
  components: { MDBTextarea },
  props: {
    discussion_id: {
      type: [Number, String],
    },
  },
  data() {
    return {
      comment: {
        body: "",
      },
      isLoading: false,
    };
  },
  methods: {
    async addComment() {
      if (!this.review.body.trim()) {
        this.$toast.warning("Comment can't be empty");
      }
      this.isLoading = true;
      let formData = new FormData();
      formData.append("body", this.review.body);
      formData.append("discussion_id", this.discussion_id);
      const data = await this.$store.dispatch("addComment", formData);
      this.resetForm();
      this.isLoading = false;
      data.delete_able = true;
      if (data) {
        this.$emit("onAddComment", data);
      }
    },
    resetForm() {
      this.comment.body = "";
    },
  },
};
</script>

<style></style>
