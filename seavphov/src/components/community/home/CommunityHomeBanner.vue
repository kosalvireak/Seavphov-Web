<template>
  <section class="CommunityHomeBanner card h-64 p-2 relative group">
    <img
      :src="bannerUrl"
      class="w-full h-full object-center rounded-lg"
      alt="community-banner"
    />

    <!-- Edit community Pencil Icon -->
    <div
      v-if="isCopAdmin"
      class="hidden group-hover:block clickable absolute right-4 top-4"
      @click="toRouteName('community-admin')"
    >
      <i class="fa fa-pencil fa-xl text-gray-300" aria-hidden="true"></i>
    </div>

    <!-- Edit community Pencil Icon -->
  </section>
</template>

<script>
export default {
  name: "CommunityHomeBanner",
  props: {
    bannerUrl: String,
    isCopAdmin: Boolean,
  },
};
</script>

<style></style>
