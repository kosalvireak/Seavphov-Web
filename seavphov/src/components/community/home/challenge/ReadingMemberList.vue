<template>
  <section
    class="ReadingMemberList flex-col space-y-4 bg-gray-100 p-2 rounded-lg max-h-40 overflow-auto"
  >
    <MemberProgressItem v-for="index in 5" :key="index" />
  </section>
</template>

<script>
import MemberProgressItem from "./MemberProgressItem.vue";
export default {
  name: "ReadingMemberList",
  components: { MemberProgressItem },
};
</script>

<style>
</style>