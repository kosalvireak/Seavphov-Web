<template>
  <section class="ReadingChallengeList space-y-8">
    <ReadingChallengeItem
      v-for="challenge in challenges"
      :key="challenge.id"
      :challenge="challenge"
    />
  </section>
</template>

<script>
import ReadingChallengeController from "../../../controllers/ReadingChallengeController";
import ReadingChallengeItem from "../challenge/ReadingChallengeItem.vue";
export default {
  name: "ReadingChallengeList",
  components: { ReadingChallengeItem },
  props: {
    route: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      challenges: {},
    };
  },
  async mounted() {
    this.challenges = await ReadingChallengeController.getReadingChallenges(
      this.route
    );
  },
};
</script>

<style>
</style>