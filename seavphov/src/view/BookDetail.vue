<template>
  <div class="container mt-8">
    <div class="BookDetail">
      <div class="grid grid-cols-12 gap-4 h-100">
        <div
          class="col-span-12 lg:col-span-4 align-content-center justify-items-center ring-1 ring-gray-300 rounded-2"
        >
          <img :src="book.images" class="sp-img-lg" alt="book cover" />
        </div>
        <div class="col-span-12 lg:col-span-8 relative">
          <div class="flex">
            <h3 class="text-black font-bold pr-10">
              {{ book.title }}
            </h3>
          </div>
          <div class="text-black space-y-3">
            <p><span class="font-bold">by</span> {{ book.author }}</p>
            <p>
              <span class="font-bold">Category</span>:
              {{ book.categories }}
            </p>
            <p>
              <span class="font-bold">Condition</span>:
              {{ book.condition }}
            </p>
            <FwbButton
              :color="buttonColor"
              class="mt-3 mb-1 px-2 text-xs w-fit"
              >{{ buttonText }}</FwbButton
            >
            <h5 class="font-bold">Overview</h5>
            <div class="max-h-44 lg:h-44 overflow-auto">
              <p>
                {{ book.descriptions }}
              </p>
            </div>
          </div>
          <!-- Bookmark -->
          <button
            class="absolute top-1 end-0 w-10 h-10 justify-items-center"
            v-if="isLogin"
          >
            <Loader v-if="loadingSaveBook" :size="10" />
            <template v-else>
              <i
                class="fa-bookmark fa-2xl w-10 h-10"
                :class="
                  book.issaved
                    ? 'fa-solid text-yellow-300 border-2 border-black rounded-md'
                    : 'fa-regular'
                "
                @click="toggleSaveBook()"
              ></i>
            </template>
          </button>
        </div>
      </div>
      <div class="grid grid-cols-12 gap-4 mt-4">
        <div class="col-span-12 lg:col-span-4">
          <BookAuthorProfile v-if="bookOwner" :owner="bookOwner" />
        </div>
        <div class="col-span-12 lg:col-span-8">
          <BookReview :book_id="paramsId" />
        </div>
      </div>
    </div>
    <div class="RelatedBooks mt-5">
      <hr />
      <RenderBook
        header="Readers also enjoyed"
        :books="relatedBooks"
        :loading="isLoadingRelatedBooks"
      />
    </div>
  </div>
</template>

<script>
import RenderBook from "../components/RenderBook.vue";
import BookAuthorProfile from "../components/book-detail/BookAuthorProfile.vue";
import BookReview from "../components/book-detail/BookReview.vue";
export default {
  name: "BookDetail",
  components: { RenderBook, BookAuthorProfile, BookReview },
  data() {
    return {
      paramsId: this.$route.params.id,
      book: {},
      relatedBooks: [],
      filters: {
        categories: "",
      },
      bookOwner: {},
      isLoadingRelatedBooks: false,
      loadingSaveBook: false,
      issaved: true,
      formData: new FormData(),
    };
  },
  methods: {
    async getRelatedBooks() {
      this.isLoadingRelatedBooks = true;
      this.filters.categories = this.book.categories;
      this.relatedBooks = await this.$store.dispatch(
        "fetchBooksWithFilter",
        this.filters
      );
      this.isLoadingRelatedBooks = false;
    },
    async getBook(id) {
      this.formData.append("id", id);
      if (this.isLogin) {
        this.formData.append("uuid", this.$store.state.user.uuid);
      }
      [this.book, this.bookOwner] = await this.$store.dispatch(
        "fetchBookById",
        this.formData
      );
    },
    async toggleSaveBook() {
      this.loadingSaveBook = true;
      const response = await this.$store.dispatch(
        "toggleSaveBook",
        this.paramsId
      );
      if (response) {
        this.book.issaved = !this.book.issaved;
      }
      this.loadingSaveBook = false;
    },
  },
  watch: {
    "$route.params.id"() {
      this.$router.go(0);
    },
  },
  computed: {
    buttonColor() {
      return this.book.availability ? "green" : "red";
    },
    buttonText() {
      return this.book.availability ? "AVAILABLE" : "NOT AVAILABLE";
    },
  },
  async created() {
    await this.getBook(this.paramsId);
    await this.getRelatedBooks();
  },
};
</script>

<style scoped>
p {
  margin: 0;
}
</style>
