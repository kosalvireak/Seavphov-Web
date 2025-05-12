<template>
  <section class="CopMemberList w-100">
    <MemberRequestPopup
      v-if="selectedMember"
      :user="selectedMember"
      @on-close="selectedMember = null"
      @re-fetch="getCopMemberRequest()"
    />
    <EasyDataTable
      table-class-name="customize-table"
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

      <template #item-request_date="members">
        {{ formatDate(members.request_date) }}
      </template>

      <template #item-action="members">
        <LoadingButton
          @click="onAction(members)"
          color="primary"
          text="Action"
          type="button"
          class="text-center"
        />
      </template>
    </EasyDataTable>
  </section>
</template>

<script>
import MemberRequestPopup from "./MemberRequestPopup.vue";
import CopMemberController from "../../../controllers/CopMemberController";
import EditMemberPopup from "./EditMemberPopup.vue";
export default {
  name: "CopMemberRequestList",
  components: { EditMemberPopup, MemberRequestPopup },
  data() {
    return {
      isLoading: false,
      route: this.$route.params.route,
      serverItemsLength: 0,
      members: [],
      headers: [
        { text: "Profile", value: "picture", sortable: true, width: 50 },
        { text: "Name", value: "name", sortable: true, width: 300 },
        { text: "Request date", value: "request_date", sortable: true },
        { text: "", value: "action", width: 50 },
      ],
      selectedMember: null,
    };
  },
  async mounted() {
    await this.getCopMemberRequest();
  },
  methods: {
    onAction(member) {
      this.selectedMember = member;
    },
    async getCopMemberRequest() {
      this.isLoading = true;
      this.members = await CopMemberController.getCommunityMemberRequest(
        this.route,
      );
      this.serverItemsLength = this.members.length;
      this.isLoading = false;
    },
  },
};
</script>

<style>
.customize-table {
  --easy-table-body-row-height: 50px;
}
</style>
