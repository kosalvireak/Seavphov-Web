<template>
  <div class="flex-center">
    <section
      v-if="hasCompleted"
      class="CompleteChallengeWidget card p-4 flex-center flex-row bg-sp-primary w-full animated-gradient-border"
    >
      <div class="w-24 h-24">
        <img src="/public/img/award-image.png" alt="award-image" />
      </div>

      <p class="h3 m-0 text-white">You have completed this challenge</p>

      <div class="w-24 h-24">
        <img src="/public/img/award-image.png" alt="award-image" />
      </div>
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

<style scoped>
.animated-gradient-border {
  position: relative;
  padding: 2px; /* space for the border */
  border-radius: 8px;
  background: linear-gradient(
    270deg,
    #ff00cc,
    #3333ff,
    #00ffcc,
    #ffcc00,
    #ff00cc
  );
  background-size: 800% 800%;
  animation: borderMove 8s linear infinite;
}

.animated-gradient-border > * {
  border-radius: 6px;
  display: block;
  padding: 16px;
}

@keyframes borderMove {
  0% {
    background-position: 0% 50%;
  }
  100% {
    background-position: 100% 50%;
  }
}
</style>