<template>
  <section class="ReadingChallengeList space-y-8">
    <div v-if="isLoading" class="w-100 h-96 flex-center flex-column">
      <Loader :size="30" />
      <p>Fetching reading challenges</p>
    </div>
    <template v-else>
      <ReadingChallengeItem
        v-for="challenge in challenges"
        :key="challenge.id"
        :challenge="challenge"
      />
    </template>
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
      isLoading: false,
      challenges: {},
    };
  },
  async mounted() {
    this.isLoading = true;
    this.challenges = await ReadingChallengeController.getReadingChallenges(
      this.route
    );
    this.isLoading = false;
  },
};
</script>

<style>
</style>