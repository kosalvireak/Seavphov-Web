<template>
  <section class="ReadingChallengeList space-y-8">
    <ReadingChallengeItem
      v-for="item in readingChallenges"
      :key="item.id"
      :item="item"
    />
  </section>
</template>

<script>
import ReadingChallengeController from "../../../../controllers/ReadingChallengeController";
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