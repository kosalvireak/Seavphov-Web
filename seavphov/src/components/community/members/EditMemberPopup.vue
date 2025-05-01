<template>
  <FwbModal
    v-if="isShowModal"
    size="md"
    @close="closeModal"
    class="EditMemberPopup"
  >
    <template #header>
      <span class="text-lg"> Edit Member </span>
    </template>

    <template #body>
      <div class="flex-center flex-col space-y-2">
        <a :href="`/profile/${user.uuid}`" target="_blank" class="clickable">
          <FwbAvatar :img="user.picture" rounded size="lg" />
        </a>
        <p class="text-lg font-bold">{{ user.name }}</p>
        <FwbSelect v-model="selectedRole" :options="role" />
      </div>
    </template>

    <template #footer>
      <div class="flex justify-between">
        <LoadingButton
          @click="removeMemberFromCop()"
          :isLoading="isRemoving"
          text="Remove"
          color="danger"
        />
        <LoadingButton
          @click="changeUserRole()"
          :isLoading="isSaving"
          :disabled="disableSave"
          text="Save"
        />
      </div>
    </template>
  </FwbModal>
</template>

<script>
import { FwbSelect } from "flowbite-vue";
import CopMemberController from "../../../controllers/CopMemberController";
export default {
  name: "EditMemberPopup",
  components: { FwbSelect },
  props: {
    user: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      isShowModal: true,
      isRemoving: false,
      isSaving: false,
      route: this.$route.params.route,
      role: [
        { value: "Member", name: "Member" },
        { value: "Admin", name: "Admin" },
      ],
      selectedRole: "",
    };
  },
  computed: {
    disableSave() {
      return this.selectedRole == this.user.role;
    },
  },
  methods: {
    showModal() {
      this.isShowModal = true;
    },
    closeModal() {
      this.isShowModal = false;
      this.$emit("onClose");
    },
    async changeUserRole() {
      this.isSaving = true;
      const response = await CopMemberController.changeUserRole(
        this.route,
        this.user.uuid,
        this.selectedRole,
      );
      if (response) this.closeModal();
      this.isSaving = false;
    },
    async removeMemberFromCop() {
      this.isRemoving = true;
      const response = await CopMemberController.removeMemberFromCop(
        this.route,
        this.user.uuid,
      );
      if (response) this.closeModal();
      this.isRemoving = false;
    },
  },
};
</script>

<style></style>
