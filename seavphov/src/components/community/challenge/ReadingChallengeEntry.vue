<template>
  <section class="ReadingChallengeEntry card p-4">
    <p class="h3">Create a reading challenge for your community members</p>
    <div>
      <p>✨ How It Works</p>
      <ul class="ml-4">
        <li>1️⃣ Set a Book</li>
        <li>2️⃣ Set a Goal - Define a start and end date.</li>
        <li>
          3️⃣ Challenge Your Friends - Invite others to join and read along!
        </li>
      </ul>
    </div>
    <div>
      <p>🔥 Why Start a Challenge?</p>
      <ul class="ml-4">
        <li>✅ Build a reading habit with accountability.</li>
        <li>✅ Engage in discussions and share insights.</li>
        <li>✅ Watch everyone's progress with real-time tracking!</li>
      </ul>
    </div>
    <p>
      📢 Ready to Lead the Challenge? Click <b>CREATE CHALLENGE</b> and let the
      reading begin! 🚀
    </p>
    <FwbButton
      @click="buildCreateChallengeRoute()"
      color="green"
      class="w-fit mt-3"
    >
      Create Challenge
    </FwbButton>
    <Info
      text="Only community admins can see this banner and create reading challenges."
      class="mt-2"
    />
  </section>
</template>

<script>
import { FwbButton } from "flowbite-vue";

export default {
  name: "ReadingChallengeEntry",
  components: { FwbButton },
  methods: {
    buildCreateChallengeRoute() {
      const route = this.$route.params.route;
      window.open(`/community/${route}/admin#tabs=create-challenge`);
    },
  },
};
</script>

<style></style>
