<template>
  <div class="MyDiscussion w-100 h-auto">
    <div
      v-if="isLoading"
      class="h-100 w-100 d-flex align-items-center justify-content-center"
      style="height: 400px !important"
    >
      <Loader :size="40" />
    </div>
    <SearchEmptyState v-else-if="isEmpty" text="review" />
    <div v-else>
      <div
        class="d-flex align-items-center justify-content-start m-1 mt-4"
        style="height: 40px"
      >
        <h6 class="p-0 m-0 font-bold font-75">
          Result: {{ reviews.length }}
          {{ textPluralize(reviews.length, "Review", "Reviews") }}
        </h6>
      </div>
      <div class="flex flex-col space-y-4">
        <div v-for="review in reviews" :key="review.id">
          <div class="MyReview card">
            <div class="row container-xl m-0 p-2 relative">
              <router-link
                :to="`/book/${review.bookId}`"
                class="col-md-3 flex-center bg-success-subtle hover-zoom rounded-7 p-2"
              >
                <img
                  :src="review.bookImages"
                  class="card-img img-fluid m-2 book_image p-1 rounded-7 object-contain"
                  alt="book_image"
                />
              </router-link>
              <div class="col-md-9 space-y-4 flex flex-col justify-around">
                <h5 class="card-title font-bold ellipsis-2">
                  {{ review.bookTitle }}
                </h5>
                <ReviewItem
                  :review="review"
                  @on-remove-review="onRemoveReview($event)"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ReviewItem from "../book-detail/ReviewItem.vue";
import ReviewController from "../../controllers/ReviewController";
export default {
  name: "MyReviews",
  components: { ReviewItem },
  data() {
    return {
      reviews: [],
      isLoading: false,
    };
  },
  computed: {
    isEmpty() {
      return this.reviews && this.reviews.length == 0;
    },
  },
  methods: {
    onRemoveReview(id) {
      this.reviews = this.reviews.filter((review) => review.id !== id);
    },
  },
  async mounted() {
    this.isLoading = true;
    this.reviews = await ReviewController.getMyReviews();
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
