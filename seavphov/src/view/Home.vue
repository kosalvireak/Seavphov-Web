<template>
  <div class="w-100 h-100 mb-auto">
    <div
      class="backgroundImg flex-center img-fluid"
      :style="getBackground"
      style="width: 100%; height: 500px"
    >
      <div class="flex-center p-3 w-75 h-100">
        <Carousel v-if="TopBooks.length" :books="TopBooks" />
      </div>
    </div>

    <div class="mt-3 w-auto row">
      <div class="col-9"></div>
      <PaginatedBook class="col-9" />
      <Filter class="col-3 pt-5" />
    </div>
  </div>
</template>

<script>
import RenderBook from "../components/RenderBook.vue";
import PaginatedBook from "../components/PaginatedBook.vue";
import Filter from "../components/Filter.vue";
import Carousel from "../components/Carousel.vue";

export default {
  name: "Home",
  components: { RenderBook, PaginatedBook, Filter, Carousel },
  data() {
    return {
      reloaded: false,
      filters: {
        categories: "Text-Book",
      },
      TopBooks: [],
      banner: {},
      defaultBanner:
        "https://firebasestorage.googleapis.com/v0/b/seavphov-919d7.appspot.com/o/folder%2Fbggreen.png?alt=media&token=192e76f7-53b6-42c3-8e20-c7ecb27451b8",
    };
  },
  methods: {
    async getBook() {
      this.TopBooks = await this.$store.dispatch(
        "fetchBooksWithFilter",
        this.filters
      );
    },
    async getBanner() {
      this.banner = await this.$store.dispatch("getBanner");
    },
  },
  computed: {
    getBackground() {
      if (this.banner != {}) {
        return `background-image: url("${this.banner.image_url}")`;
      } else {
        console.log("else");
        return `background-image: url("${this.defaultBanner}")`;
      }
    },
  },
  async mounted() {
    await this.getBanner();
    await this.getBook(this.paramsId);

    if (!localStorage.getItem("reloaded")) {
      location.reload();
      localStorage.setItem("reloaded", true);
    }
  },
};
</script>

<style scoped>
label {
  font-size: 0.9rem;
}

.h-3rem {
  height: 3rem !important;
}

.margin-top {
  margin-top: 20px !important;
}

.backgroundImg {
  background-repeat: no-repeat;
  background-size: cover;
}
</style>
