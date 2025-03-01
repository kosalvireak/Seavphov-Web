<template>
  <section class="CarouselItem block m-4">
    <div class="grid grid-cols-12">
      <div class="col-start-3 col-end-9 text-start text-sp-tertiary space-y-4">
        <h1 class="ellipsis-2">{{ book.title }}</h1>
        <h5 class="">By: {{ book.author }}</h5>
        <h5>Condition: {{ book.condition }}</h5>
        <div class="ellipsis-4">{{ book.descriptions }}</div>

        <FwbButton @click="toRouteName('book-detail', book.id)" color="yellow"
          >READ MORE</FwbButton
        >
      </div>
      <div class="col-start-10 col-end-12">
        <img :src="book.images" alt="Book Cover" class="sp-img-md ml-auto" />
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "CarouselItem",
  props: { book: Object },
};
</script>

<style scoped></style>
