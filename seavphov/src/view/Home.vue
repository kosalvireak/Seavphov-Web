<template>
  <div class="w-100 h-100 mb-auto">
    <div
      class="hidden md:flex backgroundImg img-fluid w-100 align-items-center justify-content-center"
      :style="getBackground"
    >
      <Carousel v-if="carouselData.length" :books="reversedCarouselData" />
      <Loader v-if="isLoading" :size="40" />
    </div>

    <div class="mt-3 w-100 space-y-8">
      <MostReviewed />
      <NewestAddition />
      <DiscussionHomepage />
      <PaginatedBook />
    </div>
  </div>
</template>

<script>
import MostReviewed from "../components/home/MostReviewed.vue";
import NewestAddition from "../components/home/NewestAddition.vue";
import RenderBook from "../components/RenderBook.vue";
import PaginatedBook from "../components/PaginatedBook.vue";
import Carousel from "../components/home/Carousel.vue";
import DiscussionHomepage from "../components/discussion/DiscussionHomepage.vue";

export default {
  name: "Home",
  components: {
    RenderBook,
    PaginatedBook,
    Carousel,
    NewestAddition,
    MostReviewed,
    DiscussionHomepage,
  },
  data() {
    return {
      reloaded: false,
      filters: {
        categories: "Text-Book",
      },
      carouselData: [],
      isLoading: false,
      banner: {},
      defaultBanner:
        "https://firebasestorage.googleapis.com/v0/b/seavphov-919d7.appspot.com/o/folder%2Fbggreen.png?alt=media&token=192e76f7-53b6-42c3-8e20-c7ecb27451b8",
    };
  },
  methods: {
    async getCarousel() {
      console.log("getCarousel");
      this.isLoading = true;
      this.carouselData = await this.$store.dispatch(
        "fetchBooksWithFilter",
        this.filters,
      );
      this.isLoading = false;
    },
    async getBanner() {
      this.banner = await this.$store.dispatch("getBanner");
    },
  },
  computed: {
    getBackground() {
      if (this.banner && this.banner.image_url) {
        return `background-image: url("${this.banner.image_url}")`;
      } else {
        return `background-image: url("${this.defaultBanner}")`;
      }
    },
    reversedCarouselData() {
      return [...this.carouselData].reverse(); // Create a new array and reverse it
    },
  },
  async mounted() {
    await this.getBanner();
    await this.getCarousel();
  },
};
</script>

<style scoped>
.backgroundImg {
  background-repeat: no-repeat;
  background-size: cover;
  height: 450px;
}

@media (max-width: 640px) {
  .backgroundImg {
    height: 288px;
  }
}
</style>
