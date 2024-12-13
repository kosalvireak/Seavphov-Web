<template>
  <div
    id="carouselInterval"
    class="carousel container absolute slide w-100 h-100 rounded-7 justify-content-center align-content-center"
    data-bs-ride="carousel"
    data-bs-interval="5000"
  >
    <div class="carousel-inner carousel-img flex my-auto">
      <div
        v-for="(book, index) in books"
        :key="index"
        :class="{ 'carousel-item': true, active: index === 0 }"
      >
        <CarouselItem :book="book" :key="book.id" />
      </div>
    </div>
    <div class="carousel-indicators relative bottom-0 w-100 m-0">
      <button
        v-for="(book, index) in books"
        :key="index"
        type="button"
        :data-bs-target="'#carouselInterval'"
        :data-bs-slide-to="index"
        :class="{ active: index === 0 }"
        aria-current="true"
        :aria-label="'Slide ' + (index + 1)"
      ></button>
    </div>
    <template v-if="showIndicator">
      <button
        class="carousel-control-prev carousel-img"
        type="button"
        data-bs-target="#carouselInterval"
        data-bs-slide="prev"
      >
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button
        class="carousel-control-next carousel-img"
        type="button"
        data-bs-target="#carouselInterval"
        data-bs-slide="next"
      >
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </template>
  </div>
</template>

<script>
import CarouselItem from "./home/CarouselItem.vue";
export default {
  name: "Carousel",
  components: { CarouselItem },
  data() {
    return {
      showIndicator: false,
    };
  },
  props: {
    books: Array, // Change Object to Array for the props
  },
};
</script>


<style scoped>
@media (max-width: 576px) {
  .carousel-img {
    height: 250px !important;
  }
}
.carousel-indicators {
  position: relative !important;
}
</style>