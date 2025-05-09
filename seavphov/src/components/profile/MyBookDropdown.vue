<template>
  <FwbDropdown align-to-end close-inside>
    <template #trigger>
      <div class="w-8 h-8 flex-center hover:bg-gray-200 rounded-lg">
        <i class="fas fa-ellipsis-v fa-xl"></i>
      </div>
    </template>
    <nav :class="fwbDropdownNavCss">
      <p :class="fwbDropdownItemCss" @click="changeAvailability(id)">
        Mark as {{ buttonText }}
      </p>
      <p :class="fwbDropdownItemCss" @click="editBook(id)">Edit</p>
      <p :class="fwbDropdownItemCss" @click="deleteBook(id)">Delete</p>
    </nav>
  </FwbDropdown>
</template>

<script>
import BookController from "../../controllers/BookController";
export default {
  name: "MyBookDropdown",
  props: {
    id: Number,
    book: Object,
  },
  methods: {
    editBook(id) {
      this.$router.push(`/book/edit/${id}`);
    },
    async changeAvailability(id) {
      const response = await BookController.changeBookAvailability(id);
      if (response) {
        this.$emit("changeAvailability");
      }
    },
    async deleteBook(id) {
      await this.$store.dispatch("deleteBook", id);
      this.$emit("deleteBook");
    },
  },
  computed: {
    buttonText() {
      return !this.book.availability ? "AVAILABLE" : "NOT AVAILABLE";
    },
  },
};
</script>

<style></style>
