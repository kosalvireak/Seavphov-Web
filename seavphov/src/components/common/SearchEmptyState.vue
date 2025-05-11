<template>
  <section class="SearchEmptyState h-100 w-100">
    <div
      class="h-auto d-flex flex-column justify-content-center align-items-center m-5"
    >
      <img
        src="/img/notfound.png"
        alt="not found"
        class="w-25 img-fluid mb-3 rounded rounded-7"
      />
      <p v-if="text" class="h3">No {{ text }} found...!</p>
      <p v-else-if="longText" class="h3">{{ longText }}</p>
      <p v-else class="h3">No data found...!</p>
    </div>
  </section>
</template>

<script>
export default {
  name: "SearchEmptyState",
  props: {
    text: String,
    longText: String,
  },
};
</script>

<style></style>
