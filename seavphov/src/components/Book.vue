<template>
  <div
    class="BookItem cursor-pointer"
    @click="toRouteName('book-detail', book.id)"
  >
    <div class="w-48 h-80 bg-white rounded-lg border border-gray-200 shadow-md">
      <div class="overflow-hidden">
        <img
          :alt="book.title"
          class="sp-img-sm mx-auto hover:scale-110 transition-transform duration-300 ease-in-out"
          :src="book.images"
        />
      </div>
      <div>
        <div class="flex flex-col p-2 h-28 justify-between">
          <h6 class="text-sm font-semibold ellipsis-2">
            {{ book.title }}
          </h6>
          <FwbButton :gradient="buttonColor" class="px-2 text-xs w-fit">{{
            buttonText
          }}</FwbButton>
        </div>
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