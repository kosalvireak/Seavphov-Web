<template>
  <section class="MemberProgressItem w-full">
    <div class="flex w-full space-x-4">
      <a :href="`/profile/${member.uuid}`" target="_blank" class="clickable">
        <FwbAvatar :img="member.picture" rounded size="lg" />
      </a>
      <FwbProgress
        class="w-full"
        :label="member.name"
        :progress="member.progress"
        label-position="outside"
        label-progress
        size="xl"
      />
    </div>
  </section>
</template>

<script>
import { FwbProgress } from "flowbite-vue";
export default {
  name: "MemberProgressItem",
  components: { FwbProgress },
  props: {
    member: Object,
    required: true,
  },
};
</script>

<style>
</style>