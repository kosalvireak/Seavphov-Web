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
        <li>
          Enter the percentage of the book you've completed (e.g., 25 means
          you're 25% through the book).
        </li>
        <li>
          Calculate the percentage by dividing the number of pages you've read
          by the total number of pages in the book.
        </li>
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
    progressObj: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      value: this.progressObj.progress || 0,
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
      const newProgress =
        await ReadingChallengeController.updateChallengeProgress(
          this.progressObj.id,
          formDate
        );

      this.$emit("updateProgress", newProgress);
      this.isLoading = false;
      this.closeModal();
    },
  },
};
</script>

<style></style>
