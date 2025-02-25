<template>
  <form
    v-on:submit.prevent="editComment()"
    class="d-flex flex-column align-items-end position-relative mt-4 min-h-40"
  >
    <div class="w-100">
      <MDBTextarea
        label="Edit comment"
        class="py-3"
        rows="3"
        v-model="comment.body"
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
import CommentController from "../../controllers/CommentController";
import { MDBTextarea } from "mdb-vue-ui-kit";
export default {
  name: "EditComment",
  components: { MDBTextarea },
  props: ["comment"],
  data() {
    return {
      isLoading: false,
      formData: new FormData(),
    };
  },
  methods: {
    async editComment() {
      this.isLoading = true;

      this.formData.append("_method", "put");
      this.formData.append("id", this.comment.id);
      this.formData.append("body", this.comment.body);
      this.comment.body = await CommentController.editComment(this.formData);

      this.$emit("update:comment", this.comment);
      this.finishEditing();
      this.isLoading = false;
    },

    finishEditing() {
      this.$emit("finishEditing");
    },
  },
};
</script>

<style>
</style>