<template>
  <section
    class="CommentItem container w-100 mb-4 rounded-lg p-2 space-y-2 ring-1 ring-gray-300 relative"
  >
    <!-- Comment header -->
    <a
      :href="`/profile/${comment.user[0].uuid}`"
      class="d-flex justify-content-start align-items-center text-decoration-none clickable w-100 space-x-2"
    >
      <img
        class="sp-logo-sm rounded-full ms-2"
        :src="comment.user[0].picture"
      />
      <div class="flex-col">
        <p class="m-0 text-sp-dark">{{ comment.user[0].name }}</p>

        <!-- Comment Date -->
        <p class="text-xs text-sp-gray m-0">
          commented on {{ formatDate(comment.created_at) }}
        </p>
      </div>
    </a>

    <!-- Comment delete Button -->
    <CommentItemDropdown
      v-if="comment.delete_able"
      :id="comment.id"
      @on-remove="$emit('onRemove', $event)"
      @on-edit="isEditing = true"
    />

    <form
      v-if="isEditing"
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
        @click="isEditing = false"
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

    <section v-else>
      <div class="w-100 min-h-12 m-2">
        {{ comment.body }}
      </div>

      <Reaction
        :entity="comment"
        likeMethodName="likeComment"
        dislikeMethodName="dislikeComment"
      />
    </section>
  </section>
</template>

<script>
import { MDBTextarea } from "mdb-vue-ui-kit";
import Reaction from "../common/Reaction.vue";
import CommentItemDropdown from "./CommentItemDropdown.vue";
import CommentController from "../../controllers/CommentController";
export default {
  name: "CommentItem",
  components: { MDBTextarea, CommentItemDropdown, Reaction },
  props: {
    comment: Object,
  },
  data() {
    return {
      isEditing: false,
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
      this.isLoading = false;
      this.isEditing = false;
    },
  },
};
</script>

<style></style>
