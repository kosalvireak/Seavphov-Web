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
        <img
          :src="books.images"
          class="img-fluid admin_book m-3 ms-1"
          alt="admin_book"
          loading="lazy"
        />
      </template>
      <template #item-descriptions="books">
        <p class="ellipsis">{{ books.descriptions }}</p>
      </template>
      <template #item-="books">
        <button
          class="ellipsis text-center btn btn-danger h-auto"
          @click="adminDeleteBook(books.id)"
        >
          <i class="fa fa-trash fa-xl clickable" aria-hidden="true"></i>
        </button>
      </template>
    </EasyDataTable>
  </div>
</template>
  
  <script>
export default {
  name: "Books",
  data() {
    return {
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
        { text: "DESCRIPTIONS", value: "descriptions", width: 200 },
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
      await this.$store.dispatch("adminDeleteBook", id);
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
  height: 100px;
  width: 62px;
  object-fit: cover;
}
.BooksList {
  max-width: 100vw;
}
</style>