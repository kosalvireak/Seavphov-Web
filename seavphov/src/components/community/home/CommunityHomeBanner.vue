<template>
  <section class="CommunityHomeBanner card h-64 p-2">
    <img
      :src="bannerUrl"
      class="w-full h-full object-center rounded-lg"
      alt="community-banner"
    />
  </section>
</template>

<script>
export default {
  name: "CommunityHomeBanner",
  props: {
    bannerUrl: String,
  },
};
</script>

<style>
</style>