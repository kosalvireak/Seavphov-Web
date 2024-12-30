<template>
  <div class="BookItem clickable" @click="toRouteName('book-detail', book.id)">
    <div
      class="w-48 h-full bg-white rounded-lg border border-gray-200 shadow-md"
    >
      <div class="overflow-hidden">
        <img
          :alt="book.title"
          class="sp-img-xs mx-auto hover:scale-110 transition-transform duration-300 ease-in-out"
          :src="book.images"
        />
      </div>
      <div class="flex flex-col p-2 h-38 justify-between !space-y-2">
        <h6 class="text-sm mb-0 font-semibold ellipsis-2">
          {{ book.title }}
        </h6>
        <p class="text-xs">6 Reviews</p>
        <FwbButton :gradient="buttonColor" class="px-2 text-xs w-fit">{{
          buttonText
        }}</FwbButton>
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
  },
};
</script>