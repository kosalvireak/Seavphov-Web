<template>
  <section class="ReadingMemberList flex-col space-y-4 rounded-lg">
    <div v-if="isLoading" class="h-40 w-100 flex-center">
      <Loader :size="40" />
    </div>
    <template v-else>
      <CompleteChallengeWidgetVue v-if="hasCompleted" />
      <StartChallengeWidget v-else-if="myProgress == null" />

      <div
        v-if="members.length > 0"
        class="bg-gray-100 rounded-lg p-4 space-y-4"
      >
        <p class="h3 text-center">Leader Board</p>
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
import CompleteChallengeWidgetVue from "./CompleteChallengeWidget.vue";
export default {
  name: "ReadingMemberList",
  components: {
    MemberProgressItem,
    StartChallengeWidget,
    CompleteChallengeWidgetVue,
  },
  props: {
    myProgress: {
      type: Object,
      required: false,
      default: null,
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
      this.id
    );
    this.isLoading = false;
  },
  computed: {
    hasCompleted() {
      return this.myProgress && this.myProgress.progress == 100;
    },
  },
};
</script>

<style>
</style>