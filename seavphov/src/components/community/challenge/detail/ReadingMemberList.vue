<template>
  <section class="ReadingMemberList flex-col space-y-4 p-2 rounded-lg">
    <StartChallengeWidget />

    <MemberProgressItem
      v-for="(member, index) in members"
      :key="index"
      :member="member"
    />
  </section>
</template>

<script>
import StartChallengeWidget from "./StartChallengeWidget.vue";
import MemberProgressItem from "./MemberProgressItem.vue";
import ReadingChallengeController from "../../../../controllers/ReadingChallengeController";
export default {
  name: "ReadingMemberList",
  components: { MemberProgressItem, StartChallengeWidget },
  data() {
    return {
      id: this.$route.params.id,
      members: {},
      isLoading: false,
    };
  },
  async mounted() {
    this.members = await ReadingChallengeController.getReadingChallengeMembers(
      this.id
    );
  },
};
</script>

<style>
</style>