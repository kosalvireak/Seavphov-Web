
<template>
  <div class="UsersList w-100">
    <EasyDataTable
      :server-items-length="serverItemsLength"
      :headers="headers"
      :items="users"
      alternating
      :loading="isLoading"
      border-cell
      buttons-pagination
    >
      <template #item-picture="users">
        <FwbAvatar :img="users.picture" rounded size="md" />
      </template>
    </EasyDataTable>
  </div>
</template>
  
  <script>
import { FwbAvatar } from "flowbite-vue";
export default {
  name: "UsersList",
  components: { FwbAvatar },
  data() {
    return {
      isLoading: false,
      serverItemsLength: 0,
      headers: [
        { text: "UUID", value: "uuid", sortable: true },
        { text: "PROFILE", value: "picture", sortable: true },
        { text: "NAME", value: "name", sortable: true },
        { text: "EMAIL", value: "email", sortable: true },
        { text: "PHONE", value: "phone", sortable: true },
        { text: "FACEBOOK", value: "facebook", sortable: true },
        { text: "INSTAGRAM", value: "instagram", sortable: true },
        { text: "TELEGRAM", value: "telegram", sortable: true },
        { text: "TWITTER", value: "twitter", width: 200 },
        { text: "JOIN DATE", value: "created_at", sortable: true },
      ],
      users: [],
    };
  },
  methods: {
    async adminGetUsers() {
      this.isLoading = true;
      this.users = await this.$store.dispatch("adminGetUsers");
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
:deep(img) {
  object-fit: cover;
}
</style>