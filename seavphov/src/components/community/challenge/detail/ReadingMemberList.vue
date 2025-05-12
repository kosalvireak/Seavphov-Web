<template>
  <section class="ReadingMemberList flex-col space-y-4 rounded-lg">
    <div v-if="isLoading" class="h-40 w-100 flex-center">
      <Loader :size="40" />
    </div>
    <template v-else>
      <CompletedChallenge v-if="challengeCompleted" />
      <StartChallengeWidget v-else-if="myProgress == null" />
      <ContinueOrCompletedProgress v-else :myProgress="myProgress" />

      <div
        v-if="members.length > 0"
        class="bg-gray-100 rounded-lg p-4 space-y-4"
      >
        <p class="h3 text-center">LEADER BOARD</p>
        <MemberProgressItem
          v-for="(member, index) in members"
          :key="index"
          :member="member"
          :index="index"
        />
      </div>
    </template>
  </section>
</template>

<script>
import StartChallengeWidget from "./StartChallengeWidget.vue";
import MemberProgressItem from "./MemberProgressItem.vue";
import ReadingChallengeController from "../../../../controllers/ReadingChallengeController";
import ContinueOrCompletedProgress from "./ContinueOrCompletedProgress.vue";
import CompletedChallenge from "./CompletedChallenge.vue";
export default {
  name: "ReadingMemberList",
  components: {
    MemberProgressItem,
    StartChallengeWidget,
    ContinueOrCompletedProgress,
    CompletedChallenge,
  },
  props: {
    myProgress: {
      type: Object,
      required: false,
      default: null,
    },
    challengeCompleted: {
      type: Boolean,
      required: false,
      default: false,
    },
  },
  data() {
    return {
      id: this.$route.params.id,
      members: [],
      isLoading: false,
    };
  },
  async mounted() {
    this.isLoading = true;
    this.members = await ReadingChallengeController.getReadingChallengeMembers(
      this.id,
    );
    this.isLoading = false;
  },
};
</script>

<style></style>
