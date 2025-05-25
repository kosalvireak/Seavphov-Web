<template>
  <div class="BooksList w-100">
    <EasyDataTable
      table-class-name="customize-table"
      :server-items-length="serverItemsLength"
      :headers="headers"
      :items="communities"
      alternating
      :loading="isLoading"
      border-cell
      buttons-pagination
    >
      <template #item-profile="communities">
        <a :href="`/community/${communities.route}`" target="_blank">
          <FwbAvatar :img="communities.profile" rounded size="md" />
        </a>
      </template>

      <template #item-banner="communities">
        <img :src="communities.banner" class="img-fluid" />
      </template>

      <template #item-description="communities">
        {{ communities.description }}
      </template>

      <template #item-private="communities">
        {{ communities.private ? "Private" : "Public" }}
      </template>

      <template #item-="communities">
        <LoadingButton
          :isLoading="isDeleting"
          color="danger"
          text="Delete"
          @click="adminDeleteBook(communities.id)"
        />
      </template>

      <template #item-created_at="communities">
        {{ formatDate(communities.created_at) }}
      </template>
    </EasyDataTable>
  </div>
</template>

<script>
import AdminController from "../../controllers/admin/AdminController.js";

export default {
  name: "Books",
  data() {
    return {
      isDeleting: false,
      isLoading: false,
      serverItemsLength: 0,
      headers: [
        { text: "ID", value: "id", sortable: true },
        { text: "IMAGE", value: "profile", sortable: true },
        { text: "NAME", value: "name", sortable: true },
        { text: "ROUTE", value: "route", sortable: true },
        { text: "BANNER", value: "banner", sortable: true, width: 200 },
        { text: "PRIVATE", value: "private", sortable: true },
        { text: "DESCRIPTIONS", value: "description", width: 500 },
        { text: "CREATED_AT", value: "created_at", sortable: true },
        { text: "ACTION", value: "" },
      ],
      communities: [],
    };
  },
  methods: {
    async adminGetCommunities() {
      this.isLoading = true;
      this.communities = await AdminController.adminGetCommunities();
      this.serverItemsLength = this.communities.length;
      this.isLoading = false;
    },

    async adminDeleteBook(id) {
      this.isDeleting = true;
      await this.$store.dispatch("adminDeleteBook", id);
      this.isDeleting = false;
      this.adminGetCommunities();
    },
  },
  async mounted() {
    this.adminGetCommunities();
  },
};
</script>

<style scoped>
.BooksList {
  max-width: 100vw;
}

.customize-table {
  --easy-table-body-row-height: 100px;
}
</style>
