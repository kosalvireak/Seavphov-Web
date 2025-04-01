<template>
  <div class="MyBookDropdown">
    <Dropdown
      id="my-book-dropdown"
      id_content="my-book-dropdown_content"
      placement="bottom-end"
    >
      <template #button>
        <div class="w-8 h-8 flex-center hover:bg-gray-200 rounded-lg">
          <i class="fas fa-ellipsis-v fa-xl"></i>
        </div>
      </template>
      <template #content>
        <ul class="py-2 mt-0">
          <li>
            <p :class="dropdownItemCss" @click="changeAvailability(id)">
              Mark as {{ buttonText }}
            </p>
          </li>
          <li>
            <p :class="dropdownItemCss" @click="editBook(id)">Edit</p>
          </li>
          <li>
            <p :class="dropdownItemCss" @click="deleteBook(id)">
              <span>Delete</span>
            </p>
          </li>
        </ul>
      </template>
    </Dropdown>
  </div>
</template>

<script>
import BookController from "../../controllers/BookController";
export default {
  name: "MyBookDropdown",
  data() {
    return {
      dropdownItemCss:
        "block px-4 py-2 mb-0 w-100 text-sm text-center text-gray-700 hover:bg-gray-200 clickable",
    };
  },
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
        this.$emit("change");
      }
    },
    async deleteBook(id) {
      await this.$store.dispatch("deleteBook", id);
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
