<template>
  <section class="ReadingChallengeDetail">
    <div v-if="isLoading" class="h-96 w-100 flex-center">
      <Loader :size="40" />
    </div>
    <template v-else> </template>
  </section>
</template>

<script>
import ReadingChallengeController from "../../controllers/ReadingChallengeController";
export default {
  name: "ReadingChallengeDetail",
  data() {
    return {
      route: this.$route.params.route,
      id: this.$route.params.id,
      challenge: {},
      isLoading: false,
    };
  },
  computed: {},
  async mounted() {
    this.isLoading = true;
    const challenge = await ReadingChallengeController.getReadingChallenge(
      this.route,
      this.id
    );
    this.isLoading = false;
  },
};
</script>

<style>
</style>