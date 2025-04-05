<template>
  <section class="ReadingChallengeList">
    {{ readingChallenges }}
  </section>
</template>

<script>
import ReadingChallengeController from "../../../controllers/ReadingChallengeController";
export default {
  name: "ReadingChallengeList",
  props: {
    route: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      readingChallenges: {},
    };
  },
  async mounted() {
    this.readingChallenges =
      await ReadingChallengeController.getReadingChallenges(this.route);
  },
};
</script>

<style>
</style>