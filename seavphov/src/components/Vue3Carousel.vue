<template>
  <carousel
    v-if="!isBooksEmpty"
    :itemsToShow="7"
    :wrapAround="false"
    :transition="700"
    :autoplay="2000"
  >
    <Slide v-for="book in books" :key="book">
      <router-link
        :to="`/book/${book.id}`"
        class="img_container bg-image hover-overlay hover-zoom hover-shadow ripple"
      >
        <img :src="book.images" class="img-fluid book_img" />
        <a href="#">
          <div class="mask" style="background-color: hsla(0, 0%, 75%, 0.5)">
            <div class="d-flex justify-content-center align-items-center h-100">
              <p
                class="text-black mb-0 text-center p-2 text-small"
                style="font-size: smaller"
              >
                {{ book.title }}
              </p>
            </div>
          </div>
        </a>
      </router-link>
    </Slide>

    <template #addons>
      <Navigation />
      <Pagination />
    </template>
  </carousel>
</template>
  
  <script>
import "vue3-carousel/dist/carousel.css";
import { Carousel, Slide, Pagination, Navigation } from "vue3-carousel";
import Book from "../components/Book.vue";
export default {
  name: "App",
  components: {
    Carousel,
    Slide,
    Pagination,
    Navigation,
    Book,
  },
  data() {
    return {
      books: [],
      filters: {
        all: true,
      },
    };
  },
  methods: {
    async getBooks() {
      this.books = await this.$store.dispatch(
        "fetchBooksWithFilter",
        this.filters
      );
    },
  },
  computed: {
    isBooksEmpty() {
      if (this.books.length == 0) {
        return true;
      } else {
        return false;
      }
    },
  },
  mounted() {
    this.getBooks();
  },
};
</script>
<style scoped>
.img_container {
  height: 150px;
  width: fit-content;
  object-fit: cover;
}
.book_img {
  height: 150px;
  width: auto;
}

.carousel__item {
  min-height: 220px;
  min-width: 150px;
  background-color: aqua;
}
.carousel__slide {
  padding: 5px;
}

.carousel__viewport {
  perspective: 2000px;
  width: auto;
  margin-bottom: 30px !important;
}
.carousel__pagination {
  margin-top: 20px !important;
}

.carousel__track {
  transform-style: preserve-3d;
}

.carousel__slide--sliding {
  transition: 0.5s;
}

.carousel__slide {
  opacity: 0.9;
  transform: rotateY(-20deg) scale(0.9);
}

.carousel__slide--active ~ .carousel__slide {
  transform: rotateY(20deg) scale(0.9);
}

.carousel__slide--prev {
  opacity: 1;
  transform: rotateY(-10deg) scale(0.95);
}

.carousel__slide--next {
  opacity: 1;
  transform: rotateY(10deg) scale(0.95);
}

.carousel__slide--active {
  opacity: 1;
  transform: rotateY(0) scale(1.1);
}
</style>