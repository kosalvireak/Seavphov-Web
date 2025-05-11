<template>
  <div class="MyComments w-100 h-auto">
    <div
      v-if="isLoading"
      class="h-100 w-100 d-flex align-items-center justify-content-center"
      style="height: 400px !important"
    >
      <Loader :size="40" />
    </div>
    <div v-else>
      <div v-if="!isEmpty">
        <div
          class="d-flex align-items-center justify-content-end m-1 mt-4"
          style="height: 40px"
        >
          <h6 class="p-0 m-0 font-bold font-75">
            Result: {{ comments.length }} Comments
          </h6>
        </div>
        <div class="flex flex-col space-y-4">
          <div v-for="data in comments" :key="data.id">
            <div class="MyComment card">
              <div class="row container-xl m-0 p-2 relative">
                <router-link
                  :to="`/discussion/${data.discussion.id}`"
                  class="col-md-3 flex-center bg-success-subtle hover-zoom rounded-7 p-2"
                >
                  <img
                    :src="data.discussion.image"
                    class="card-img img-fluid m-2 book_image p-1 rounded-7 object-contain"
                    alt="book_image"
                  />
                </router-link>
                <div class="col-md-9 space-y-4 flex flex-col justify-around">
                  <h5 class="card-title font-bold ellipsis-2">
                    {{ data.discussion.body }}
                  </h5>
                  <CommentItem
                    :key="data.comment.id"
                    :comment="data.comment"
                    @on-remove="onRemoveComment($event)"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <SearchEmptyState v-else text="comment" />
    </div>
  </div>
</template>

<script>
import CommentController from "../../controllers/CommentController";
import CommentItem from "../discussion/CommentItem.vue";
export default {
  name: "MyComments",
  components: { CommentItem },
  data() {
    return {
      comments: [],
      isLoading: false,
    };
  },

  computed: {
    isEmpty() {
      return this.comments && this.comments.length == 0;
    },
  },
  methods: {
    onRemoveComment(id) {
      this.comments = this.comments.filter((review) => review.id !== id);
    },
  },
  async mounted() {
    this.isLoading = true;
    this.comments = await CommentController.getMyComments();
    this.isLoading = false;
  },
};
</script>

<style scoped>
@media only screen and (max-width: 576px) {
  .font-75 {
    font-size: 75%;
  }
}
</style>
<style scoped>
.book_image {
  height: 14rem;
  width: 14rem;
}

@media (max-width: 768px) {
  .book_image {
    height: 12rem;
    width: 12rem;
  }
}
</style>
