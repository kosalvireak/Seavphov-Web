<template>
  <section class="AddComment container p-0">
    <div
      v-if="!isLogin"
      class="w-100 h-24 flex-center flex-column border rounded-lg justify-content-evenly"
    >
      <p class="mb-0">Sign in to leave a comment!</p>

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
      <div class="position-relative w-100 mb-2">
        <MDBTextarea
          label="Add a comment"
          class="py-3"
          rows="3"
          v-model="comment.body"
          required
        />
        <LoadingButton
          :isLoading="isLoading"
          class="w-20 position-absolute end-0 bottom-0 me-2 mb-2"
          text="Comment"
          type="submit"
        />
      </div>
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
      if (!this.comment.body.trim()) {
        this.$toast.warning("Comment can't be empty");
      }
      this.isLoading = true;
      let formData = new FormData();
      formData.append("body", this.comment.body);
      formData.append("discussion_id", this.discussion_id);
      const data = await this.$store.dispatch("createComment", formData);
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
