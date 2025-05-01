<template>
  <div class="flex-center">
    <section
      v-if="hasCompleted"
      class="CompleteChallengeWidget card p-4 flex-center bg-sp-primary"
    >
      <p class="h4 m-0 text-white">You have completed this challenge</p>
    </section>
    <div v-if="inProgress" class="card p-3 InProgressChallengeWidget">
      <p class="h4">📚 Keep the Momentum Going!</p>
      <ul class="ml-4">
        <li>📈 Stay motivated by updating your progress regularly.</li>
        <li>
          💬 Share your thoughts as you go - inspire others with your journey.
        </li>
        <li>
          🌟 Every page read is a step closer to your goal. Let's do this
          together!
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: "ContinueOrCompletedProgress",
  props: {
    myProgress: {
      type: Object,
      required: false,
      default: null,
    },
  },
  computed: {
    hasCompleted() {
      return this.myProgress && this.myProgress.progress == 100;
    },
    inProgress() {
      return this.myProgress && this.myProgress.progress < 100;
    },
  },
};
</script>

<style>
</style>