<template>
  <div class="MyBookDropdown">
    <Dropdown id="my-book-dropdown" id_content="my-book-dropdown_content">
      <template #button>
        <div class="w-8 h-8 flex-center hover:bg-gray-200 rounded-lg">
          <i class="fas fa-ellipsis-v fa-xl"></i>
        </div>
      </template>
      <template #content>
        <ul class="py-2 mt-0">
          <li>
            <p :class="dropdownItemCss" @click="editBook(id)">Edit</p>
          </li>
          <li>
            <p :class="dropdownItemCss" @click="deleteBook(id)">Delete</p>
          </li>
        </ul>
      </template>
    </Dropdown>
  </div>
</template>

<script>
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
  },
  methods: {
    editBook(id) {
      this.$router.push(`/book/edit/${id}`);
    },
    async deleteBook(id) {
      await this.$store.dispatch("deleteBook", id);
      this.$emit("callGetBook");
    },
  },
};
</script>

<style></style>
