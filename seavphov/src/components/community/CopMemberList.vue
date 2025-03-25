<template>
  <section class="CopMemberList w-100">
    <EasyDataTable
      :server-items-length="serverItemsLength"
      :headers="headers"
      :items="members"
      alternating
      :loading="isLoading"
      border-cell
      buttons-pagination
    >
      <template #item-picture="members">
        <a :href="`/profile/${members.uuid}`" target="_blank" class="clickable">
          <FwbAvatar :img="members.picture" rounded size="md" />
        </a>
      </template>

      <template #item-join_date="members">
        {{ formatDate(members.join_date) }}
      </template>

      <template #item-action="members">
        <LoadingButton
          @click="onClickEditMember(members)"
          color="primary"
          text="Edit"
          type="button"
          class="text-center"
        />
      </template>
    </EasyDataTable>
  </section>
</template>

<script>
import CopMemberController from "../../controllers/CopMemberController";
export default {
  name: "CopMemberList",
  data() {
    return {
      isLoading: false,
      route: this.$route.params.route,
      serverItemsLength: 0,
      members: [],
      headers: [
        { text: "Profile", value: "picture", sortable: true, width: 50 },
        { text: "Name", value: "name", sortable: true, width: 300 },
        { text: "Role", value: "role", sortable: true },
        { text: "Join date", value: "join_date", sortable: true },
        { text: "", value: "action", width: 50 },
      ],
    };
  },
  async mounted() {
    this.getCopMemberList();
  },
  methods: {
    onClickEditMember(member) {
      console.log(member);
    },
    async getCopMemberList() {
      this.isLoading = true;
      this.members = await CopMemberController.getCommunityMembers(this.route);
      this.serverItemsLength = this.members.length;
      this.isLoading = false;
    },
  },
};
</script>

<style></style>
