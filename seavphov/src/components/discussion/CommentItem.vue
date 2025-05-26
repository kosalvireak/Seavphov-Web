<template>
  <section
    class="CommentItem rounded-lg p-2 space-y-2 ring-1 ring-gray-300 relative"
  >
    <!-- Comment header -->
    <a
      :href="`/profile/${comment.user[0].uuid}`"
      class="d-flex justify-content-start align-items-center text-decoration-none clickable w-100 space-x-2 mt-2"
    >
      <img
        class="sp-logo-sm rounded-full ms-2"
        :src="comment.user[0].picture"
      />
      <div class="flex-col">
        <p class="m-0 text-sp-dark">{{ comment.user[0].name }}</p>

        <!-- Comment Date -->
        <p class="text-xs text-sp-gray m-0">
          Commented on {{ formatDate(comment.created_at) }}
        </p>
      </div>
    </a>

    <!-- Comment delete Button -->
    <CommentItemDropdown
      v-if="comment.delete_able || comment.edit_able"
      :id="comment.id"
      :comment="comment"
      @on-remove="$emit('onRemove', $event)"
      @on-edit="isEditing = true"
    />

    <EditComment
      v-if="isEditing"
      :comment="comment"
      @finish-editing="isEditing = false"
    />

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
import EditComment from "./EditComment.vue";
import { MDBTextarea } from "mdb-vue-ui-kit";
import Reaction from "../common/Reaction.vue";
import CommentItemDropdown from "./CommentItemDropdown.vue";
export default {
  name: "CommentItem",
  components: { MDBTextarea, CommentItemDropdown, Reaction, EditComment },
  props: {
    comment: Object,
  },
  data() {
    return {
      isEditing: false,
    };
  },
};
</script>

<style></style>
