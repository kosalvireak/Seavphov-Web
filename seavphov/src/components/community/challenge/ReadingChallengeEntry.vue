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
    <a
      :href="buildCreateChallengeRoute()"
      class="w-fit mt-4 bg-sp-primary text-white p-2 px-3 rounded-lg"
      >Create Challenge</a
    >
    <Info
      text="Only community admins can see this banner and create reading challenges."
      class="mt-2"
    />
  </section>
</template>

<script>
export default {
  name: "ReadingChallengeEntry",
  methods: {
    buildCreateChallengeRoute() {
      const route = this.$route.params.route;
      return `/community/${route}/admin#tabs=create-challenge`;
    },
  },
};
</script>

<style></style>
