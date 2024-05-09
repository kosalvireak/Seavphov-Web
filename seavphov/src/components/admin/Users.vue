
<template>
  <div class="Users w-100 p-2 p-lg-5">
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
        <img
          :src="users.picture"
          class="img-fluid rounded-circle navbar_img border border-1 mt-2"
          alt="img"
          loading="lazy"
        />
      </template>
    </EasyDataTable>
  </div>
</template>
  
  <script>
export default {
  name: "Users",
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
        { text: "TOKEN", value: "api_token", sortable: true },
        { text: "JOIN DATA", value: "created_at", sortable: true },
      ],
      users: [],
    };
  },
  methods: {
    async adminGetUsers() {
      this.isLoading = true;
      this.users = await this.$store.dispatch("adminGetUsers");
      console.log("adminGetUsers", this.users);
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
.navbar_img {
  height: 55px;
  width: 55px;
  object-fit: cover;
}
.Users {
  max-width: 100vw;
}
</style>