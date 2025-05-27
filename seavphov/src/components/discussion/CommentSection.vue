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
    discussion: {
      type: Object,
    },
  },
  data() {
    return {
      comments: [],
      isLoading: false,
    };
  },
  methods: {
    onRemoveComment(id) {
      this.discussion.number_of_comments--;
      this.comments = this.comments.filter((comment) => comment.id !== id);
    },
    onAddComment(comment) {
      this.discussion.number_of_comments++;
      if (!this.comments) {
        this.comments = [];
        this.comments.push(comment);
      } else {
        this.comments.unshift(comment);
      }
    },
  },
  watch: {
    discussion_id: {
      immediate: true,
      async handler() {
        if (this.discussion_id === undefined) return;
        this.isLoading = true;
        this.comments = await CommentController.getCommentsOfDiscussion(
          this.discussion_id,
        );
        this.isLoading = false;
      },
    },
  },
};
</script>

<style></style>
