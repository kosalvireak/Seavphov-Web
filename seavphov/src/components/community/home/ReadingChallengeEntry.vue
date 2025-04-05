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
    <LoadingButton class="w-48 mt-4" @click="toRouteName('community-admin')"
      >Create Challenge</LoadingButton
    >
  </section>
</template>

<script>
export default {
  name: "ReadingChallengeEntry",
};
</script>

<style>
</style>