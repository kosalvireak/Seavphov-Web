<template>
  <section class="Discussion grid grid-cols-12 gap-4 w-100">
    <div class="col-span-3 bg-gray-400">Left</div>
    <div class="col-span-12 lg:col-span-6 mt-4 space-y-6">
      <DiscussionItem v-for="i in 10" :key="i" />
    </div>
    <div class="col-span-3 bg-green-400">Right</div>
  </section>
</template>

<script>
import DiscussionItem from "../components/discussion/DiscussionItem.vue";
export default {
  name: "Discussion",
  components: { DiscussionItem },
};
</script>

<style>
</style>