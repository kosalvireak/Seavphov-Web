<template>
  <section class="Banners shadow-5 rounded-7 d-flex-center m-2 flex-column">
    <Carousel class="m-3" />
    {{ banners }}
  </section>
</template>

<script>
import Carousel from "../Carousel.vue";
export default {
  name: "Banners",
  components: { Carousel },
  data() {
    return {
      banners: {},
      isLoading: false,
    };
  },
  methods: {
    async adminGetBanners() {
      this.isLoading = true;
      this.banners = await this.$store.dispatch("adminGetBanners");
      this.isLoading = false;
    },
  },
  async mounted() {
    this.adminGetBanners();
  },
};
</script>

<style>
/* .Banners {
  width: 20rem;
  height: 10rem;
  background-color: white;
} */
</style>