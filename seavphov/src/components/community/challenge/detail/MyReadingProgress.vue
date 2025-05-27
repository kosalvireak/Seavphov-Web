<template>
  <section
    class="MyReadingProgress card p-4 ring-1 ring-gray-300 position-relative"
  >
    <p class="h5">My Reading Progress</p>
    <div class="ProgressInfo space-y-2">
      <p><b>Started on:</b>{{ formatDate(myProgress.created_at) }}</p>
      <p><b>Late updated on:</b>{{ formatDate(myProgress.updated_at) }}</p>
      <Progress
        class="w-full"
        label="Current progress"
        label-position="outside"
        label-progress
        size="md"
        :color="hasCompleted ? 'green' : 'blue'"
        :progress="myProgress.progress"
      />
    </div>
    <FwbDropdown
      align-to-end
      close-inside
      class="position-absolute top-4 end-4"
    >
      <template #trigger>
        <div class="w-8 h-8 flex-center hover:bg-gray-200 rounded-lg clickable">
          <i class="fas fa-ellipsis-v fa-lg"></i>
        </div>
      </template>
      <nav :class="fwbDropdownNavCss">
        <p :class="fwbDropdownItemCss" @click="showUpdateProgressPopup = true">
          Update progress
        </p>
        <p :class="fwbDropdownItemCss" @click="withDrawChallenge()">
          Withdraw challenge
        </p>
      </nav>
    </FwbDropdown>
    <UpdateProgressPopup
      v-if="showUpdateProgressPopup"
      :progressObj="myProgress"
      @on-close="showUpdateProgressPopup = false"
      @update-progress="updateProgress"
    />
  </section>
</template>

<script>
import ReadingChallengeController from "../../../../controllers/ReadingChallengeController";
import UpdateProgressPopup from "./UpdateProgressPopup.vue";
export default {
  name: "MyReadingProgress",
  components: { UpdateProgressPopup },
  data() {
    return {
      showUpdateProgressPopup: false,
    };
  },
  props: {
    myProgress: {
      type: Object,
      required: true,
    },
    challengeCompleted: {
      type: Boolean,
      required: false,
      default: false,
    },
  },
  computed: {
    hasCompleted() {
      return this.myProgress && this.myProgress.progress == 100;
    },
  },
  methods: {
    updateProgress(newProgress) {
      this.myProgress.progress = newProgress;
    },
    async withDrawChallenge() {
      const success = await ReadingChallengeController.withDrawChallenge(
        this.myProgress.id,
      );
      if (success) {
        this.reloadPage();
      }
    },
  },
};
</script>

<style></style>
