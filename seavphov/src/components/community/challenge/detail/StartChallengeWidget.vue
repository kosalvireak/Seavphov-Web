<template>
  <div class="StartChallengeWidget flex-center">
    <div class="card p-3 gradient-border">
      <p class="h4">🔥 Why Start a Challenge?</p>
      <ul class="ml-4">
        <li>✅ Build a reading habit with accountability.</li>
        <li>✅ Engage in discussions and share insights.</li>
        <li>✅ Watch everyone's progress with real-time tracking!</li>
      </ul>
      <div class="flex justify-content-end">
        <LoadingButton
          text="Start Now"
          class="mt-3 w-fit"
          :isLoading="isLoading"
          @click="joinChallenge()"
        />
      </div>
    </div>
  </div>
</template>

<script>
import ReadingChallengeController from "../../../../controllers/ReadingChallengeController";
export default {
  name: "StartChallengeWidget",
  data() {
    return {
      isLoading: false,
      route: this.$route.params.route,
      id: this.$route.params.id,
    };
  },
  methods: {
    async joinChallenge() {
      this.isLoading = true;
      const success = await ReadingChallengeController.startReadingChallenge(
        this.route,
        this.id,
      );
      if (success) {
        this.reloadPage();
      }
      this.isLoading = false;
    },
  },
};
</script>

<style></style>
