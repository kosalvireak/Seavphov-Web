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
        <FwbAvatar :img="members.picture" rounded size="md" />
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
import { FwbAvatar } from "flowbite-vue";
import CopMemberController from "../../controllers/CopMemberController";
export default {
  name: "CopMemberList",
  components: { FwbAvatar },
  data() {
    return {
      isLoading: false,
      route: this.$route.params.route,
      serverItemsLength: 0,
      members: [],
      headers: [
        { text: "PROFILE", value: "picture", sortable: true },
        { text: "NAME", value: "name", sortable: true, width: 300 },
        { text: "ROLE", value: "role", sortable: true },
        { text: "JOIN DATE", value: "join_date", sortable: true },
        { text: "ACTION", value: "action", width: 50 },
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

<style>
</style>