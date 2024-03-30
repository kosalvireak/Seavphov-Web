<template>
  <div class="container-sm">
    <div class="row">
      <div
        class="LeftSide d-flex flex-column flex-wrap col-sm-12 col-lg-8 p-0 rounded-7 bg-seavphov-light ps-3"
      >
        <div class="d-flex h-70 row" style="height: 70%">
          <img
            :src="book.images"
            class="book_cover p-3 img-fluid col-5 h-100"
            alt="book cover"
          />
          <div class="col-7 px-lg-4 px-sm-1 h-100">
            <div class="title_div h-50 overflow-auto">
              <p class="book_title font-Roboto mt-3">
                {{ book.title }}
              </p>
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
              <button class="border-0 my-1 bg-seavphov-light p-0">
                <i
                  class="fa-solid fa-bookmark fa-2xl"
                  style="color: yellow"
                  v-if="book.issaved"
                  @click="toggleIsSaved()"
                ></i>
                <i
                  class="fa-regular fa-bookmark fa-2xl"
                  style="color: darkgrey"
                  v-else
                  @click="toggleIsSaved()"
                ></i>
              </button>
            </div>
          </div>
        </div>
        <div class="pe-3" style="height: 30%">
          <h3
            class="d-flex ps-1 font-Roboto"
            style="color: black; font-weight: bold"
          >
            Description
          </h3>
          <div
            class="d-flex overflow-auto mx-1 my-1"
            style="width: 100%; height: 120px"
          >
            <p>
              {{ book.descriptions }}
            </p>
          </div>
        </div>
      </div>

      <!-- Right Container -->
      <div class="d-flex flex-column col-sm-12 col-lg-4 ps-lg-3 p-0 rounded-7">
        <div
          class="bg-seavphov rounded-7 d-flex align-items-center justify-content-center flex-wrap flex-row mt-3 mt-lg-0 bg-seavphov-light"
          style="height: 150px"
        >
          <div
            class="d-flex justify-content-evenly flex-row align-items-center"
          >
            <img
              src="/img/profile.JPG?url"
              class="profile_image"
              alt="profile_img"
            />
            <div
              class="d-flex flex-column justify-content-evenly mx-2 my-1 ms-4"
              style="height: 90px"
            >
              <h5 class="font-Roboto">Khoeun Kosalvireak</h5>
              <h6>Information Technology Engineering</h6>
              <p class="text-active p-0 m-0" style="color: ">
                Last Active: <u>10 months ago</u>
              </p>
            </div>
          </div>
        </div>

        <!-- User Contact -->
        <div
          class="rounded-7 d-flex flex-wrap flex-column mt-3 bg-seavphov-light h-100"
        >
          <div class="d-flex flex-column w-100">
            <h4 class="mx-3 mt-3 font-Roboto">Contact</h4>
            <div class="d-flex flex-row my-2 mx-3">
              <img
                src="/img/cellcard.png?url"
                class="mobile_image mx-1"
                alt="mobile_img"
                style="width: 28px; height: 28px; object-fit: cover"
              />
              <h5 class="ml-5" style="font-size: 18px; margin-top: 2.5px">
                012 123 890
              </h5>
            </div>

            <!-- Chat Button -->
            <div class="chat_button d-flex justify-content-center">
              <button type="button" class="btn w-50 rounded-6">
                <span><i class="fas fa-commenting fa-2xl me-1"></i></span>
                Chat
              </button>
            </div>
            <hr class="custom-hr d-flex mx-4 justify-content-center" />

            <!-- Location & Map -->
            <div class="location d-flex flex-wrap flex-column my-1 mx-3">
              <h6>
                <span><i class="fas fa-map-pin fa-xl me-1"></i></span>Location
              </h6>

              <!-- Map -->
              <div id="map" class="w-100 d-flex justify-content-center mt-3">
                <div class="gmap_canvas">
                  <iframe
                    class="rounded-7"
                    src="https://maps.google.com/maps?q=aeon%20mall%20sensok&amp;t=&amp;z=15&amp;ie=UTF8&amp;iwloc=&amp;output=embed"
                    frameborder="0"
                    scrolling="no"
                    style="width: 360px; height: 200px"
                  >
                  </iframe>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="RelatedBooks mt-5">
      <hr />
      <h5 class="fw-bold">Related Books</h5>
      <RenderBook :books="relatedBooks" />
    </div>
  </div>
</template>

<script>
import RenderBook from "../components/RenderBook.vue";
export default {
  name: "BookDetail",
  components: { RenderBook },
  data() {
    return {
      paramsId: this.$route.params.id,
      relatedBooks: [],
      filters: {
        categories: "",
      },
    };
  },
  methods: {
    async getBook() {
      await this.$store.dispatch("fetchBookById", this.paramsId);
      this.filters.categories = this.$store.state.book.categories;
      await this.$store.dispatch("fetchBooksWithFilter", this.filters);
      this.relatedBooks = this.$store.state.filteredFetchBook;
    },
    toggleIsSaved() {
      this.$store.dispatch("changeIsSaved", this.paramsId);
    },
  },
  computed: {
    book() {
      return this.$store.state.book;
    },
  },
  beforeRouteUpdate(to, from, next) {
    this.paramsId = to.params.id;
    this.getBook();
    next();
  },
  async mounted() {
    this.getBook();
  },
};
</script>

<style scoped>
.right_side {
  display: flex;
  flex-direction: column;
  flex-wrap: wrap;
  width: auto;
}
.LeftSize {
  height: 650px;
}
.book_cover {
  object-fit: cover;
  max-width: 100%;
  height: 100%;
  border-radius: 20px;
  flex-direction: column;
}

.title_div {
  overflow: visible;
  text-overflow: ellipsis;
}
.title_div > p {
  overflow: visible;
}

.book_title {
  color: black;
  font-size: 40px;
  font-weight: bold;
}

.profile_image {
  width: 90px;
  height: 90px;
  border-radius: 9999px;
  object-fit: cover;
  border: 3px solid #9fb97f;
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
.open > .dropdown-toggle.btn {
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

.mapouter {
  position: relative;
  height: 200px;
  width: 360px;
  background: #fff;
  border-radius: 15px;
}

.maprouter a {
  color: #fff !important;
  position: absolute !important;
  top: 0 !important;
  z-index: 0 !important;
}

.gmap_canvas {
  overflow: hidden;
  height: max-content;
  width: max-content;
}

@media (max-width: 992px) {
  .book_cover {
    max-width: 200px;
    height: 300px;
  }
  .book_title {
    font-size: 30px;
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