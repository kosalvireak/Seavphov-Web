<template>
  <div class="container-sm">
    <div class="row">
      <div class="LeftSide d-flex flex-column flex-wrap col-sm-12 col-lg-8 p-0 rounded-7 bg-seavphov-light ps-3">
        <div class="d-flex h-top row me-0">
          <img :src="book.images" class="book_cover img-fluid col-5 h-100 p-3" alt="book cover" />
          <div class="col-7 px-lg-4 px-sm-1 h-100">
            <div class="title_div h-50 overflow-auto">
              <h3 class="book_title font-Roboto mt-3">
                {{ book.title }}
              </h3>
            </div>

            <div class="h-50 BookDetailButtom">
              <p class="book_author my-2 mt-0">
                <u class="fw-bold text-black">Author</u>: {{ book.author }}
              </p>
              <p class="book_category my-2">
                <u class="fw-bold text-black">Category</u>:
                {{ book.categories }}
              </p>
              <p class="book_condition my-2">
                <u class="fw-bold text-black">Book Condition</u>:
                {{ book.condition }}
              </p>

              <!-- Bookmark -->
              <button class="border-0 my-1 bg-seavphov-light p-0" v-if="isLogin">
                <Loader v-if="isLoading1" :size="10" :Color="'#000000'" />
                <div v-if="!isLoading1">
                  <i class="fa-solid fa-bookmark fa-2xl" style="color: yellow" v-if="book.issaved"
                    @click="onSaveBook(false)"></i>
                  <i class="fa-regular fa-bookmark fa-2xl" style="color: darkgrey" v-else @click="onSaveBook(true)"></i>
                </div>
              </button>
            </div>
          </div>
        </div>
        <div class="pe-3 h-buttom">
          <h3 class="d-flex ps-1 font-Roboto" style="color: black; font-weight: bold">
            Description
          </h3>
          <div class="d-flex overflow-auto mx-1 my-1" style="width: 100%; height: 120px">
            <p>
              {{ book.descriptions }}
            </p>
          </div>
        </div>
      </div>

      <!-- Right Container -->
      <BookAuthorProfile v-if="owner" :owner="owner" />
    </div>
    <div class="RelatedBooks mt-5">
      <hr />
      <h5 class="fw-bold">Related Books</h5>
      <RenderBook :books="relatedBooks" :loading="isLoading" />
    </div>
  </div>
</template>

<script>
import RenderBook from "../components/RenderBook.vue";
import BookAuthorProfile from "../components/BookAuthorProfile.vue";
import Loader from "../components/Loader.vue";
export default {
  name: "BookDetail",
  components: { RenderBook, BookAuthorProfile, Loader },
  data() {
    return {
      paramsId: this.$route.params.id,
      book: {},
      relatedBooks: [],
      filters: {
        categories: "",
      },
      owner: {},
      isLoading: false,
      isLoading1: false,
      issaved: true,
      formData: new FormData(),
    };
  },
  methods: {
    async getRelatedBooks() {
      this.isLoading = true;
      this.filters.categories = this.book.categories;
      this.relatedBooks = await this.$store.dispatch(
        "fetchBooksWithFilter",
        this.filters
      );
      this.isLoading = false;
    },
    async getBook(id) {
      this.formData.append("id", id);
      if (this.isLogin) {
        this.formData.append("uuid", this.$store.state.user.uuid);
      }
      [this.book, this.owner] = await this.$store.dispatch(
        "fetchBookById",
        this.formData
      );
    },
    onSaveBook(bool) {
      this.book.issaved = bool;
      this.isLoading1 = true;
      if (bool) {
        this.$store.dispatch("saveBook", this.paramsId);
        this.isLoading1 = false;
      } else {
        this.$store.dispatch("unSaveBook", this.paramsId);
        this.isLoading1 = false;
      }
    },
  },
  computed: {
    isLogin() {
      return this.$store.getters.isLogin;
    },
  },
  watch: {
    "$route.params.id"() {
      this.$router.go(0);
    },
  },
  async created() {
    await this.getBook(this.paramsId);
    await this.getRelatedBooks();
  },
};
</script>

<style scoped>
.book_cover {
  object-fit: contain;
  max-width: 100%;
  height: 100%;
  border-radius: 20px;
  flex-direction: column;
}

.title_div {
  overflow: visible;
  text-overflow: ellipsis;
}

.title_div>p {
  overflow: visible;
}

.book_title {
  color: black;
  font-weight: bold;
}

.text-active {
  font-size: 12px;
}

.mobile_image {
  border-radius: 9999px;
  border: 2px solid white;
}

.btn {
  color: #fff;
  background-color: #588157;
}

.btn:hover,
.btn:focus,
.btn:active,
.btn.active,
.open>.dropdown-toggle.btn {
  color: black;
  background-color: #588157;
  border-color: black;
  opacity: 0.75;
  /*set the color you want here*/
}

u {
  text-decoration: none;
}

.custom-hr {
  height: 2px;
  background-color: black;
}

.h-top {
  height: 70%;
}

.h-buttom {
  height: 30%;
}

@media (max-width: 992px) {
  .book_cover {
    max-width: 200px;
    height: 300px;
  }

  .book_title {
    font-size: 30px;
  }

  .h-top {
    height: 60%;
  }

  .h-buttom {
    height: 40%;
  }

  .LeftSide {
    height: 500px;
  }
}

@media (max-width: 576px) {
  .book_cover {
    max-width: 200px;
    max-height: 250px;
  }

  .book_title {
    font-size: 20px;
    height: 40%;
  }

  .BookDetailButtom {
    height: 60%;
  }
}
</style>