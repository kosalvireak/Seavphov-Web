<template>
  <div class="BookItem clickable relative">
    <div class="w-40 h-full bg-white border border-gray-200 shadow-md">
      <div class="overflow-hidden">
        <router-link :to="`/book/${book.id}`">
          <img
            :alt="book.title"
            class="sp-img-xs mx-auto hover:scale-110 transition-transform duration-300 ease-in-out"
            :src="book.images"
          />
        </router-link>
      </div>
      <div class="flex flex-col p-2 min-h-24 !space-y-2">
        <h6 class="text-sm mb-0 font-semibold ellipsis-2">
          {{ book.title }}
        </h6>

        <p class="absolute right-2 bottom-2 text-xs" v-if="book.reviews_count">
          {{ book.reviews_count }} {{ reviewCountText }}
        </p>

        <Badge
          v-else-if="book.has_pdf"
          type="red"
          size="sm"
          class="absolute right-2 bottom-2 w-fit text-xs m-0"
          >PDF</Badge
        >

        <Badge
          :type="buttonColor"
          size="sm"
          class="absolute left-2 bottom-2 px-2 text-xs w-fit m-0 mt-1"
          >{{ buttonText }}</Badge
        >
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Book",
  props: { book: Object },
  computed: {
    buttonColor() {
      return this.book.availability ? "green" : "red";
    },
    buttonText() {
      return this.book.availability ? "AVAILABLE" : "NOT AVAILABLE";
    },
    reviewCountText() {
      return this.book.reviews_count == 1 ? "Review" : "Reviews";
    },
  },
};
</script>
