<template>
  <FwbModal
    v-if="isShowModal"
    size="md"
    @close="closeModal"
    class="UpdateProgressPopup"
  >
    <template #header>
      <span class="text-lg">Update Progress</span>
    </template>

    <template #body>
      <div class="flex-center flex-col space-y-2 w-full">
        <FwbRange
          v-model="value"
          :min="0"
          :max="100"
          label="Min 0 : Max 100"
          class="w-full"
        />
        <p><b>Progress:</b> {{ value }} %</p>
      </div>
    </template>

    <template #footer>
      <div class="flex justify-end">
        <LoadingButton
          @click="updateChallengeProgress()"
          :isLoading="isLoading"
          text="Save"
        />
      </div>
    </template>
  </FwbModal>
</template>

<script>
import { FwbRange } from "flowbite-vue";
import ReadingChallengeController from "../../../../controllers/ReadingChallengeController";
export default {
  name: "UpdateProgressPopup",
  components: { FwbRange },
  props: {
    progress: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      value: this.progress.progress || 0,
      isShowModal: true,
      isLoading: false,
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
    async updateChallengeProgress() {
      this.isLoading = true;
      const formDate = new FormData();
      formDate.append("progress", this.value);
      const response = await ReadingChallengeController.updateChallengeProgress(
        this.progress.id,
        formDate
      );
      this.isLoading = false;
      this.closeModal();
    },
  },
};
</script>

<style></style>
