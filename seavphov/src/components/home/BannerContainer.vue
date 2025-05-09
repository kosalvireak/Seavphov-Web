<template>
  <section class="AdsContainer container-xl h-40 lg:h-72">
    <a :href="banner.link_url" target="_blank">
    <img
      :src="getBackground"
      alt=""
      class="w-100 h-100 rounded-xl object-cover"
    />
    </a>
  </section>
</template>

<script>
import BookController from "../../controllers/BookController";
export default {
  name: "BannerContainer",
  data() {
    return {
      banner: {},
      defaultBanner:
        "https://firebasestorage.googleapis.com/v0/b/seavphov-919d7.appspot.com/o/folder%2Fbggreen.png?alt=media&token=192e76f7-53b6-42c3-8e20-c7ecb27451b8",
    };
  },
  methods: {
    async getBanner() {
      this.banner = await BookController.getBanner();
    },
  },
  computed: {
    getBackground() {
      if (this.banner && this.banner.image_url) {
        return this.banner.image_url;
      } else {
        return this.defaultBanner;
      }
    },
  },
  async mounted() {
    await this.getBanner();
  },
};
</script>