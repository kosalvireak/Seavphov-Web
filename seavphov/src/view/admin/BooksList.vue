<template>
  <div class="BooksList w-100">
    <EasyDataTable
      :server-items-length="serverItemsLength"
      :headers="headers"
      :items="books"
      alternating
      :loading="isLoading"
      border-cell
      buttons-pagination
    >
      <template #item-images="books">
        <img :src="books.images" alt="admin_book" loading="lazy" />
      </template>
      <template #item-descriptions="books">
        {{ books.descriptions }}
      </template>
      <template #item-="books">
        <LoadingButton
          :isLoading="isDeleting"
          color="danger"
          text="Delete"
          @click="adminDeleteBook(books.id)"
        />
      </template>
    </EasyDataTable>
  </div>
</template>

<script>
export default {
  name: "Books",
  data() {
    return {
      isDeleting: false,
      isLoading: false,
      serverItemsLength: 0,
      headers: [
        { text: "ID", value: "id", sortable: true },
        { text: "IMAGE", value: "images", sortable: true },
        { text: "TITLE", value: "title", sortable: true },
        { text: "AUTHOR", value: "author", sortable: true },
        { text: "CONDITION", value: "condition", sortable: true },
        { text: "CATEGORIES", value: "categories", sortable: true },
        { text: "AVAILABILITY", value: "availability", sortable: true },
        { text: "DESCRIPTIONS", value: "descriptions", width: 500 },
        { text: "CREATED_AT", value: "created_at", sortable: true },
        { text: "ACTION", value: "" },
      ],
      books: [],
    };
  },
  methods: {
    async adminGetBooks() {
      this.isLoading = true;
      this.books = await this.$store.dispatch("adminGetBooks");
      this.serverItemsLength = this.books.length;
      this.isLoading = false;
    },

    async adminDeleteBook(id) {
      this.isDeleting = true;
      await this.$store.dispatch("adminDeleteBook", id);
      this.isDeleting = false;
      this.adminGetBooks();
    },
  },
  async mounted() {
    this.adminGetBooks();
  },
};
</script>

<style scoped>
.admin_book {
  width: 62px;
  object-fit: cover;
}
.BooksList {
  max-width: 100vw;
}
</style>
