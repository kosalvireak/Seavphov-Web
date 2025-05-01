<template>
  <FwbModal
    v-if="isShowModal"
    size="md"
    @close="closeModal"
    class="MemberRequestPopup"
  >
    <template #header>
      <span class="text-lg"> Member Request</span>
    </template>

    <template #body>
      <div class="flex-center flex-col space-y-2">
        <a :href="`/profile/${user.uuid}`" target="_blank" class="clickable">
          <FwbAvatar :img="user.picture" rounded size="lg" />
        </a>
        <p class="text-lg font-bold">{{ user.name }}</p>
        <p class="">Requested on: {{ formatDate(user.request_date) }}</p>
      </div>
    </template>

    <template #footer>
      <div class="flex justify-between">
        <LoadingButton
          @click="rejectMemberRequest()"
          :isLoading="isRejecting"
          text="Reject"
          color="danger"
        />
        <LoadingButton
          @click="approveMemberRequest()"
          :isLoading="isApproving"
          text="Approve"
        />
      </div>
    </template>
  </FwbModal>
</template>

<script>
import CopMemberController from "../../../controllers/CopMemberController";
export default {
  name: "MemberRequestPopup",
  props: {
    user: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      isShowModal: true,
      isRejecting: false,
      isApproving: false,
      route: this.$route.params.route,
    };
  },
  methods: {
    showModal() {
      this.isShowModal = true;
    },
    closeModal() {
      this.isShowModal = false;
      this.$emit("onClose");
    },
    async approveMemberRequest() {
      this.isApproving = true;
      const response = await CopMemberController.approveMemberRequest(
        this.route,
        this.user.uuid,
      );

      if (response) this.closeModal();

      this.isApproving = false;
    },
    async rejectMemberRequest() {
      this.isRejecting = true;

      const response = await CopMemberController.rejectMemberRequest(
        this.route,
        this.user.uuid,
      );

      if (response) this.closeModal();

      this.isRejecting = false;
    },
  },
};
</script>

<style></style>
