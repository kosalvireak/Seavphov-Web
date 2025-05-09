<template>
  <div class="UsersList w-100">
    <EasyDataTable
      table-class-name="customize-table"
      :server-items-length="serverItemsLength"
      :headers="headers"
      :items="users"
      alternating
      :loading="isLoading"
      border-cell
      buttons-pagination
    >
      <template #item-picture="users">

        <a :href="`/profile/${users.uuid}`" target="_blank">
          <FwbAvatar :img="users.picture" rounded size="md" />
        </a>
      </template>

      <template #item-created_at="users">
        {{ formatDate(users.created_at) }}
      </template>
    </EasyDataTable>
  </div>
</template>

<script>
import { FwbAvatar } from "flowbite-vue";
import AdminController from "../../controllers/admin/AdminController.js";
export default {
  name: "UsersList",
  components: { FwbAvatar },
  data() {
    return {
      isLoading: false,
      serverItemsLength: 0,
      headers: [
        { text: "PROFILE", value: "picture", sortable: true },
        { text: "NAME", value: "name", sortable: true },
        { text: "EMAIL", value: "email", sortable: true },
        { text: "PHONE", value: "phone", sortable: true },
        { text: "FACEBOOK", value: "facebook", sortable: true },
        { text: "INSTAGRAM", value: "instagram", sortable: true },
        { text: "TELEGRAM", value: "telegram", sortable: true },
        { text: "TWITTER", value: "twitter", width: 200, sortable: true },
        { text: "JOIN DATE", value: "created_at", width: 100, sortable: true },
      ],
      users: [],
    };
  },
  methods: {
    async adminGetUsers() {
      this.isLoading = true;
      this.users = await AdminController.adminGetUsers();
      this.serverItemsLength = this.users.length;
      this.isLoading = false;
    },
  },
  async mounted() {
    this.adminGetUsers();
  },
};
</script>

<style scoped>
.UsersList {
  max-width: 100vw;
}

.customize-table {
  --easy-table-body-row-height: 100px;
}

:deep(img) {
  object-fit: cover;
}
</style>
