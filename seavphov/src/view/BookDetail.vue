<template>
  <div class="container-xl mt-8">
    <div class="BookDetail">
      <div class="grid grid-cols-12 gap-4 h-100">
        <div
          class="hover-zoom col-span-12 lg:col-span-4 align-content-center justify-items-center ring-1 ring-gray-300 rounded-2"
        >
          <img
            :src="book.images"
            class="sp-img-lg object-contain"
            alt="book cover"
          />
        </div>
        <div class="col-span-12 lg:col-span-8 relative space-y-4">
          <div class="flex">
            <p class="h3 pr-10">
              {{ book.title }}
            </p>

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
                    book.issaved ? 'fa-solid text-sp-yellow' : 'fa-regular'
                  "
                  @click="toggleSaveBook()"
                ></i>
              </template>
            </button>
          </div>
          <div class="text-black space-y-4">
            <p><span class="font-bold">Author: </span> {{ book.author }}</p>
            <p>
              <span class="font-bold">Category:</span>
              {{ book.categories }}
            </p>
            <p>
              <span class="font-bold">Condition:</span>
              {{ book.condition }}
            </p>

            <FwbButton :color="buttonColor" class="px-2 text-xs w-fit">{{
              buttonText
            }}</FwbButton>
            <p class="h6">Description</p>
            <div
              class="min-h-auto max-h-44 lg:h-44 overflow-auto text-base bg-gray-100 rounded-md p-2"
            >
              <p>
                {{ book.descriptions }}
              </p>
            </div>

            <a
              v-if="book.has_pdf"
              :href="book.pdf_url"
              target="_blank"
              class="icon-name flex align-items-center"
            >
              <img
                src="../assets/pdf-icon.svg"
                alt="pdf logo"
                class="img-fluid h-8 w-8 mr-2"
              />
              {{ book.pdf_filename }}
            </a>
          </div>
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
      <!-- <RenderBook
        header="Readers also enjoyed"
        :books="relatedBooks"
        :loading="isLoadingRelatedBooks"
      /> -->
    </div>
  </div>
</template>

<script>
import RenderBook from "../components/RenderBook.vue";
import BookAuthorProfile from "../components/book-detail/BookAuthorProfile.vue";
import BookReview from "../components/book-detail/BookReview.vue";
import BookController from "../controllers/BookController";
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
      this.filters.max = this.maxRelatedBook;
      this.filters.excludeId = this.paramsId;
      this.relatedBooks = await BookController.getBooksWithFilter(this.filters);
      this.isLoadingRelatedBooks = false;
    },
    async getBook(id) {
      const response = await BookController.getBookDetailWithOwner(id);
      this.book = response.book;
      this.bookOwner = response.owner;
    },
    async toggleSaveBook() {
      this.loadingSaveBook = true;
      const response = await this.$store.dispatch(
        "toggleSaveBook",
        this.paramsId,
      );
      if (response) {
        this.book.issaved = !this.book.issaved;
      }
      this.loadingSaveBook = false;
    },
  },
  watch: {
    "$route.params.id"() {
      this.reloadPage();
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
