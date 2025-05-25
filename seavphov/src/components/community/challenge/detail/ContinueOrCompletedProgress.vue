<template>
  <div class="flex-center">
    <section
      v-if="hasCompleted"
      class="CompleteChallengeWidget card p-4 flex-center flex-col md:flex-row bg-sp-primary w-full gradient-background"
    >
      <div class="w-24 h-24">
        <img src="/img/award-image.png" alt="award-image" />
      </div>

      <p class="h3 m-0 text-white text-center">
        You have completed this challenge
      </p>

      <div class="w-24 h-24">
        <img src="/img/award-image.png" alt="award-image" />
      </div>
    </section>
    <div
      v-if="inProgress"
      class="card p-3 InProgressChallengeWidget gradient-border"
    >
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
