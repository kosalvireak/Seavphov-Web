<template>
  <section class="CommentSection space-y-4">
    <AddComment
      :discussion_id="discussion_id"
      @on-add-comment="onAddComment($event)"
    />
    <CommentItem
      v-for="comment in comments"
      :key="comment.id"
      :comment="comment"
      @on-remove="onRemoveComment($event)"
    />
    <div v-if="isLoading" class="w-100 h-24 flex-center">
      <Loader :size="30" />
    </div>
  </section>
</template>

<script>
import AddComment from "./AddComment.vue";
import CommentItem from "./CommentItem.vue";
import CommentController from "../../controllers/CommentController";
export default {
  name: "CommentSection",
  components: { AddComment, CommentItem },
  props: {
    discussion_id: {
      type: [Number, String],
    },
  },
  data() {
    return {
      comments: [],
      isLoading: false,
    };
  },
  methods: {
    onAddComment(review) {
      this.comments.unshift(review);
    },
    onRemoveComment(id) {
      this.comments = this.comments.filter((comment) => comment.id !== id);
    },
  },
  watch: {
    discussion_id: {
      immediate: true,
      async handler() {
        if (this.discussion_id === undefined) return;
        this.isLoading = true;
        this.comments = await CommentController.fetchDiscussionComments(
          this.discussion_id,
        );
        this.isLoading = false;
      },
    },
  },
};
</script>

<style></style>
