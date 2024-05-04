<!-- <template>
  <div class="Books w-100 p-5">
    <EasyDataTable
      v-if="books.length > 0"
      :server-options="serverOptions"
      :server-items-length="serverItemsLength"
      :loading="loading"
      :headers="headers"
      :items="books"
      alternating
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
    </EasyDataTable>
    <div
      v-else
      class="h-100 w-100 d-flex align-items-center justify-content-center"
      style="height: 400px !important"
    >
      <Loader />
    </div>
  </div>
</template>

<script>
import Loader from "../Loader.vue";
export default {
  components: { Loader },
  data() {
    return {
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
      ],
      books: [],
      loading: false,
      serverOptions: {
        page: 1,
        rowsPerPage: 15, // Default number of rows per page
      },
      serverItemsLength: 0,
    };
  },
  methods: {
    async adminGetBooks() {
      console.log("adminGetBooks 1", this.books.length);
      this.loading = true;
      const response = await this.$store.dispatch("adminGetBooks");
      this.books = response || [];
      this.serverItemsLength = this.books.length;
      this.loading = false;
    },
  },
  created() {
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
.Books {
  max-width: 100vw;
}
</style> -->

<template>
  <div class="Books w-100 p-5">
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
.Books {
  max-width: 100vw;
}
</style>