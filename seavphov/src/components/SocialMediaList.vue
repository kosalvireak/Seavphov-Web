<template>
  <div class="d-flex justify-content-center space-x-2">
    <a
      v-if="facebook && facebook != 'null'"
      :href="facebook"
      target="_blank"
      class="text-black"
    >
      <img src="/img/facebook.webp" class="icon rounded-5" />
    </a>
    <a
      v-if="instagram && instagram != 'null'"
      :href="instagram"
      target="_blank"
      class="text-black"
    >
      <img src="/img/instagram.webp" class="icon rounded-5" />
    </a>
    <a
      v-if="telegram && telegram != 'null'"
      :href="telegram"
      target="_blank"
      class="text-black"
    >
      <img src="/img/telegram.webp" class="icon rounded-5" />
    </a>
    <a
      v-if="twitter && twitter != 'null'"
      :href="twitter"
      target="_blank"
      class="text-black"
    >
      <img src="/img/twitter.webp" class="icon rounded-5" />
    </a>
  </div>
</template>

<script>
export default {
  name: "SocialMediaList",
  props: {
    facebook: { type: String, required: false },
    telegram: { type: String, required: false },
    instagram: { type: String, required: false },
    twitter: { type: String, required: false },
  },
};
</script>

<style>
.icon {
  width: 50px;
  height: 50px;
}
@media only screen and (max-width: 576px) {
  .icon {
    width: 35px;
    height: 35px;
  }
}
</style>
